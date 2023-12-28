@extends('layouts.app')

@section('content')
<div class="col-12 slider">
    @foreach($banners as $banner)
        @for($i = 1; $i <= 3; $i++)
            <a href="{{$banner->link}}" target="_blank">
                <img class="img-fluid w-100" alt="Bootstrap Image Preview" src="{{$banner->image}}" />
            </a>
        @endfor
    @endforeach
</div>
<div class="m-4 m-lg-5">
    <div class="row align-items-center" id="price-wrapper">
        <div class="col-lg-5 mb-4">
            <div class="col-12 slider-syncing my-3">
                @foreach($cards as $card)
                    <canvas class="chart chartjs-render-monitor historyPriceChart" data-title="{{$card->name}}" data-value="{{ $card->indexHistoryPrices() }}"></canvas>
                @endforeach
            </div>
            <h2 class="fs-1 fw-bold">卡片價格更新</h2>
            <p class="fs-5">全台最大卡片販售平台就在這裡！！</p>
            <a href="#" type="button" class="btn btn-yellow">查看更多</a>
        </div>
        <div class="col-lg-7" style="background-image:url({{'/storage/uploads/new-card-price-bg.jpg'}}); ">
            <div class="h-100">
                <div class="col-12 slider-center">
                    @foreach($cards as $card)
                        <img class="img-fluid" alt="Bootstrap Image Preview" src="{{$card->image}}" />
                    @endforeach
    {{--                @for($i = 1; $i <= 3; $i++)--}}
    {{--                    <img class="img-fluid" alt="Bootstrap Image Preview" src="/storage/uploads/news-card-price.webp" />--}}
    {{--                @endfor--}}
                </div>
            </div>
        </div>
    </div>
    <!-- news -->
    <div class="row mt-5 gx-5">
        <div class="col-lg-6 mb-5">
            <a href="{{route('newsPost',['post_id'=>$biggestEvent->id])}}" target="_blank" class="text-decoration-none text-dark">
                <h3 class="fs-1 fw-bold mb-3">最新消息</h3>
                <img class="img-fluid w-100" alt="Bootstrap Image Preview" src="{{$biggestEvent->image}}" />
                <p class="fs-5 mt-3">{{$biggestEvent->title}}</p>
            </a>
            <a href="{{route('news')}}" type="button" class="btn btn-yellow">查看更多</a>
        </div>
        <div class="col-lg-6 mt-lg-4">
            @foreach($eventsList as $event)
                <a href="{{route('newsPost',['post_id'=>$event->id])}}" target="_blank" class="text-decoration-none text-dark">
                    <div class="news-list-item mb-3">
                        <div class="news-list-img">
                            <img class="news-description-image" alt="Bootstrap Image Preview" src="{{$event->image}}" />
                        </div>
                        <div class="news-list-des">
                            <h4 class="fs-5 fw-bold news-description ">{{$event->title}}</h4>
                            <p class="news-description">{{ strip_tags($event->content) }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
<div class="spacer row p-lg-4"></div>
<!-- location -->
<div class="row align-items-center my-5">
    <div class="col-lg-8 mb-5 mb-lg-0 pe-lg-5">
        <iframe class="w-100"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3637.66250801265!2d120.720984!3d24.253579999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34691a0e56b5349f%3A0xf4131754898862d7!2s5%E6%A8%93%2C%20No.%2065%E8%99%9F%2C%20Sanmin%20Rd%2C%20Fengyuan%20District%2C%20Taichung%20City%2C%20420!5e0!3m2!1sen!2stw!4v1701716724415!5m2!1sen!2stw"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="cus-store-info">
            <h5 class="fs-1 fw-bold">店鋪資訊</h5>
            <p>規劃路線</p>
            <div>
                <p>5F., No.65, Sanmin Rd.
                    Fengyuan Dist., Taichung City 420020</p>
                <p class="fw-500">臺中市豐原區三民路65號5樓</p>
            </div>
            <a href="#" type="button" class="btn btn-black">聯絡我們</a>
        </div>
    </div>
</div>
<div class="spacer row p-lg-4"></div>
</div>





@endsection

@push('app-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
    <script>

        $( document ).ready(function() {
            /** history price*/
            var today = new Date();

            $('.historyPriceChart').each(function (index, element) {

                let historyChart = new Chart(element, {
                    type: 'line',
                    data: {
                        labels: getDateChart(today, 6),
                        datasets: [{
                            label: $(this).data('title'),
                            lineTension: 0, // 曲線的彎度，設0 表示直線
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: getPriceChart($(this).data('value')),
                            fill: false, // 是否填滿色彩
                        }]
                    },
                    options: {}
                });
            });
        });

        function getDateChart(today,days){
            var labels = [];
            var endDate = moment(today.toLocaleDateString('zh-TW'));
            today.setDate(today.getDate() - days);
            var startDate = moment(today.toLocaleDateString('zh-TW'));
            while (endDate > startDate || startDate.format('M') === endDate.format('M') ) {
                if (endDate >= startDate){
                    labels.push(startDate.format('YYYY-MM-DD'));
                }
                startDate.add(1,'day');
            }

            return labels;
        }
        function getPriceChart(chartValues){
            console.log(chartValues);
            var data = [];
            chartValues.forEach(function (value){
                let valueDate = moment(value.dateTime).format('YYYY-MM-DD');
                data.push({'x':valueDate,'y': (value.price)??0 });
            });
            return data;
        }

    </script>
@endpush