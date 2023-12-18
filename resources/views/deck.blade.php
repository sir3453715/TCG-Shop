@extends('layouts.app')

@section('content')
    <div class="news-top">
        <img class="img-fluid w-100" src="https://placehold.co/1000x250" alt="">
    </div>


    <div class="news-section m-4 m-lg-5">
        <div class="row">
            @foreach($decks as $deck)
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="card cus-card-news">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-2">{{$deck->title}}</h5>
                            <div class="d-flex mt-2 mb-2">
                                <span class="w-100 fw-bold text-end">
                                    <a href="" class="btn deck-btn">{{$deck->code}}<i class="fa fa-sign-out ms-2"></i></a>
                                </span>
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