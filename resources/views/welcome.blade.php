@extends('layouts.layout')
@section('css')
<link rel="stylesheet" href="{{ url('/css/home.css')}}">
@endsection

@section('body')
<div id="cov" class="cover block">
    @include('partials/navbar')
    @include('partials/naslovna')
</div>
@endsection
