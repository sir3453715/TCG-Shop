<div class="mini-cart-wrapper container-fluid">
    <div class="mini-cart">
        <button type="button" id="mini-cart-close" class="btn-close mb-2"></button>
        <div class="row gy-3 gx-4">
            @for($i = 1; $i <= 12; $i++) <div class="mini-cart-items col-6 col-sm-3">
                <img class="img-fluid" src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png" alt="">
                <div class="row align-items-center my-4">
                    <div class="addtocart-selector col-6">
                        <div class="addtocart-qty">
                            <div class="addtocart-button button-down">
                                <span class="fas fa-minus" aria-label="increase quantity"></span></div>
                            <input type="text" class="addtocart-input" value="1">
                            <div class="addtocart-button button-up">
                                <span class="fas fa-plus" aria-label="increase quantity"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <span class="price text-red fs-6 fw-bold">50元</span>
                    </div>
                </div>
        </div>
        @endfor
    </div>
    <div class="row my-3">
        <div class="col-sm-6 mb-2 mb-sm-0">
            <div class="fs-4 fw-bold">卡片張數：<span class="text-red fs-4 fw-bold">33 張</span></div>
            <div class="fs-4 fw-bold">商品總價：<span class="text-red fs-4 fw-bold">600 元</span></div>
        </div>

        <div class="d-flex col-sm-6 align-items-center">
            <button type="submit" class="btn btn-sm btn-sm-black fs-5 w-50 mx-sm-2 me-2">建立牌組</button>
            <button type="submit" data-id="2" class="btn btn-sm btn-sm-yellow fs-5 w-50 mx-sm-2 ms-2">前往結帳</button>
        </div>
    </div>
</div>
<!--end mini-cart -->
</div>
<!--end container -->