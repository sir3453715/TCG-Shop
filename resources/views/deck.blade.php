@extends('layouts.app')

@section('content')
    <div class="news-top p-4 p-lg-5">
        <h1 class="fs-40 fw-bold mb-4 mb-lg-5">推薦牌組</h1>
        <img class="img-fluid w-100" src="https://placehold.co/1095x250" alt="">
    </div>


    <div class="news-section m-4 m-lg-5">
        <div class="row">
            @for($i = 1; $i <= 8; $i++)
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="card cus-card-news">
                        <img src="https://placeholder.co/416x321" class="card-img-top" alt="Card Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-2">演進噴火龍牌組</h5>
                            <div class="d-flex mt-2 mb-2">

                                    <span class="w-100 fw-bold text-end">
                                        <a href="" class="btn deck-btn">hgk375hjkhf9<i class="fa fa-sign-out ms-2"></i></a>
                                    </span>


{{--                                <span class="w-50 fs-5 fw-bold"></span>--}}
{{--                                <span class="w-50 fs-5 fw-bold text-red text-end">大切なお知らせ</span>--}}
{{--                                <span class="w-50 fs-5 fw-bold text-end">--}}
{{--                                    <a href="" class="btn deck-btn">hgk375hjkhf9<i class="fa fa-sign-out ms-2"></i></a>--}}
{{--                                </span>--}}
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection

@push('app-scripts')
@endpush