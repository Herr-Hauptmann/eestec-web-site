<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card shadow m-1">
                    <div class="card-header d-flex justify-content-between">
                        <p class="text-dark d-inline font-weight-bold mt-2">Novosti</p>
                        <a href="{{route('news.create')}}"><button type="button" class="btn btn-dark">Dodaj novost</button></a>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row justify-content-end">
                                <form action="{{ url()->current() }}" method="GET" role="search">
                                    <div class="col-4">
                                        <input class="form-control" type="search" name="search" placeholder="Pretraga" aria-label="Pretraga">
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Pretraži</button>
                                    </div>
                                </form>
                            </div>
                        </form>
                        <table class="table table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Naziv</th>
                                    <th>Ime autora</th>
                                    <th>Datum objave</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $post)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration + ($news->currentPage() - 1) * 25 }}</td>
                                    <td class="align-middle">{{$post->title}}</td>
                                    <td class="align-middle">{{$post->user->name}}</td>
                                    <td class="align-middle">{{$post->created_at->toDateString()}}</td>
                                    <td class="d-flex justify-content-end">
                                        <a href="{{route('news.show', $post->id)}}" class="btn btn-outline-dark">Pogledaj</a>
                                        <a href="{{route('news.edit', $post->id)}}" class="btn btn-outline-success ml-2">Uredi</a>
                                        <a id="deleteTrigger" data-bs-toggle="modal" data-bs-target="#deletePost" data-route="{{ route('news.destroy', $post->id) }}" data-naziv="{{$post->title}}"  class="btn btn-outline-danger ml-2">Briši</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="">
                              {{ $news->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.news.delete')
    @if(session()->has('jsAlert'))
        <script>
            alert("{{ session()->get('jsAlert') }}");
        </script>
    @endif
    <script>
        let button = document.getElementById('deleteTrigger');
        button.addEventListener('click', ()=>{
            let modal = document.getElementById('deletePost');
            let naziv = button.dataset.naziv;
            let ruta = button.dataset.route;
            document.getElementById('tijelo').innerHTML = "Da li ste sigurni da želite izbrisati vijest " + naziv + "?!";
            document.getElementById('formaBrisanje').action=ruta;
        });
    </script>
</x-app-layout>
