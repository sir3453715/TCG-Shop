@extends('layouts.app')

@push('app-styles')
<style>

</style>
@endpush
@section('content')
<!-- // 卡牌列表 start-->
<div class="m-3 m-lg-5">
    <div class="row">
        <!-- search -->
        <div class="col-12 mb-4">
            <form role="form" class="cus-card-search">
                <div class="row">
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="keyword">關鍵字</label>
                        <input class="form-control" type="text" id="keyword" name="keyword"
                            value="{{$queried['keyword']}}" placeholder="輸入名稱">
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="supertypes">卡牌類型</label>
                        <select name="supertypes[]" id="supertypes" class="form-control select2" multiple>
                            @foreach($supertypes as $supertype)
                            <option value="{{$supertype}}"
                                {{ in_array($supertype,$queried['supertypes'])?'selected':'' }}>{{$supertype}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="supertypes">卡牌屬性</label>
                        <select name="types[]" id="types" class="form-control select2" multiple>
                            @foreach($types as $key=> $type)
                            <option value="{{$key}}" {{ in_array($key,$queried['types'])?'selected':'' }}>{{$type}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label class="w-100" for="supertypes">稀有度</label>
                        <select name="rarity[]" id="rarity" class="form-control select2" multiple>
                            @foreach($rarities as $rarity)
                            <option value="{{$rarity}}" {{ in_array($rarity,$queried['rarity'])?'selected':'' }}>
                                {{$rarity}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label for="supertypes">賽制</label>
                        <select name="competition" id="competition" class="form-control">

                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-6">
                        <label for="supertypes">系列</label>
                        <select name="" id="" class="form-control">

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
                                        <p class="card-text">{{$Card->series}}</p>
                                    </div>
                                    <div class="col-2 text-end fs-3 d-none d-sm-block">
                                        <a class="btn-link {{ ($Card->wishlistCheck())?'remove-wishlist':'add-to-wishlist' }}" href="javascript:void(0);" data-id="{{$Card->id}}">
                                            <i class="{{ ($Card->wishlistCheck())?'fa-solid':'fa-regular' }} fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a class="btn-link" href="#"><i class="fas fa-minus me-3"></i></a>
                                        <a class="btn-link" href="#"><i class="fas fa-plus"></i></a>
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
                console.log(object);
                if (object.result === '1') {

                    $('#ModalCardInfoHtml').html(object.html);
                    $('#ModelCardTitle').html(object.name);
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
            url: "./AddToWishlist",
            dataType: "json",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id,
            },
            success: function (object) {
                if (object.result === '1') {
                    $this.addClass('remove-wishlist');
                    $this.removeClass('add-to-wishlist');
                    $this.children('.fa-heart').addClass('fa-solid');
                    $this.children('.fa-heart').removeClass('fa-regular');
                }
            }
        });
    });

    $('body').on('click', '.remove-wishlist', function (e) {
        let id = $(this).data('id'); let $this = $(this);
        $.ajax({
            type: "POST",
            url: "./RemoveWishlist",
            dataType: "json",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id,
            },
            success: function (object) {
                if (object.result === '1') {
                    $this.addClass('add-to-wishlist');
                    $this.removeClass('remove-wishlist');
                    $this.children('.fa-heart').addClass('fa-regular');
                    $this.children('.fa-heart').removeClass('fa-solid');
                }
            }
        });
    });
</script>
@endpush