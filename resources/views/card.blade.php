@extends('layouts.app')

@push('app-styles')
<style>

</style>
@endpush
@section('content')
<!-- // 卡牌列表 start-->
<div class="m-4 m-lg-5">
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
                <div class="row">
                    @foreach($TWCards as $TWCard)
                    <div class="col-sm-6 col-xl-4 mb-4">
                        <div class="card cus-card">
                            <a href="javascript:void(0)" class="info-modal float-right text-dark"
                                data-id="{{$TWCard->id}}" data-bs-toggle="modal" data-bs-target="#cus-card-info-modal">
                                <div class="card-img-top">
                                    <img class="img-fluid" src="{{$TWCard->image}}" />
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="row card-top mb-2">
                                    <div class="col-6 fw-bold card-number">240/172</div>
                                    <div class="col-6 text-end fw-bold card-price">9,999元</div>
                                </div>
                                <div class="row align-items-center mb-2">
                                    <div class="col-10">
                                        <h5 class="card-title">{{$TWCard->name}}</h5>
                                        <p class="card-text">sv3a F 強化擴充包「激狂駭浪」</p>
                                    </div>
                                    <div class="col-2 text-end fs-3">
                                        <a><i class="fa-regular fa-heart"></i></a>
                                        <!-- <a> <i class="fa-solid fa-heart"></i></a> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a><i class="fas fa-minus me-3"></i></a>
                                        <a><i class="fas fa-plus"></i></a>
                                    </div>
                                    <div class="col-6 text-end fw-bold">SAR</div>
                                </div>
                            </div>
                        </div>
                        <!-- end card  -->
                    </div>
                    @endforeach
                </div>
                <div id="pagination">
                    {{ $TWCards->links() }}
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
                <div class="modal-tag-1 text-center col-6">
                    噴火龍 EX
                </div>
                <div class="modal-tag-2 text-center col-6">
                    卡片詳情
                </div>
            </div>
            <div class="modal-body">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="row gx-5">
                    <div class="col-lg-6 mb-3 mb-lg-0" id="">
                        <img class="img-fluid w-100" src="{{$TWCard->image}}" />
                        <div class="row align-items-center my-4">
                            <div class="addtocart-selector col-6">
                                <div class="addtocart-qty">
                                    <div class="addtocart-button button-down"><span class="fas fa-minus"
                                            aria-label="increase quantity"></span></div>
                                    <input type="text" class="addtocart-input" value="1" />
                                    <div class="addtocart-button button-up">
                                        <span class="fas fa-plus" aria-label="increase quantity"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <span class="price">9,999元</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-sm btn-sm-yellow fs-5 w-50 me-2">
                                加入願望清單
                            </button>
                            <button type="submit" class="btn btn-sm btn-sm-black fs-5 w-50 ms-2">
                                加入購物車
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge-pill badge-gray w-50 text-center fs-5 fw-bold p-2">類型</span>
                            <span class="w-50 fs-5 fw-bold text-center">寶可夢</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge-pill badge-gray w-50 text-center fs-5 fw-bold p-2">稀有度</span>
                            <span class="w-50 fs-5 fw-bold text-center">RR</span>
                            <span class="badge-pill badge-outline w-50 fs-5 fw-bold text-center">G</span>
                        </div>
                        <div class="badge-pill badge-gray w-100 text-center fs-5 fw-bold p-2 mb-3">招式</div>
                        <div>
                            <div class="mb-5">
                             <p class="fs-5 fw-bold">太晶</p>
                            <p>只要這隻寶可夢在備戰區，不會受到招式的傷害。</p>   
                            </div>
                            <div class="mb-5">
                               <p class="fs-5 fw-bold">煉獄支配</p>
                            <p>在自己的回合，從手牌使出這張卡並完成進化時，可使用1次。從自己的牌庫選擇最多3張「基本【火】能量」卡，以任意方式附於自己的寶可夢身上。並且重洗牌庫。</p> 
                            </div>
                            <div class="row">
                                <p class="col-6 fs-5 fw-bold">燃燒黑暗</p>
                                <p class="col-6 fs-5 fw-bold">180 +</p>
                            </div>
                            <div class="mb-2">
                                <img src="https://placehold.co/40x40" alt="">
                                <img src="https://placehold.co/40x40" alt="">
                            </div>
                            <p>增加對手已經獲得的獎賞卡的張數×30點傷害。</p>
                            <p>寶可夢【ex】【昏厥】時，對手獲得2張獎賞卡。</p>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="badge-sm badge-black mb-2">弱點</div>
                                <span> <img src="https://placehold.co/35x35" alt="">x2</span>
                            </div>
                            <div class="col-4">
                                <div class="badge-sm badge-gray mb-2">抵抗力</div>
                                <span>--</span>
                            </div>
                            <div class="col-4">
                                <div class="badge-sm badge-gray mb-2">撤退</div>
                                <span>
                                    <img src="https://placehold.co/35x35" alt="">
                                    <img src="https://placehold.co/35x35" alt="">
                            </span>
                            </div>
                            </div>
                    </div>
                </div>
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

    // $('body').on('click', '.info-modal', function (e) {
    //     let id = $(this).data('id');
    //     $.ajax({
    //         type: "POST",
    //         url: "./GetCardData",
    //         dataType: "json",
    //         data: {
    //             '_token': $('meta[name="csrf-token"]').attr('content'),
    //             'id': id,
    //         },
    //         success: function (object) {
    //             if (object.result === '1') {
    //                 $('#ModalCardInfoHtml').html(object.html);
    //                 $('#ModalCardImage').attr('src', object.image);
    //             } else {
    //                 alert(object.message);
    //             }
    //         }
    //     });
    // });
</script>
@endpush