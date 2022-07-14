
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="/">
        <img src="/imgs/logo-white.png" width="auto" height="40"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        @auth
        <li class="nav-item active">
          <a class="nav-link" href="/">Үндсэн нүүр <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/user/upload">Файл хуулах</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/user/files">Хуваалцсан файл</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li> --}}
        @endauth
      </ul>
      <ul class="navbar-nav">
        @guest
        <li class="nav-item">
            <a class="nav-link" href="/register">Бүртгүүлэх</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/login">Нэвтрэх</a>
        </li>
        @else 
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        @endguest
      </ul>
    </div>
  </nav>