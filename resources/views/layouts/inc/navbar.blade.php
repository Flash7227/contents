

  <nav class="navbar navbar-expand-lg navbar-dark nav-new">
    
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="/imgs/logo-white.png" width="auto" height="45" class="navbar-image"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li  class="nav-item {{ Request::path() == 'home' ? 'active' : ''}} ml-4">
          <a id="nav-mainpage" class="nav-link mainlink" href="/home">Нүүр
          </a>
      </li>
      {{-- <li class="nav-item dropdown ml-2 {{ Request::path() == 'home/niitlel' ? 'active' : ''}} {{ Request::path() == 'home/video' ? 'active' : ''}} {{ Request::path() == 'home/poster' ? 'active' : ''}} {{ Request::path() == 'home/file' ? 'active' : ''}}">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Нээлттэй Контент
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/home/niitlel">Блог</a>
          <a class="dropdown-item" href="/home/video">Бичлэг</a>
          <a class="dropdown-item" href="/home/poster">Постер</a>
          <a class="dropdown-item" href="/home/file">Файл</a>
        </div>
      </li> --}}
        @auth
        {{-- <li class="nav-item dropdown {{ Request::path() == 'user/upload' ? 'active' : ''}} {{ Request::path() == 'user/shared' ? 'active' : ''}}">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Файл
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/user/upload">Файл хуулах</a>
            <a class="dropdown-item" href="/user/shared">Хуваалцсан файл</a>
          </div>
        </li> --}}
        
        <li class="nav-item {{ Request::path() == 'home/blog' ? 'active' : ''}}">
          <a class="nav-link mainlink" href="/home/blog">Блог
        </a>
        </li>
        <li class="nav-item {{ Request::path() == 'home/video' ? 'active' : ''}}">
          <a class="nav-link mainlink" href="/home/video">Видео</a>
        </li>
        <li class="nav-item {{ Request::path() == 'home/poster' ? 'active' : ''}}">
          <a class="nav-link mainlink" href="/home/poster">Постер</a>
        </li>
        <li class="nav-item {{ Request::path() == 'home/file' ? 'active' : ''}}">
          <a class="nav-link mainlink" href="/home/file">Файл</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li> --}}
        {{-- @if(Auth()->user()->role === 1)
        <li class="nav-item dropdown {{ Request::path() == 'admin/user' ? 'active' : ''}} {{ Request::path() == 'admin/uploads' ? 'active' : ''}}">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Админ
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/admin/user">Хэрэглэгчид</a>
            <a class="dropdown-item" href="/admin/uploads">Хэрэглэгчдийн хуулсан файл</a>
          </div>
        </li>
        @endif --}}
        @endauth
      </ul>
      <ul class="navbar-nav">
        @guest
        {{-- <li class="nav-item {{ Request::path() == 'register' ? 'active' : ''}}">
            <a class="nav-link" href="/register"><i class="ri-login-box-line"></i> Нэвтрэх</a>
        </li> --}}
        <li class="nav-item {{ Request::path() == 'login' ? 'active' : ''}}">
            <a id="login-button" class="nav-link" href="/login"><i class="el-icon-caret-right"></i> Нэвтрэх</a>
        </li>
        @else 
        <li class="nav-item dropdown {{ str_contains(Request::path(), 'admin') ? 'active' : ''}}">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="el-icon-user-solid"></i> {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              @if(Auth()->user()->role === 1)
              <a class="dropdown-item" href="/user/upload">Файл хуулах</a>
              <a class="dropdown-item" href="/user/shared">Хуваалцсан файл</a>
              <a class="dropdown-item" href="/admin/uploads">Хэрэглэгчдийн хуулсан файл</a>
              <a class="dropdown-item" href="/admin/user">Хэрэглэгчид</a>
              @endif
              @if(Auth()->user()->role === 0 || Auth()->user()->role === 2 || Auth()->user()->role === 1)
              <a class="dropdown-item" href="/user/profile">Миний хаяг</a>
              @endif
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    Гарах
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        @endguest
      </ul>
    </div>
    </div>
  </nav>




