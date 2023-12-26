@foreach($items as $card_id => $item)
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
                <span class="price text-red fs-6 fw-bold">{{$item['price']}}元</span>
            </div>
        </div>
    </div>
@endforeach