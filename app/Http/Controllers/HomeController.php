<?php

namespace App\Http\Controllers;
use App\Models\News;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }
}
