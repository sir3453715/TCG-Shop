@extends('layouts.app')

@section('content')
<div class="container register-form p-4">
    <div class="row justify-content-center">
        <h1 class="fs-40">註冊</h1>
            <form method="POST" action="{{ route('register') }}">
            <div class="form-group row mb-3">
                    <label for="name" class="col-form-label text-md-right">{{ __('姓名') }}</label>
                    <div class="col">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="請輸入姓名">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @csrf
                <div class="form-group row mb-3">
                    <label for="email" class="col-form-label text-md-right">{{ __('電子信箱') }}</label>
                    <div class="col">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="請輸入電子信箱">

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
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="請輸入密碼">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="password-confirm" class="col-form-label text-md-right">{{ __('確認密碼') }}</label>
                    <div class="col">
                        <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="確認密碼">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex mb-5">
                    <a href="{{route('login')}}" class="btn btn-md btn-md-yellow fs-5 w-50 me-2">
                        登入
                    </a>
                    <button type="submit" class="btn btn-md btn-md-black fs-5 w-50 ms-2">
                        註冊
                    </button>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <a id="account-social-btn-google" class="account-social-btn btn col-12 col-md-7" href="{{ route('SocialLogin',['provider'=>'google','redirectURL'=>'myAccount.dashboard']) }}">
                        <i class="fa-brands fa-google me-2"></i>使用 Google 註冊
                    </a>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <a id="account-social-btn-facebook" class="account-social-btn btn col-12 col-md-7"
                       href="{{ route('SocialLogin',['provider'=>'facebook','redirectURL'=>'myAccount.dashboard']) }}">
                        <i class="fa-brands fa-facebook-f me-2"></i>
                        使用 facebook 註冊
                    </a>
                </div>
                <div class="d-flex justify-content-center mb-5">
                    <a id="account-social-btn-line" class="account-social-btn btn col-12 col-md-7"
                       href="{{ route('SocialLogin',['provider'=>'line','redirectURL'=>'myAccount.dashboard']) }}">
                        <i class="fa-brands fa-facebook-f me-2"></i>
                        使用 Line 註冊
                    </a>
                </div>
                <input type="hidden" name="google_recaptcha" id="ctl-recaptcha-token">
            </form>
    </div>
</div>
@endsection

@push('app-scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}').then(function(token) {
                document.getElementById('ctl-recaptcha-token').value = token;
            });
        });
    </script>
@endpush