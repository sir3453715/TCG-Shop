@extends('layouts.app')
@section('content')
<div id="my-deck-list" class="m-4 m-lg-5">
    <div class="row deck-list bg-yellow rounded-3 p-3 align-items-center">
        <div class="col-sm-9 mb-2">
            <div class="d-flex flex-wrap mb-sm-3">
                <div class="deck-title">放逐鬼龍</div>
                <a href="" class="btn deck-btn">hgk375hjkhf9<i class="fa fa-sign-out ms-2"></i>
                </a>
            </div>
            <p class="deck-date m-0">2023/10/10</p>
        </div>
        <div class="col-sm-3 text-sm-end">
            <div class="deck-number mb-sm-3">60張</div>
            <a href="" class="deck-edit btn-text me-3">編輯</a>
            <a href="" class="deck-del btn-text">刪除</a>
        </div>
    </div>
    <div class="row deck-list-content gx-3 gy-3">
        <h2 class="col-12 fs-3">物品 / 寶可夢道具</h2>
        @for($i = 1; $i <= 4; $i++)
        <div class="col-4 col-sm-3 col-md-2 deck-list-card">
            <span class="deck-card-count">10</span>
            <img class="img-fluid w-100" src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png">
        </div>
         @endfor
    </div>

    <div class="row deck-list-content gx-3 gy-3">
        <h2 class="col-12 fs-3">支援者</h2>
        @for($i = 1; $i <= 20; $i++)
        <div class="col-4 col-sm-3 col-md-2 deck-list-card">
            <span class="deck-card-count">10</span>
            <img class="img-fluid w-100" src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png">
        </div>
         @endfor
    </div>
</div>
@endsection
@push('app-scripts')
@endpush