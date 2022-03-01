<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;


use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use DB;

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

    public function show($id)
    {
        $post = News::findOrFail($id);

		SEOMeta::setTitle($post->title);
		SEOMeta::setDescription($post->description);
		SEOMeta::addKeyword(['eestec', 'lc sarajevo', 'sarajevo', 'novosti', 'eestec lc sarajevo', 'eestec lk sarajevo', 'lokalni komitet sarajevo']);

		OpenGraph::setDescription($post->description);
		OpenGraph::setTitle($post->title);
		OpenGraph::setUrl('http://www.eestec-sa.ba/posts/'.$post->id);

		OpenGraph::addImage('http://www.eestec-sa.ba/static/'.$post->img_path);
		OpenGraph::addImage(['url' => 'http://www.eestec-sa.ba/static/'.$post->img_path, 'size' => 300]);
		OpenGraph::addImage('http://www.eestec-sa.ba/static/'.$post->img_path, ['height' => 300, 'width' => 300]);

		return view('admin.news.show', compact('post'));
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

    public function showAll()
    {
        SEOMeta::setTitle("Novosti");
        SEOMeta::setDescription("EESTEC LC Sarajevo - najnovije novosti vezane za Lokalni komitet Sarajevo, EESTEC International, naše projekte i naše partnere.");
        SEOMeta::addKeyword(['eestec', 'lc sarajevo', 'sarajevo', 'novosti', 'eestec lc sarajevo', 'eestec lk sarajevo', 'lokalni komitet sarajevo']);

        OpenGraph::setDescription("EESTEC LC Sarajevo - najnovije novosti vezano za Lokalni komitet Sarajevo, EESTEC International, naše projekte i naše partnere.");
        OpenGraph::setTitle("Novosti");
        OpenGraph::setUrl('http://www.eestec-sa.ba/news');

        OpenGraph::addImage('http://www.eestec-sa.ba/img/cover.png');
        OpenGraph::addImage(['url' => 'http://www.eestec-sa.ba/img/cover.png', 'size' => 300]);
		OpenGraph::addImage('http://www.eestec-sa.ba/img/cover.png', ['height' => 300, 'width' => 300]);

        $news = News::orderBy('created_at', 'desc')->paginate(25);
        return view('news', compact('news'));
    }
}
