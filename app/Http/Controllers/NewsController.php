<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(25);
        foreach ($news as $article)
            $article['user_name'] = User::where('id',$article->user_id)->firstOrFail()->name;
        /*
        TO DO
        - Dodati text editor
        - Implementirati serach
        - Uraditi edit
        - Uraditi delete
        - Uraditi show
        - Dizajnirati prikaz na welcome page-u
        - Dodati preview izgleda naslova
        - Dodati preview izgleda clanka
        - Migrirati stare vijesti
        */
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }
    
    public function store(Request $request)
    {
        //Validacija zahtjeva i kreiranje varijable
        $validiranZahtjev = $request->validate([
            'title' => 'required||max:255',
            'description' => 'required||max:255',
            'content' => 'required',
            'img_path' => 'required|image'
        ]);
        if ($request['date']!=null)
        {
            $validiranZahtjev['created_at'] = $request['date'];
        }
        $validiranZahtjev['user_id']=auth()->user()->id;

        //Obrada slike
        $ekstenzija = $request->file('img_path')->getClientOriginalExtension();
        //Kreiranje naziva slike
        $naziv = 'vijest'.'_'.time().'.'.$ekstenzija;
        // uplad image
        $path = $request->file('img_path')->storeAs('public/img/vijesti/', $naziv);     
        //U bazi pamtimo samo ime
        $validiranZahtjev['img_path'] = $naziv;

        //Kompresuj sliku
        $filepath = public_path('storage/img/vijesti/'.$naziv);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
