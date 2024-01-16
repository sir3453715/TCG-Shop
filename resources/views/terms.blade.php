@extends('layouts.app')

@section('content')
    <div class="news-section m-4 m-lg-5">
        <h3>服務條款 / Terms of Service.</h3>
        <div class="col-12 my-3 ">
            {!! app('Option')->TOS  !!}
        </div>
    </div>
@endsection
