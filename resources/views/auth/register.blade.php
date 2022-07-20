@extends('layouts.app')
@section('scripts')
<script src="{{ asset('include/login.js') }}" defer></script>
@endsection

@section('logincss')
    <link rel="stylesheet" href='include/login.css'>
@endsection
@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
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
                        <li>Хувийн хаяг үүсгэх бол <a href="#0" class="t-signin">  Энд дар </a></li>
                    </ul>
                </nav>
                <div class="heading">
                    <h2>Нэвтрэх</h2>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <p>
                        <i class="el-icon-message"></i>
                        <input type="text" placeholder="И-мэйл" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus oninvalid="this.setCustomValidity('и-мэйл хаягийг оруулна уу')"
                        oninput="this.setCustomValidity('')">
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p>
                        <i class="el-icon-lock"></i>
                        <i class="el-icon-view" onclick="myFunction()"></i>
                        <input class="passwordshow" type="password" placeholder="Нууц үг" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password" oninvalid="this.setCustomValidity('Нууц үг оруулна уу')"
                        oninput="this.setCustomValidity('')">

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
                <div class="signin">
                <nav>
                    <ul>
                        <li></li>
                        <li>Хуучин хаягаар нэвтрэх бол<a href="#0" class="t-signup"> Энд дар</a></li>
                    </ul>
                </nav>
                <div class="heading">
                    <h2>Бүртгүүлэх</h2>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                        <p>
                            <i class="el-icon-user"></i>
                            <input type="text" placeholder="Нэр" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus oninvalid="this.setCustomValidity('Нэр оруулна уу')"
                            oninput="this.setCustomValidity('')">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p>
                            <i class="el-icon-message"></i>
                            <input type="email" placeholder="и-мэйл" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" oninvalid="this.setCustomValidity('и-мэйл хаягийг оруулна уу')"
                            oninput="this.setCustomValidity('') title='зөвхөн и-мэйл хаяг бичнэ үү'">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        
                        <p>
                            <i class="el-icon-lock"></i>
                            <i class="el-icon-view" onclick="myFunction()"></i>
                            <input class="passwordshow2" type="password" placeholder="Нууц үг" class="@error('password') is-invalid @enderror" name="password" required oninvalid="this.setCustomValidity('Нууц үг оруулна уу')"
                            oninput="this.setCustomValidity('')">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p>
                            <i class="el-icon-lock"></i>
                            <i class="el-icon-view" onclick="myFunction()"></i>
                            <input class="passwordshow3" type="password" placeholder="Нууц үг дахин оруулна уу" name="password_confirmation" oninvalid="this.setCustomValidity('Нууц үг оруулна уу')"
                            oninput="this.setCustomValidity('')">
                        </p>
                        <div class="actions">
                            <label>
                                <input type="submit" value="{{ __('Бүртгүүлэх') }}">
                                <i class="ri-arrow-right-line"></i>
                            </label>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
