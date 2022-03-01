@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('body')
    @include('partials.navbar')
    <div class="container">
        <div class="row">
        <h2 class="text-center mb-5 naslov-dijela mt-4">Novosti</h2>
    </div>
        <div class="row mb-3">
            @foreach ($news as $post)
            <div class="col-md-6  my-2">
                <div class="row g-2 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-100 position-relative">
                    <div class="col-8 p-4 d-flex flex-column position-static">
                        {{-- Ovo ispod koristiti ako kad dodamo kategorije vijesti --}}
                        {{-- <strong class="d-inline-block mb-2 text-primary">World</strong> --}}
                        <h3 class="mb-0">{{$post->title}}</h3>
                        <div class="mb-1 text-muted">{{$post->timestamp}}</div>
                        <p class="card-text mb-auto">{{$post->description}}</p>
                        <a href="{{route('news.show', $post->id)}}" class="stretched-link">Saznaj više...</a>
                    </div>
                    <div class="col-4 d-block order-first order-md-last">
                        <img class="img-thumbnail mr-3 my-3" src="{{ asset('storage/img/vijesti/'.$post->id.'/'.$post->img_path) }}" alt="">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="">
              {{ $news->links() }}
            </div>
        </div>
    </div>
    @include('partials.footer')
@endsection