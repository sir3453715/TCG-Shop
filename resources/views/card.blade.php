@extends('layouts.app')

@section('content')
@inject('html', 'App\Presenters\Html\HtmlPresenter')
<!-- // 卡牌列表 start-->
<div class="m-3 m-lg-5">
    <div class="row">
        <!-- search -->
        <div class="col-12 mb-4">
            <form role="form" class="cus-card-search">
                <div class="row">
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="keyword">關鍵字</label>
                        <input class="form-control" type="text" id="keyword" name="keyword" value="{{$queried['keyword']}}" placeholder="輸入關鍵字">
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="type">卡牌類型</label>
                        <select name="type[]" id="type" class="form-control select2" multiple>
                            <option value="" hidden>請選擇</option>
                            @foreach($types as $type)
                                <option value="{{$type}}" {{(in_array($type,$queried['type']))?'selected':''}}>{{ trans($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="attribute">卡牌屬性</label>
                        <select name="attribute[]" id="attribute" class="form-control select2" multiple>
                            @foreach($attributes as $attribute)
                                <option value="{{$attribute}}" {{(in_array($attribute,$queried['attribute']))?'selected':''}}>{{ trans($attribute) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="rarity">稀有度</label>
                        <select name="rarity[]" id="rarity" class="form-control select2" multiple>
                            @foreach($rarities as $rarity)
                                <option value="{{$rarity}}" {{(in_array($rarity,$queried['rarity']))?'selected':''}}>{{ trans($rarity) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="series">系列</label>
                        <select name="series[]" id="series" class="form-control select2" multiple>
                            @foreach($CardSeries as $series)
                                <option value="{{$series->id}}" {{(in_array($series->id,$queried['series']))?'selected':''}}>{{ trans($series->title) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="competition">賽制</label>
                        <select name="competition" id="competition" class="form-control select2" >
                            <option value="" hidden>請選擇</option>
                            <option value="standard" {!! $html->selectSelected('standard',$queried['competition']) !!}>標準賽</option>
                            <option value="expanded" {!! $html->selectSelected('expanded',$queried['competition']) !!}>開放賽</option>
                        </select>
                    </div>


                </div>
                <button type="submit" class="btn btn-yellow col-12 mt-3">
                    搜尋
                </button>
            </form>
        </div>

        <!-- cards -->
        <div class="col-12 mt-5">
            <div class=" scrolling-pagination">
                <div class="row gx-md-4 gx-3">
                    @foreach($Cards as $Card)
                    <div class="col-6 col-xl-3 mb-4">
                        <div class="card cus-card">
                            <a href="javascript:void(0)" class="info-modal float-right text-dark"
                                data-id="{{$Card->id}}" data-bs-toggle="modal" data-bs-target="#cus-card-info-modal">
                                <div class="card-img-top">
                                    <img class="img-fluid" src="{{$Card->image}}" />
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="row card-top mb-2">
                                    <div class="col-sm-6 fw-bold card-number">{{$Card->serial_number}}</div>
                                    <div class="col-6 text-end fw-bold card-price d-none d-sm-block">{{$Card->nowPrice()}}元</div>
                                </div>
                                <div class="row align-items-center mb-2">
                                    <div class="col-sm-10">
                                        <h5 class="card-title">{{$Card->name}}</h5>
                                        <p class="card-text">{{$Card->series->title}}</p>
                                    </div>
                                    <div class="col-2 text-end fs-3 d-none d-sm-block">
                                        <a class="btn-link {{ ($Card->wishlistCheck())?'remove-wishlist':'add-to-wishlist' }}" href="javascript:void(0);" data-id="{{$Card->id}}">
                                            <i class="{{ ($Card->wishlistCheck())?'fa-solid':'fa-regular' }} fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a class="btn-link" href="javascript:void(0);"><i class="fas fa-minus me-3 add-to-cart" data-id="{{$Card->id}}" data-type="minus"></i></a>
                                        <a class="btn-link" href="javascript:void(0);"><i class="fas fa-plus add-to-cart" data-id="{{$Card->id}}" data-type="plus"></i></a>
                                    </div>
                                    <div class="col-6 text-end fw-bold">{{$Card->rarity}}</div>
                                </div>
                                <div class="cus-card-footer d-flex d-sm-none">
                                    <div class="col-10 fw-bold card-price">{{$Card->nowPrice()}}元</div>
                                    <div class="col-2 text-end fs-3">
                                        <a class="{{ ($Card->wishlistCheck())?'remove-wishlist':'add-to-wishlist' }}" href="javascript:void(0);" data-id="{{$Card->id}}">
                                            <i class="{{ ($Card->wishlistCheck())?'fa-solid':'fa-regular' }} fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card  -->
                    </div>
                    @endforeach
                </div>
                <div id="pagination">
                    {{ $Cards->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- card detail info modal-->
<div class="modal fade" id="cus-card-info-modal" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header row">
                <div class="modal-tag-1 text-center col-6" id="ModelCardTitle"></div>
                <div class="modal-tag-2 text-center col-6">卡片詳情</div>
            </div>
            <div class="modal-body">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="row gx-5" id="ModalCardInfoHtml"></div>
            </div>
        </div><!-- //modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


@endsection

@push('app-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
<script type="text/javascript">
    $(".card-image").lazyload({
        effect: "fadeIn"
    });

    $('ul.pagination').hide();

    $(function () {
        $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function () {
                $('ul.pagination').remove();
            }
        });
    });

    $('body').on('click', '.info-modal', function (e) {
        let id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "./GetCardDataF",
            dataType: "json",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id,
            },
            success: function (object) {
                if (object.result === '1') {

                    $('#ModalCardInfoHtml').html(object.html);
                    $('#ModelCardTitle').html(object.name);

                    var today = new Date();
                    let historyChart = new Chart($('#historyPriceChart'),{
                        type: 'line',
                        data: {
                            labels: getDateChart(today,6),
                            datasets: [{
                                label: object.name,
                                lineTension: 0, // 曲線的彎度，設0 表示直線
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: getPriceChart($('#historyPriceChart').data('value')),
                                fill: false, // 是否填滿色彩
                            }]
                        },
                        options: {}
                    });
                } else {
                    alert(object.message);
                }
            }
        });
    });
    $('body').on('click', '.add-to-wishlist', function (e) {
        let id = $(this).data('id'); let $this = $(this);
        $.ajax({
            type: "POST",
            url: "../AddToWishlist",
            dataType: "json",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id,
            },
            success: function (object) {
                if (object.result === '1') {
                    $this.addClass('remove-wishlist');
                    $this.removeClass('add-to-wishlist');
                    if($this[0].tagName === 'BUTTON'){
                        $this.html('從願望清單移除');
                    }else{
                        $this.children('.fa-heart').addClass('fa-regular');
                        $this.children('.fa-heart').removeClass('fa-solid');
                    }
                }
            }
        });
    });

    $('body').on('click', '.remove-wishlist', function (e) {
        let id = $(this).data('id'); let $this = $(this);
        $.ajax({
            type: "POST",
            url: "../RemoveWishlist",
            dataType: "json",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id,
            },
            success: function (object) {
                if (object.result === '1') {
                    $this.addClass('add-to-wishlist');
                    $this.removeClass('remove-wishlist');
                    if($this[0].tagName === 'BUTTON'){
                        $this.html('加入願望清單');
                    }else{
                        $this.children('.fa-heart').addClass('fa-regular');
                        $this.children('.fa-heart').removeClass('fa-solid');
                    }
                }
            }
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
        var data = [];
        chartValues.forEach(function (value){
            let valueDate = moment(value.dateTime).format('YYYY-MM-DD');
            data.push({'x':valueDate,'y': (value.price)??0 });
        });
        return data;
    }

</script>
@endpush