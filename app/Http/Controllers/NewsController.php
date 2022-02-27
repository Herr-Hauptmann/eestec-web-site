<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use DB;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        //Pretraga
        $keyword = $request->get('search');
        if (!empty($keyword)) {
            $news = News::
                    where('title', 'LIKE', "%$keyword%")
                    ->orderBy('created_at', 'desc')
                    -> paginate();
        }
        //Bez pretrage - ispisi sve
        else 
        {
            $news = News::orderBy('created_at', 'desc')->paginate(25);
        }

        
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $statement = DB::select("SHOW TABLE STATUS LIKE 'news'");
        $id = $statement[0]->Auto_increment;
        return view('admin.news.create', compact('id'));
    }
    
    public function store(Request $request)
    {
        //Validacija zahtjeva i kreiranje varijable
        $validiranZahtjev = $request->validate([
            'title' => 'required||max:255',
            'description' => 'required',
            'content' => 'required',
            'img_path' => 'required|image|max:5128'
        ]);
        if ($request['date']!=null)
        {
            $validiranZahtjev['created_at'] = $request['date'];
        }
        $validiranZahtjev['user_id']=auth()->user()->id;


        //Obrada slike
        $statement = DB::select("SHOW TABLE STATUS LIKE 'news'");
        $id = $statement[0]->Auto_increment;
        $ekstenzija = $request->file('img_path')->getClientOriginalExtension();
        //Kreiranje naziva slike
        $naziv = 'vijest'.'_'.time().'.'.$ekstenzija;
        // uplad image
        $path = $request->file('img_path')->storeAs('public/img/vijesti/'.$id.'/', $naziv);     
        //U bazi pamtimo samo ime
        $validiranZahtjev['img_path'] = $naziv;

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

        //Kreiranje vijesti
        $vijest = News::create($validiranZahtjev);
        return redirect(route('news.index'))->with('jsAlert', 'Uspjesno ste kreirali vijest!');
    }

    public function show(News $news)
    {
        //
    }

    public function edit($id)
    {
        $post = News::findOrFail($id);
        return view('admin.news.edit', compact('post', 'id'));
    }

    public function update(Request $request, $id)
    {
        //Validacija zahtjeva i kreiranje varijable
        $validiranZahtjev = $request->validate([
            'title' => 'required||max:255',
            'description' => 'required||max:255',
            'content' => 'required',
            'img_path' => 'image|max:5128'
        ]);
        if ($request['date']!=null)
        {
            $validiranZahtjev['created_at'] = $request['date'];
        }
        $validiranZahtjev['user_id']=auth()->user()->id;
        $vijest = News::findorfail($id);
        //Obrada slike
        if($request->hasFile('img_path')) {
            $ekstenzija = $request->file('img_path')->getClientOriginalExtension();
            //Kreiranje naziva slike
            $naziv = 'vijest'.'_'.time().'.'.$ekstenzija;
            // uplad image
            $path = $request->file('img_path')->storeAs('public/img/vijesti/'.$id.'/', $naziv);     
            //U bazi pamtimo samo ime
            $validiranZahtjev['img_path'] = $naziv;
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

            //Brisanje stare fotografije
            $old_photo=$vijest->img_path;
            Storage::delete('public/img/vijesti/'.$id.'/'.$old_photo);
        }

        //Kreiranje vijesti
        $vijest->update($validiranZahtjev);
        return redirect(route('news.index'))->with('jsAlert', 'Uspjesno ste izmjenili vijest '.$vijest->title.'!');
    }

    public function destroy(News $news)
    {
        $id = $news->id;
        $title = $news->title;
        $link = ('public/img/vijesti/'.$id);
        Storage::deleteDirectory($link);
        $news->delete();
        return redirect(route('news.index'))->with('jsAlert', 'Uspjesno ste izbrisali vijest '.$title.'!');
    }
}
