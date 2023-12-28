@extends('layouts.app')

@section('content')
<div class="container login-form p-4">
    <div class="row justify-content-center">
        <h1 class="fs-40">登入</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group row mb-3">
                    <label for="email" class="col-form-label text-md-right">{{ __('電子信箱') }}</label>
                    <div class="col">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="請輸入電子信箱">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="password" class="col-form-label text-md-right">{{ __('密碼') }}</label>
                    <div class="col">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            required autocomplete="current-password" placeholder="請輸入密碼">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @if (Route::has('password.request'))
                    <a class="form-text text-decoration-none" href="{{ route('password.request') }}">
                        {{ __('忘記密碼') }}
                    </a>
                    @endif
                </div>
                <div class="d-flex mb-5">
                    <button type="submit" class="btn btn-md btn-md-yellow fs-5 w-50 me-2">
                        登入
                    </button>
                    <button type="submit" class="btn btn-md btn-md-black fs-5 w-50 ms-2">
                        註冊
                    </button>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <a id="account-social-btn-google" class="account-social-btn btn col-12 col-md-7" href="{{ route('SocialLogin',['provider'=>'google','redirectURL'=>'myAccount.dashboard','binding'=>1]) }}">
                        <i class="fa-brands fa-google me-2"></i>使用 Google 註冊
                    </a>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <a id="account-social-btn-facebook" class="account-social-btn btn col-12 col-md-7"
                        href="{{ route('SocialLogin',['provider'=>'facebook','redirectURL'=>'index']) }}">
                        <i class="fa-brands fa-facebook-f me-2"></i>
                        使用 facebook 註冊
                    </a>
                </div>
{{--                <div class="d-flex justify-content-center mb-5">--}}
{{--                    <a id="account-social-btn-line" class="account-social-btn btn col-12 col-md-7"--}}
{{--                        href="{{ route('SocialLogin',['provider'=>'facebook','redirectURL'=>'index']) }}">--}}
{{--                        <i class="fa-brands fa-facebook-f me-2"></i>--}}
{{--                        使用 Line 註冊--}}
{{--                    </a>--}}
{{--                </div>--}}
            </form>
    </div>
</div>
@endsection