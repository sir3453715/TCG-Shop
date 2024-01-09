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
            <form action="{{route('myAccount.deckSaveTitle', ['deck_id' => $deck->id])}}" method="post"  class="w-100">
                @csrf
                <div class="d-flex flex-wrap mb-sm-3">
                    <div class="deck-title d-flex col-12" >
                        <a href="javascript:void(0);" class="btn-text mx-1" id="deck-title-edit"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0);" class="btn-text mx-1 d-none" id="deck-title-save"><i class="fas fa-save"></i></a>
                        <input type="text" class="form-control deck-title-input deck-title-disable" name="title" id="deck_title" value="{{$deck->title}}">
                    </div>
                </div>
            </form>
            <p class="deck-date m-0">{{$deck->created_at->format('Y/m/d')}}</p>
        </div>
        <div class="col-sm-3 text-sm-end">
            <div class="col-12 deck-code d-flex">
                <a href="javascript:void(0);" class="btn deck-btn align-self-sm-end w-auto" data-code="{{$deck->code}}">{{$deck->code}}<i class="fa fa-sign-out ms-2"></i></a>
                <div class="deck-number mb-sm-3">{{$deck->deckBuildCategoryTotal()['total']}}張</div>
            </div>
            <div class="deck-btn-group col-12 ">

                <a href="{{route('build', ['deck_id' => $deck->id])}}" class="btn-text fs-5 get-build" target="_blank">生成構築表</a>
                <form action="{{route('myAccount.deckDel', ['deck_id' => $deck->id])}}" method="post"  class="form-btn">
                    @method('delete')
                    @csrf
{{--                    <a href="javascript:void(0);" class="deck-edit btn-text me-sm-4 text-danger" id="deck-download">下載圖片</a>--}}
                    <a href="{{route('myAccount.deckEdit', ['deck_id' => $deck->id])}}" class="deck-edit btn-text me-sm-3" id="deck-edit">編輯</a>
                    <a href="javascript:void(0);" class="deck-del btn-text sweet-delete-confirm">刪除</a>
                </form>
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

{{--<div id="deckDownload-image">--}}
{{--    <div class="text-center">--}}
{{--        <img src="/storage/image/RHanWorkLogo.png" width="200px">--}}
{{--        <h3>TCG Shop</h3>--}}
{{--    </div>--}}
{{--    <div class="row col-12 p-5">--}}
{{--        @foreach($deck->deckCardCategoryInfo() as $cardType => $cards)--}}
{{--            @foreach($cards as $card)--}}
{{--                <div class="col-1 deck-list-card" style="background-image: url('{{$card['image']}}'); background-size: contain; background-repeat: no-repeat;">--}}
{{--                <div class="col-1 deck-list-card">--}}
{{--                    <span class="deck-card-count text-danger">{{$card['num']}}</span>--}}
{{--                    <img class="img-fluid w-100" src="{{$card['image']}}" >--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
@push('app-scripts')
    <script>
        $('#deck-title-edit').on('click',function (e) {
            e.preventDefault();
            $(this).siblings('.deck-title-input').removeClass('deck-title-disable');
            $(this).siblings('#deck-title-save').removeClass('d-none');
            $(this).addClass('d-none');
        });
        $('#deck-title-save').on('click',function (e) {
            e.preventDefault();
            $(this).siblings('.deck-title-input').addClass('deck-title-disable');
            $(this).siblings('#deck-title-edit').removeClass('d-none');
            $(this).addClass('d-none');
            $(this).closest('form').submit();
        });

        $('.deck-btn').on('click',function (e) {
            e.preventDefault();
            var $temp = $(this).data('code');
            var tempTextarea = $('<textarea>');
            $('body').append(tempTextarea);
            tempTextarea.val($temp).select();
            document.execCommand('copy');
            tempTextarea.remove();

            swal({
                title: "代碼複製成功!",
                text: "可以分享給其他人",
                timer: 1000
            });
        });

    </script>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script type="text/javascript">
        $(window).on('load', function() {
            html2canvas(document.getElementById('deckDownload-image'),{
            }).then(function(canvas) {
                canvas.id = "h2canvas";
                canvas.style='display:none';
                document.body.appendChild(canvas);
                var a = $('#deck-download');
                a.attr('href' , canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream"));
                a.attr('download', 'deckImage.jpg');
            });

        });
    </script>
@endpush