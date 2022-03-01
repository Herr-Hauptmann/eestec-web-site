<?php

namespace App\Http\Controllers;
use App\Models\News;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class HomeController extends Controller
{
    public function index(){
        $news = News::orderBy('created_at', 'desc')->take(5)->get();
        return view('welcome', compact('news'));
    }
}
