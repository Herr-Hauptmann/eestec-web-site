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
                                <div class="col-4">
                                    <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    {{-- <div class="row d-flex justify-content-between">
                            <form class="col-1" action="{{ url()->current() }}">
                            </form>
                            <form class="form-inline ml-auto mt-2 mt-lg-0" method="GET"
                                action="{{ url()->current() }}" role="search">
                                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search...."
                                    value="{{ request('search') }}" aria-label="Search">
                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div> --}}
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
                                    <td class="align-middle">Tarik Horozovic</td>
                                    <td class="align-middle">{{$post->created_at}}</td>
                                    <td class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-success">Uredi</button>
                                        <a class="btn btn-outline-danger ml-2">Briši</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>