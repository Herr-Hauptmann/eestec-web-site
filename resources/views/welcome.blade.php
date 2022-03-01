@extends('layouts.layout')
@section('css')
<link rel="stylesheet" href="{{ url('/css/home.css')}}">
@endsection

@section('body')
    <div id="cov" class="cover block">
        @include('partials.navbar')
        @include('landing.naslovna')
    </div>
    <div class="mt-5"></div>
    @include('landing.news')
    @include('partials.footer')

@endsection
