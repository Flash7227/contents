
  <nav class="navbar navbar-expand-lg nav-new navbar-dark">
    <div class="container">
    <a class="navbar-brand ml-2" href="/">
        <img src="/imgs/logo-white.png" width="auto" height="40" class="navbar-image"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item mainlink {{ Request::path() == 'home' ? 'active' : ''}} ml-4">
                <a id="nav-mainpage" class="nav-link " href="/home">Нүүр
                </a>
            </li>
            <li class="nav-item mainlink {{ Request::path() == 'home/blog' ? 'active' : ''}}">
                <a class="nav-link " href="/home/blog">Нийтлэл
              </a>
            </li>
            <li class="nav-item mainlink {{ Request::path() == 'home/video' ? 'active' : ''}}">
            <a class="nav-link " href="/home/video">Видео</a>
            </li>
            <li class="nav-item mainlink {{ Request::path() == 'home/poster' ? 'active' : ''}}">
            <a class="nav-link " href="/home/poster">Постер</a>
            </li>
            <li class="nav-item mainlink {{ Request::path() == 'home/file' ? 'active' : ''}}">
            <a class="nav-link " href="/home/file">Файл</a>
            </li>
            @auth
                @if(Auth()->user()->role == 1)
                    <li class="nav-item  mainlink dropdown {{ Request::path() == 'admin/users' ? 'active' : ''}} {{ Request::path() == 'admin/uploads' ? 'active' : ''}} {{ Request::path() == 'admin/tags' ? 'active' : ''}}">
                    <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Админ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/admin/user">Хэрэглэгчид</a>
                        <a class="dropdown-item" href="/admin/uploads">Файлууд</a>
                        <a class="dropdown-item" href="/admin/tags">#TAG</a>
                        <a class="dropdown-item" href="/admin/logs">LOGS</a>
                    </div>
                    </li>
                @endif
            @endauth
          </ul>
      <ul class="navbar-nav">
        @guest
        <li class="nav-item {{ Request::path() == 'login' ? 'active' : ''}}">
            <a id="login-button" class="nav-link" href="/login"><i class="el-icon-caret-right"></i> Нэвтрэх</a>
        </li>
        @else 
        <li class="nav-item dropdown {{ str_contains(Request::path(), 'admin') ? 'active' : ''}}">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="el-icon-user"></i> {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/user/upload"><i class="el-icon-document"></i> Файл хуулах</a>
              <a class="dropdown-item" href="/user/shared"><i class="el-icon-share"></i> Хуваалцсан файл</a>
              <a class="dropdown-item" href="/user/profile"><i class="el-icon-user"></i> Миний хаяг</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"><i class="el-icon-switch-button"></i>
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



