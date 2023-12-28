@extends('layouts.app')
@section('content')

<div id="my-deck" class="m-4 m-lg-5">
    <div class="align-items-center mb-3">
        <div class="d-flex">
            <p class="col-sm-10 col-6 m-0"></p>
            <div class="col-sm-2 col-6">
                <form action="{{route('myAccount.deckImport')}}" method="post">
                    @csrf
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="code" id="code" value="" placeholder="請輸入牌組代碼">
                        <button type="submit" class="btn btn-primary">匯入</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($decks as $deck)
        <a class="text-decoration-none text-dark" href="{{route('myAccount.myDeckDetail',['deck_id'=>$deck->id])}}">
            <div class="row deck-list bg-yellow rounded-3 p-3 mb-4 align-items-center">
                <div class="col-sm-9 mb-2">
                    <div class="d-flex flex-wrap">
                        <div class="deck-title">{{$deck->title}}</div>
                        <span class="btn deck-btn" data-code="{{$deck->code}}">{{$deck->code}}<i class="fa fa-sign-out ms-2"></i></span>
                    </div>
                    <p class="deck-date m-0">{{$deck->created_at->format('Y/m/d')}}</p>
                </div>
                <div class="col-sm-3 text-sm-end">
                    <div class="deck-group-competition">
                        @if($deck->competition == 'standard')
                            <span class="badge fs-5 bg-success">標準賽</span>
                        @elseif($deck->competition == 'expanded')
                            <span class="badge fs-5 bg-danger">開放賽</span>
                        @endif
                        <div class="deck-number">
                            {{$deck->deckBuildCategoryTotal()['total']}}張
                        </div>
                    </div>

                    <div class="deck-group-action">
                        <button type="button" class="btn-text bg-yellow border-0 fs-5 get-build" data-id="{{$deck->id}}">生成構築表</button>
                        <form action="{{route('myAccount.deckDel', ['deck_id' => $deck->id])}}" method="post"  class="form-btn">
                            @method('delete')
                            @csrf
                            <button class="btn-text bg-yellow border-0 sweet-delete-confirm fs-5">刪除</button>
                        </form>
                    </div>
                </div>
            </div>
        </a>
    @endforeach



    <div class="frontend-pagination">
        {{ $decks->appends(request()->except('page'))->links() }}
    </div>
</div>

@endsection
@push('app-scripts')
    <script>
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

        $('.get-build').on('click',function (e) {
            e.preventDefault();
            window.open(location.origin+'/build/'+$(this).data('id'));
        });
    </script>
@endpush