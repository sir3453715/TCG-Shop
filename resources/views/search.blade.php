@extends('layouts.app')

@section('content')
    @if(!$decks->isEmpty())
    <div class="news-section m-4 m-lg-5">
        <div class="col-12 my-3 ">
            <div class="news-date">
                <div class="d-flex justify-content-center">
                    <p class="news-date-day m-0">推薦</p>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="news-date-day m-0">牌組</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($decks as $deck)
                    <div class="col-lg-3 col-6 mb-5">
                        <a class="text-decoration-none text-dark" href="{{route('deckDetail',['deck_id'=>$deck->id])}}">
                        <div class="card cus-card-news">
                            <img src="{{$deck->image}}" class="card-img-top-deckSearch" alt="Card Image">
                            <div class="card-body d-flex flex-column p-2">
                                <h5 class="card-title fs-4">{{$deck->title}}</h5>
                                <div class="d-sm-flex mt-2 mb-2">
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
    </div>
    @endif
    @if(!$news->isEmpty())
    <div class="news-section m-4 m-lg-5">
        <div class="col-12 my-3 ">
            <div class="news-date">
                <div class="d-flex justify-content-center">
                    <p class="news-date-day m-0">最新</p>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="news-date-day m-0">活動</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($news as $new)
                <div class="card-wrapper col-md-4 col-6 mb-5">
                    <a class="text-decoration-none text-dark" href="{{route('newsPost',['post_id'=>$new->id])}}">
                        <div class="card cus-card-news">
                            <img src="{{$new->image}}" class="card-img-top-newSearch" alt="Card Image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fs-4 search-description">{{$new->title}}</h5>
                                <div class="d-flex my-3">
                                    <span class="w-100 fs-5 fw-bold">{{$new->dateTime->format('Y.m.d')}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    @if(!$competitions->isEmpty())
    <div class="news-section m-4 m-lg-5">
        <div class="col-12 my-3 ">
            <div class="news-date">
                <div class="d-flex justify-content-center">
                    <p class="news-date-day m-0">最新</p>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="news-date-day m-0">賽事</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($competitions as $competition)
                <div class="card-wrapper col-md-4 col-6 mb-5">
                    <a class="text-decoration-none text-dark" href="{{route('competitionsPost',['post_id'=>$competition->id])}}">
                        <div class="card cus-card-news">
                            <img src="{{$competition->image}}" class="card-img-top-newSearch" alt="Card Image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fs-4 search-description">{{$competition->title}}</h5>
                                <div class="d-flex my-3">
                                    <span class="w-100 fs-5 fw-bold">{{$competition->dateTime->format('Y.m.d')}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif
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