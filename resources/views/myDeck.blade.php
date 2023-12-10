@extends('layouts.app')
@section('content')

<div id="my-deck" class="m-4 m-lg-5">
@for($i = 1; $i <= 4; $i++) 
    <div class="row deck-list bg-yellow rounded-3 p-3 mb-4 align-items-center">
        <div class="col-sm-9 mb-2">
            <div class="d-flex flex-wrap">
                <div class="deck-title">放逐鬼龍</div>
                <a href="" class="btn deck-btn">hgk375hjkhf9<i class="fa fa-sign-out ms-2"></i>
                </a>
            </div>

            <p class="deck-date m-0">2023/10/10</p>
        </div>
        <div class="col-sm-3 text-sm-end">
            <div class="deck-number">60張</div>
            <a href="" class="deck-del btn-text">刪除</a>
        </div>
    </div>
    @endfor
</div>

@endsection
@push('app-scripts')
@endpush