<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use DB;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function storeNewsImage(Request $request, $id=null){
        $validiranZahtjev = $request->validate([
            'upload' => 'required|image|max:5128'
        ]);

        $statement = DB::select("SHOW TABLE STATUS LIKE 'news'");
        $id = $statement[0]->Auto_increment;
        
        //Obrada slike
        $ekstenzija = $request->file('upload')->getClientOriginalExtension();
        //Kreiranje naziva slike
        $naziv = 'vijest'.'_'.time().'.'.$ekstenzija;
        // uplad image
        $path = $request->file('upload')->storeAs('public/img/vijesti/'.$id.'/', $naziv);     
        //U bazi pamtimo samo ime
        $validiranZahtjev['upload'] = $naziv;
 
        //Kompresuj sliku
        $filepath = public_path('storage/img/vijesti/'.$id.'/'.$naziv);
        $mime = mime_content_type($filepath);
        $output = new \CURLFile($filepath, $mime, $naziv);
        $data = ["files" => $output];
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty=40');
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result = curl_error($ch);
        }
        curl_close ($ch);
         
        $arr_result = json_decode($result);
        
        //Zamjeni obicnu verziju slike s kompresovanom
        $ch = curl_init($arr_result->dest);
        $fp = fopen($filepath, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        $link = url('/storage/img/vijesti/'.$id.'/'.$naziv);

        return response()->json([
            'url'=>$link
        ]);
    }

    public function deleteNewsImage(Request $request){
        $statement = DB::select("SHOW TABLE STATUS LIKE 'news'");
        $id = $statement[0]->Auto_increment;
        $link = ('public/img/vijesti/'.$id);
        Storage::deleteDirectory($link);
        return redirect(route('news.index'));
    }
}
