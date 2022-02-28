@extends('layouts.layout')
@section('css')
<link rel="stylesheet" href="{{ url('/css/news.css')}}">
<link rel="stylesheet" href="{{ url('/css/social.css')}}">
@endsection
@section('body')
    @include('partials.navbar')
    <div id="cov" class="cover block" style="background:url('{{ asset('storage/img/vijesti/'.$post->id.'/'.$post->img_path) }}') no-repeat center center fixed;    background-size: cover;">
        <div class="prva"></div>
        <div class="naslov">
         <h1>{{ $post->title }}</h1>
        </div>
        <img class="slika" src="{{ url('/img/down.png') }}"/>
    </div>
    
    <div class="container">
        <div class="row mt-5">
        @include('partials.social')
        <div class="col-md-8">
            <h1 class="podnaslov text-center">{{$post->title}}</h1>
            <div class="row mt-3 mb-5">
                <div class="col-6 ">
                    {{ date('d.m.Y', $post->timestamp) }}
                </div>
                <div class="col-6 text-end">
                    {{$post->user->name}}
                </div>
            </div>
            <span class="content mt-3">
                {!! $post->content !!}
            </span>
        </div>
        </div>
    </div>
@include('partials.footer')
@endsection

