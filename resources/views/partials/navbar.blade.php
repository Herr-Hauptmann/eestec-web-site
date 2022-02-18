<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/') }}"><img class="logo" src="{{ url('img/logo.png') }}" alt="EESTEC LC Sarajevo"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Početna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Novosti</a>
          </li>     
          <li class="nav-item">
            <a class="nav-link disabled" href="#">O nama</a>
          </li>     
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Partneri</a>
          </li>     
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Događaji</a>
          </li>     
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Kontakt</a>
          </li>     
            @if (Route::has('login'))
            <li class="nav-item">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link active">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link active">Admin</a>
                @endauth
            </li>
            @endif   
        </ul>
      </div>
    </div>
  </nav>