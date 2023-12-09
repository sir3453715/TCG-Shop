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
                            <a id="social-btn-g" class="btn col-12 col-md-7"
                                href="{{ route('SocialLogin',['provider'=>'google','redirectURL'=>'index']) }}">
                                <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="30px" viewBox="0 0 326667 333333"
                                    shape-rendering="geometricPrecision" text-rendering="geometricPrecision"
                                    image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M326667 170370c0-13704-1112-23704-3518-34074H166667v61851h91851c-1851 15371-11851 38519-34074 54074l-311 2071 49476 38329 3428 342c31481-29074 49630-71852 49630-122593m0 0z"
                                        fill="#4285f4" />
                                    <path
                                        d="M166667 333333c44999 0 82776-14815 110370-40370l-52593-40742c-14074 9815-32963 16667-57777 16667-44074 0-81481-29073-94816-69258l-1954 166-51447 39815-673 1870c27407 54444 83704 91852 148890 91852z"
                                        fill="#34a853" />
                                    <path
                                        d="M71851 199630c-3518-10370-5555-21482-5555-32963 0-11482 2036-22593 5370-32963l-93-2209-52091-40455-1704 811C6482 114444 1 139814 1 166666s6482 52221 17777 74814l54074-41851m0 0z"
                                        fill="#fbbc04" />
                                    <path
                                        d="M166667 64444c31296 0 52406 13519 64444 24816l47037-45926C249260 16482 211666 1 166667 1 101481 1 45185 37408 17777 91852l53889 41853c13520-40185 50927-69260 95001-69260m0 0z"
                                        fill="#ea4335" /></svg>
                                使用 Google 註冊
                            </a>
                        </div>
                        <div class="d-flex justify-content-center mb-5">
                            <a id="social-btn-f" class="btn col-12 col-md-7"
                                href="{{ route('SocialLogin',['provider'=>'facebook','redirectURL'=>'index']) }}">
                                <i class="fa-brands fa-facebook-f me-2"></i>
                                使用 facebook 註冊
                            </a>
                        </div>
                    </form>
    </div>
</div>
@endsection