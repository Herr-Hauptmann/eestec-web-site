<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card shadow m-1">
                    <div class="card-header d-flex justify-content-between">
                        <p class="text-dark d-inline font-weight-bold mt-2">Kreiraj novost</p>
                    </div>
                    <div class="card-body">
                        <form action="{{route('news.update', $post->id)}}" method="POST" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap" id="title_label">Naslov novosti</span>
                                <input type="text" class="form-control" aria-label="title" aria-describedby="title_label" name="title" value="{{old('title') ?? $post->title}}" required>
                            </div>
                            @if ($errors->first('title'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap">Opis novosti</span>
                                <textarea rows="5" class="form-control" aria-label="description" name="description" id="description" required> {{old('description') ?? $post->description}}</textarea>
                            </div>
                            @if ($errors->first('description'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap">Sadržaj novosti</span>
                                <textarea rows="5" class="form-control editor" aria-label="content" id="content" name="content">{{old('content') ?? $post->content}}</textarea>
                            </div>
                            @if ($errors->first('content'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('content') }}
                                </div>
                            @endif
                            <div class="input-group mb-3">
                                <span class="input-group-text col-2 justify-content-center text-wrap" id="date_label">Promjeni datum objave</span>
                                <input type="date" class="form-control" aria-describedby="date_label"id="date" name="date" data-date-format="DD MMMM YYYY" placeholder="dd-mm-yyyy">
                            </div>
                            @if ($errors->first('date'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('date') }}
                                </div>
                            @endif

                            <div class="input-group mb-3" id="image-parent">
                                <label class="input-group-text col-2 justify-content-center text-wrap" id="show-image-label">Odabrana slika</label>
                                <img id="output" src="{{ asset('storage/img/vijesti').'/'.$post->id.'/'.$post->img_path}}" class="show-image" width='50%'/>
                            </div>

                            <div class="input-group mb-3">
                                <label class="input-group-text col-2 justify-content-center text-wrap" id="image_label" for="img_path" >Odaberi sliku</label>
                                <input type="file" class="form-control" id="img_path" name="img_path" aria-describedby="image_label" aria-label="Upload"
                                accept="image/png, image/jpeg, image/jpg, image/gif">
                            </div>
                            @if ($errors->first('img_path'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('img_path') }}
                                </div>
                            @endif
                            
                            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-3">
                                <button type="submit" class="btn btn-success mb-1 col-12 col-md-2">Objavi vijest</button>
                                <div class="d-flex flex-column flex-md-row justify-content-md-center col-12 col-md-6">
                                    <button type="button" id="show-heading" class="btn btn-warning mb-1 col-12 col-md-5 mx-md-1">Pogledaj naslov</button>
                                    <button type="button" id='show-article' class="btn btn-warning mb-1 col-12 col-md-5 mx-md-1">Pogledaj vijest </button>
                                </div>
                                <a href="{{route('news.index')}}" class="btn btn-danger mb-1 col-md-2 col-12">Odustani</a>
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
