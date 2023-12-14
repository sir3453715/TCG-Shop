@extends('layouts.app')
@section('content')
<div id="my-wishlist" class="m-3 m-lg-5">
    <div class="row deck-list-content gx-3 gy-3">
        <h2 class="col-12 fs-3">支援者</h2>
        @for($i = 1; $i <= 10; $i++)
           <!-- cards -->
        <div class="col-6 col-xl-3 mb-4">
                        <div class="card cus-card">
                            <a href="javascript:void(0)" class="info-modal float-right text-dark"
                                data-id="" data-bs-toggle="modal" data-bs-target="#cus-card-info-modal">
                                <div class="card-img-top">
                                    <img class="img-fluid" src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png" />
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="row card-top mb-2">
                                    <div class="col-sm-6 fw-bold card-number">240/172</div>
                                    <div class="col-6 text-end fw-bold card-price d-none d-sm-block">9,999元</div>
                                </div>
                                <div class="row align-items-center mb-2">
                                    <div class="col-sm-10">
                                        <h5 class="card-title">天空之柱</h5>
                                        <p class="card-text">sv3a F 強化擴充包「激狂駭浪」</p>
                                    </div>
                                    <div class="col-2 text-end fs-3 d-none d-sm-block">
                                        <!-- <a><i class="fa-regular fa-heart"></i></a> -->
                                        <a> <i class="fa-solid fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a><i class="fas fa-minus me-3"></i></a>
                                        <a><i class="fas fa-plus"></i></a>
                                    </div>
                                    <div class="col-6 text-end fw-bold">SAR</div>
                                </div>
                                <div class="cus-card-footer d-flex d-sm-none">
                                <div class="col-10 fw-bold card-price">9,999元</div>
                                <div class="col-2 text-end fs-3">
                                        <!-- <a><i class="fa-regular fa-heart"></i></a> -->
                                        <a> <i class="fa-solid fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card  -->
                    </div>
         @endfor
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
                        <img class="img-fluid w-100" src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png" />
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
@endpush