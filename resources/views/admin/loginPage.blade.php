<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Colorlib">
    <title>TCG Shop後台系統</title>
    <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/custom-admin.css') }}" rel="stylesheet">
    <style>
        .login-bg {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: -1;
            background: url("{{asset('storage/image/background1.png')}}") center center no-repeat;
            background-size: cover;
        }
        #facebook-login{
            background: #3c66c4;
            color: WHITE;
            padding: 5px;
            border-radius:5px;
        }
        #google-login{
            background: #cf4332;
            color: WHITE;
            padding: 5px;
            border-radius:5px;
        }
        .top-40{
            top: 40%;
        }
    </style>
</head>
<body class="fix-header fix-sidebar">
    <section class="content login-bg">

        @error('email')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror
        @error('password')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror
        @if (\Session::has('message'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {!! \Session::get('message') !!}
            </div>
        @endif
        @if (\Session::has('Errormessage'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {!! \Session::get('Errormessage') !!}
            </div>
        @endif
        <div class="container-fluid">
            <div class="col-12 col-md-4 position-absolute top-40 start-50 translate-middle">
                <div class="card card-warning">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="col-md-12 row text-center">
                                        <div class="form-group col-12">
                                            <label class="field-name" for="title">帳號</label>
                                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="field-name" for="dateTime">密碼</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        </div>
                                        <div class="form-group col-12">
                                            <a href="{{ route('SocialLogin',['provider'=>'facebook','redirectURL'=>'admin.index']) }}" id="facebook-login" class="btn col-6">Facebook 登入</a>
                                        </div>
                                        <div class="form-group col-12">
                                            <a href="{{ route('SocialLogin',['provider'=>'google','redirectURL'=>'admin.index']) }}" id="google-login" class="btn col-6">Google 登入</a>
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">記得我</label>
                                        </div>
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-primary">登入</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
<!-- Main wrapper  -->
{{--<div class="c-body login-bg">--}}
{{--    <main class="c-main">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="container">--}}
{{--                <div class="row justify-content-center">--}}
{{--                    <div class="col-lg-4">--}}
{{--                        <div class="login-content card">--}}
{{--                            <div class="login-form">--}}
{{--                                <h4 class="login-form-title">系統登入</h4>--}}
{{--                                <form method="POST" action="{{ route('login') }}">--}}
{{--                                    <input id="login_by" type="hidden"  name="login_by" value="admin">--}}
{{--                                    @csrf--}}
{{--                                    <input id="loginFlag" type="hidden" class="form-control" name="loginFlag" value="backstage">--}}
{{--                                    <div class="form-group row">--}}
{{--                                        <label for="email" class="col-md-4 col-form-label text-md-right">帳號</label>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}



{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </main>--}}
{{--</div>--}}
@stack('admin-app-scripts')
</body>
</html>
