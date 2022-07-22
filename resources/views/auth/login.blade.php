<link href="{{ asset('include/login.css') }}" rel="stylesheet" type="text/css" >
@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div id="page" class="site">
    <div class="container">
        <div class="theform">
            <div class="play">
                <div class="wrapper">
                    <div class="card one"></div>
                    <div class="card two"></div>
                    <div class="card three"></div>
                    <div class="card four"></div>
                    <div class="card five"></div>
                </div>
            </div>
            <div class="signup">
                <nav>
                    <ul>
                        <li></li>
                        <li>Шинээр бүртгүүлэх бол <a href="#0" class="t-signin">  Энд дар</a></li>
                    </ul>
                </nav>
                <div class="heading">
                    <h2>Нэвтрэх</h2>
                </div>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                        <p>
                            <i class="ri-user-3-line"></i>
                            <input type="text" placeholder="Нэр" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p>
                            <i class="ri-mail-line"></i>
                            <input type="email" placeholder="E-Mail" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p>
                            <i class="ri-lock-line"></i>
                            <i class="ri-eye-off-line" onclick="myFunction()"></i>
                            <input class="passwordshow2" type="password" placeholder="Нууц үг" class="@error('password') is-invalid @enderror" name="password" required>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p>
                            <i class="ri-lock-line"></i>
                            <i class="ri-eye-off-line" onclick="myFunction()"></i>
                            <input class="passwordshow3" type="password" placeholder="Нууц үг дахин оруулна уу" name="password_confirmation" required>
                        </p>
                        <div class="actions">
                            <label>
                                <input type="submit" value="{{ __('Бүртгүүлэх') }}">
                                <i class="ri-arrow-right-line"></i>
                            </label>
                        </div>
                </form>

                
                </div>
                <div class="signin">
                <nav>
                    <ul>
                        <li></li>
                        <li>Хуучин хаягаар нэвтрэх бол <a href="#0" class="t-signup"> Энд дар</a></li>
                    </ul>
                </nav>
                <div class="heading">
                    <h2> Бүртгүүлэх</h2>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <p>
                        <i class="ri-user-3-line"></i>
                        <input type="text" placeholder="И-мэйл" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p>
                        <i class="ri-lock-line"></i>
                        <i class="ri-eye-off-line" onclick="myFunction()"></i>
                        <input class="passwordshow" type="password" placeholder="Нууц үг" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </p>
                    <div class="actions">
                        <label>
                            <input type="submit" value="Нэвтрэх">
                            <i class="ri-arrow-right-line"></i>
                        </label>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
