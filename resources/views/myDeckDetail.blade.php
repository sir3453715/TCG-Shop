@extends('layouts.app')
@section('content')
<div id="my-deck-list" class="m-4 m-lg-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('myAccount.myDeck')}}">我的牌組</a></li>
        <li class="breadcrumb-item active" aria-current="page">牌組明細</li>
      </ol>
    </nav>
    <div class="row deck-list bg-yellow rounded-3 p-3 align-items-center">
        <div class="col-sm-9 mb-2">
            <div class="d-flex flex-wrap mb-sm-3">
                <div class="deck-title">{{$deck->title}}</div>
                <a href="" class="btn deck-btn">{{$deck->code}}<i class="fa fa-sign-out ms-2"></i></a>
            </div>
            <p class="deck-date m-0">{{$deck->created_at->format('Y/m/d')}}</p>
        </div>
        <div class="col-sm-3 text-sm-end">
            <div class="deck-number mb-sm-3">{{$deck->deckBuildCategoryTotal()['total']}}張</div>
            <div class="deck-btn-group">
                <a href="" class="deck-edit btn-text me-sm-3">編輯</a>
                <a href="" class="deck-del btn-text">刪除</a>
            </div>
        </div>
    </div>
    @foreach($deck->deckCardCategoryInfo() as $cardType => $cards)
        <div class="row deck-list-content gx-3 gy-3">
            <h2 class="col-12 fs-3">{{$cardType}}</h2>
            @foreach($cards as $card)
                <div class="col-4 col-sm-3 col-md-2 deck-list-card">
                    <span class="deck-card-count">{{$card['num']}}</span>
                    <img class="img-fluid w-100" src="{{$card['image']}}">
                </div>
             @endforeach
        </div>
    @endforeach
</div>
@endsection
@push('app-scripts')
@endpush