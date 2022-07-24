
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="/imgs/logo-white.png" width="auto" height="40"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        @auth
        <li class="nav-item {{ Request::path() == 'home' ? 'active' : ''}}">
            <a class="nav-link" href="/home">Үндсэн нүүр
            </a>
        </li>
        <li class="nav-item {{ Request::path() == 'user/upload' ? 'active' : ''}}">
          <a class="nav-link" href="/user/upload">Файл хуулах
        </a>
        </li>
        <li class="nav-item {{ Request::path() == 'user/shared' ? 'active' : ''}}">
            {{-- <span class="badge badge-pill badge-primary" style="float:right;margin-bottom:-10px;">1</span> <!-- your badge --> --}}
          <a class="nav-link" href="/user/shared">Хуваалцсан файл</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li> --}}
        @endauth
      </ul>
      <ul class="navbar-nav">
        @guest
        {{-- <li class="nav-item {{ Request::path() == 'register' ? 'active' : ''}}">
            <a class="nav-link" href="/register"><i class="ri-login-box-line"></i> Нэвтрэх</a>
        </li> --}}
        <li class="nav-item {{ Request::path() == 'login' ? 'active' : ''}}">
            <a class="nav-link" href="/login">Нэвтрэх</a>
        </li>
        @else 
        <li class="nav-item dropdown {{ str_contains(Request::path(), 'admin') ? 'active' : ''}}">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="el-icon-user-solid"></i> {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              @if(Auth()->user()->role === 1)
              <a class="dropdown-item" href="/admin/user">Хэрэглэгчид</a>
              <a class="dropdown-item" href="/admin/uploads">Хяналт</a>
              @endif
              @if(Auth()->user()->role === 0 || Auth()->user()->role === 2 || Auth()->user()->role === 1)
              <a class="dropdown-item" href="/admin/profile">Миний хаяг</a>
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
  