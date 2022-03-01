<div class="container">
    <div class="row">
        <h2 class="text-center mb-5 naslov">Novosti</h2>
    </div>
    <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
        <div class="row">
            <div class="col-md-6 px-0">
                <h1 class="display-4 fst-italic">{{$news[0]->title}}</h1>
                <p class="lead my-3">{{$news[0]->description}}</p>
                <p class="lead mb-0"><a href="{{route('news.show', $news[0]->id)}}" class="text-white fw-bold">Saznaj više...</a></p>
              </div>
              <a class="order-first order-md-last col-md-6 my-3" href="{{route('news.show', $news[0]->id)}}" >
                    <img class="img-thumbnail" src="{{ asset('storage/img/vijesti/'.$news[0]->id.'/'.$news[0]->img_path) }}" alt="">
              </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-3">
            @foreach ($news as $post)
                @if ($loop->first)
                    @continue
                @endif
            <div class="col-md-6 my-2">
                <div class="row g-2 border rounded overflow-hidden flex-md-row shadow-sm h-100 position-relative">
                    <div class="col-8 p-4 d-flex flex-column position-static ">
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
    </div>
    <div class="container mb-4">
        <div class="row justify-content-end">
            <div class="col-2">
                <a class="btn btn-outline-dark d-block" href="{{route('news')}}">
                    Pogledaj sve novosti
                </a>
            </div>
        </div>
    </div>
</div>