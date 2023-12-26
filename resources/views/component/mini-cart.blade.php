<div class="mini-cart-wrapper container-fluid">
    <div class="mini-cart">
        <button type="button" id="mini-cart-close" class="btn-close mb-2"></button>
        <div class="row gy-2 gx-4 mini-cart-list" id="mini-cart-list">
            @if(isset(\Illuminate\Support\Facades\Session::get('cart')['items']) && !empty(\Illuminate\Support\Facades\Session::get('cart')['items']))
                @foreach(\Illuminate\Support\Facades\Session::get('cart')['items'] as $card_id => $item)
                    <div class="mini-cart-items col-6 col-sm-3">
                        <img class="img-fluid" src="{{$item['image']}}" alt="">
                        <div class="row align-items-center my-2">
                            <div class="addtocart-selector col-6">
                                <div class="addtocart-qty">
                                    <div class="addtocart-button button-down">
                                        <span class="fas fa-minus add-to-cart" data-id="{{$card_id}}" data-type="minus" aria-label="increase quantity"></span></div>
                                    <input type="text" class="addtocart-input" value="{{$item['number']}}">
                                    <div class="addtocart-button button-up">
                                        <span class="fas fa-plus add-to-cart" data-id="{{$card_id}}" data-type="plus" aria-label="increase quantity"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <span class="price text-red fs-6 fw-bold">50元</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                購物車內目前沒有商品
            @endif
        </div>
        <div class="row mt-3 sticky-bottom mini-cart-footer">
            <div class="col-sm-6 mb-2 mb-sm-0">
                <div class="fs-4 fw-bold">卡片張數：<span class="text-red fs-4 fw-bold"><span id="count">{{(\Illuminate\Support\Facades\Session::get('cart')['count'])??0}}</span> 張</span></div>
                <div class="fs-4 fw-bold">商品總價：<span class="text-red fs-4 fw-bold"><span id="total">{{(\Illuminate\Support\Facades\Session::get('cart')['total'])??0}}</span> 元</span></div>
            </div>

            <div class="col-sm-6">
                <div class="d-flex align-items-center my-1">
                    <button type="button" class="btn btn-sm btn-danger fs-5 w-100 mx-sm-2 me-2" id="cleanCart">清空牌組</button>
                </div>
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-sm btn-sm-black fs-5 w-50 mx-sm-2 me-2">建立牌組</button>
                    <button type="submit" data-id="2" class="btn btn-sm btn-sm-yellow fs-5 w-50 mx-sm-2 ms-2">前往結帳</button>
                </div>
            </div>
        </div>
    </div>
<!--end mini-cart -->
</div>
<!--end container -->