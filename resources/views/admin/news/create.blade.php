<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card shadow m-1">
                    <div class="card-header d-flex justify-content-between">
                        <p class="text-dark d-inline font-weight-bold mt-2">Kreiraj novost</p>
                    </div>
                    <div class="card-body">
                        <form action="{{route('news.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap" id="title_label">Naslov novosti</span>
                                <input type="text" class="form-control" aria-label="title" aria-describedby="title_label" name="title" value="{{old('title')}}">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap">Opis novosti</span>
                                <textarea rows="5" class="form-control" aria-label="description" name="description" id="description" value="{{old('description')}}"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap">Sadržaj novosti</span>
                                <textarea rows="5" class="form-control editor" aria-label="content" id="content" name="content" value="{{old('content')}}"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap" id="date_label">Promjeni datum objave</span>
                                <input type="date" class="form-control" aria-describedby="date_label"id="date" name="date" value="{{old('date')}}" data-date-format="DD MMMM YYYY" placeholder="dd-mm-yyyy">
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text col-2 justify-content-center text-wrap" id="image_label" for="img_path">Odaberi sliku</label>
                                <input type="file" class="form-control" id="img_path" name="img_path" aria-describedby="image_label" aria-label="Upload"
                                accept="image/png, image/jpeg, image/jpg, image/gif" value="{{ old('img_path') }}">
                            </div>
                            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                                <button type="submit" class="btn btn-success mb-1 col-12 col-md-2">Objavi vijest</button>
                                <div class="d-flex flex-column flex-md-row justify-content-md-center col-12 col-md-6">
                                    <button type="button" id="show-heading" class="btn btn-warning mb-1 col-12 col-md-5 mx-md-1">Pogledaj naslov</button>
                                    <button type="button" id='show-article' class="btn btn-warning mb-1 col-12 col-md-5 mx-md-1">Pogledaj vijest </button>
                                </div>
                                <a href="{{route('news.image.delete')}}" class="btn btn-danger mb-1 col-md-2 col-12">Odustani</a>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    @include('admin.texteditor')
    <script src="{{ url('/js/novosti.js')}}"></script>
</x-app-layout>
