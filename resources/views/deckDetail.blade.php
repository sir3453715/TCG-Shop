@extends('layouts.app')
@section('content')
<div id="my-deck-list" class="m-4 m-lg-5">
    <div class="row deck-list bg-yellow rounded-3 p-3 align-items-center">
        <div class="col-sm-9 mb-2">
            <div class="d-flex flex-wrap mb-sm-3">
                <div class="deck-title">{{$deck->title}}</div>
                <a href="javascript:void(0);" class="btn deck-btn">{{$deck->code}}<i class="fa fa-sign-out ms-2"></i></a>
            </div>
            <p class="deck-date m-0 text-danger">
                @if($deck->competition == 'standard')
                    標準賽
                @elseif($deck->competition == 'expanded')
                    開放賽
                @endif
            </p>
        </div>
        <div class="col-sm-3 text-sm-end">
            <div class="deck-number mb-sm-3">{{$deck->deckBuildCategoryTotal()['total']}}張</div>
            <div class="deck-btn-group">
                <a href="javascript:void(0);" class="deck-edit btn-text me-sm-3">加入我的牌組</a>
                <a href="javascript:void(0);" class="deck-del btn-text">加入購物車</a>
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