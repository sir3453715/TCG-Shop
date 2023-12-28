<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('/storage/image/global-shipping.jpg')}}">
    <title>{{ app('Option')->site_name }}</title>
    @stack('app-head-scripts')
    @section('app-styles')
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @show
    @stack('app-styles')
</head>
<body>
<div id="app" class="container-fluid">
    <div class="row sticky-top">
       @include('component.header') 
    </div>
    @include('component.mini-cart')
    <div class="row">
    <div class="d-none d-md-block col-md-3 col-lg-2 p-0">
    @include('component.sidebar')
    </div>
    <div class="content-wrapper col-md-9 col-lg-10 p-0">
        @if (\Session::has('message'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <i class="icon fas fa-check"></i> {!! \Session::get('message') !!}
            </div>
        @endif
        @if (\Session::has('Errormessage'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {!! \Session::get('Errormessage') !!}
            </div>
        @endif
        @yield('content')
    </div>
    </div>

        @include('component.footer')
</div>
<!-- off canvas menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuleLabel">
  <div class="offcanvas-header">
    <button type="button" class="btn cus-close-btn" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div>
  @include('component.sidebar')
  </div>
</div>


@section('app-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@show
@stack('app-scripts')
</body>
</html>
