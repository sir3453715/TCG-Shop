@extends('layouts.app')

@section('content')
    <div class="news-top m-0 m-lg-5">
        <div class="news-post">
            <span class="news-post-date fs-36 fw-bold">{{$competition->dateTime->format('Y.m.d')}}</span>
            <h1 class="fs-2 fw-bold">{{$competition->title}}</h1>
            <div class="news-post-content">
                <img class="img-fluid w-100 mb-5" src="{{$competition->image}}" alt="Post Image">
                <!-- summernote editor content sample-->
                <div>
                    {!!  nl2br($competition->content)  !!}
                </div>
            </div>

        </div>
    </div>



@endsection

@push('app-scripts')
@endpush