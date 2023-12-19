@extends('layouts.app')
@section('content')

<div id="my-deck" class="m-4 m-lg-5">
    @foreach($decks as $deck)
        <div class="row deck-list bg-yellow rounded-3 p-3 mb-4 align-items-center">
            <div class="col-sm-9 mb-2">
                <div class="d-flex flex-wrap">
                    <div class="deck-title">{{$deck->title}}</div>
                    <a href="" class="btn deck-btn">{{$deck->code}}<i class="fa fa-sign-out ms-2"></i>
                    </a>
                </div>

                <p class="deck-date m-0">{{$deck->created_at->format('Y/m/d')}}</p>
            </div>
            <div class="col-sm-3 text-sm-end">
                <div class="deck-number">{{$deck->deckBuildCategoryTotal()['total']}}張</div>
                <a href="" class="deck-del btn-text">刪除</a>
            </div>
        </div>
    @endforeach

        <div class="frontend-pagination">
            {{ $decks->appends(request()->except('page'))->links() }}
        </div>
</div>

@endsection
@push('app-scripts')
@endpush