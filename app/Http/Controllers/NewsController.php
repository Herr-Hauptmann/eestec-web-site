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
        $path = $request->file('img_path')->storeAs('public/img/proizvodi/', $naziv);     
        //U bazi pamtimo samo ime
        $validiranZahtjev['img_path'] = $naziv;

        //Kreiranje vijesti
        $vijest = News::create($validiranZahtjev);
        return redirect(route('news.index'))->with('jsAlert', 'Uspjesno ste kreirali vijest!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
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
