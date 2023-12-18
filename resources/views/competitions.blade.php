@extends('layouts.app')

@section('content')
<div class="news-top">
    <img class="img-fluid w-100" src="https://placehold.co/1000x400" alt="">
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
        <div class="card-wrapper col-md-6 mb-5">
            <div class="card cus-card-news">
                <img src="https://placeholder.co/416x321" class="card-img-top" alt="Card Image">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fs-2">台灣首間Pokémon Center即將在新光三越台北信義新天地A11盛大開幕！</h5>
                    <div class="d-flex mt-5 mb-3">
                        <span class="w-50 fs-5 fw-bold">2023.07.14</span>
                        <span class="w-50 fs-5 fw-bold text-red text-end">大切なお知らせ</span>
                    </div>
                </div>
            </div>
        </div>

        @for($i = 1; $i <= 5; $i++)
        <div class="card-wrapper col-md-6 mb-5">
            <div class="card cus-card-news">
                <img src="https://placeholder.co/416x321" class="card-img-top" alt="Card Image">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fs-2">即將在新光三越台北信義新天地A11盛大開幕！</h5>
                    <div class="d-flex mt-5 mb-3">
                        <span class="w-50 fs-5 fw-bold">2023.07.14</span>
                        <span class="w-50 fs-5 fw-bold text-red text-end">大切なお知らせ</span>
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