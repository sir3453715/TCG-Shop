@extends('layouts.app')

@section('content')
        <div class="news-section m-4 m-lg-5">
            <h3>隱私權政策 / Privacy Policy</h3>
            <div class="col-12 my-3 ">
                {!! app('Option')->privacy  !!}
            </div>
        </div>
@endsection
