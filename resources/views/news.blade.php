@extends('layouts.app')

@section('content')
<div class="news-top">
    <img class="img-fluid w-100" src="https://placehold.co/1000x250" alt="">
</div>

<div class="news-section m-4 m-lg-5">
    <div class="col-12 my-5 ms-3">
        <div class="news-date">
            <p class="m-0 news-date-number">12<br>/<br>10<br></p>
            <div class="d-flex justify-content-center">
                <p class="news-date-day m-0">周日</p>
            </div>
        </div>
    </div>
    <div class="row news-list">
        @foreach($news as $new)
            <div class="card-wrapper col-md-6 mb-5">
                <div class="card cus-card-news">
                    <img src="{{$new->image}}" class="card-img-top" alt="Card Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fs-2">{{$new->title}}</h5>
                        <div class="d-flex mt-5 mb-3">
                            <span class="w-50 fs-5 fw-bold">{{$new->dateTime->format('Y.m.d')}}</span>
                            <span class="w-50 fs-5 fw-bold text-red text-end">大切なお知らせ</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('app-scripts')
@endpush