@extends('layouts.app')

@section('content')
    <div class="news-top">
        <img class="img-fluid w-100" src="/storage/uploads/deck-banner.jpg" alt="">
    </div>
    <div class="news-section m-4 m-lg-5">
        <div class="row">
            @foreach($decks as $deck)
                    <div class="col-lg-4 col-12 mb-5">
                        <a class="text-decoration-none text-dark" href="{{route('deckDetail',['deck_id'=>$deck->id])}}">
                        <div class="card cus-card-news">
                            <img src="{{$deck->image}}" class="card-img-top" alt="Card Image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fs-2">{{$deck->title}}</h5>
                                <div class="d-flex mt-2 mb-2">
                                        @if($deck->competition == 'standard')
                                            <span class="badge fs-5 bg-success text-gray">標準賽</span>
                                        @elseif($deck->competition == 'expanded')
                                            <span class="badge fs-5 bg-danger text-gray">開放賽</span>
                                        @endif
                                        <span class="w-100 fw-bold text-end">
                                            <span class="btn deck-btn" data-code="{{$deck->code}}">{{$deck->code}}<i class="fa fa-sign-out ms-2"></i>
                                            </span>
                                        </span>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
            @endforeach
        </div>

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

    </script>
@endpush