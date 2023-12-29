@if(empty($items))
    <div class="col-12 align-self-center text-center">
        購物車內目前沒有商品
    </div>
@else
    @foreach($items as $card_id => $item)
        <div class="mini-cart-items col-6 col-sm-3">
            <img class="img-fluid" src="{{$item['image']}}" alt="">
            <div class="row align-items-center my-2">
                <div class="addtocart-selector col-6">
                    <div class="addtocart-qty">
                        <div class="addtocart-button button-down add-to-cart" data-id="{{$card_id}}" data-type="minus">
                            <span class="fas fa-minus " aria-label="increase quantity"></span></div>
                        <input type="text" class="addtocart-input" value="{{$item['number']}}">
                        <div class="addtocart-button button-up add-to-cart" data-id="{{$card_id}}" data-type="plus">
                            <span class="fas fa-plus " aria-label="increase quantity"></span>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <span class="price text-red fs-6 fw-bold">{{$item['price']}}元</span>
                </div>
            </div>
        </div>
    @endforeach
@endif