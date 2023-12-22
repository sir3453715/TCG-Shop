@extends('layouts.app')
@section('content')
<div id="my-wishlist" class="m-3 m-lg-5">
    <div class="row deck-list-content gx-3 gy-3">
        @foreach($wishlistArray as $key => $wishlists)
            <h2 class="col-12 fs-3">{{$key}}</h2>
               <!-- cards -->
            @foreach($wishlists as $card_id => $card)
                <div class="col-6 col-xl-3 mb-4">
                    <div class="card cus-card">
                        <a href="javascript:void(0)" class="info-modal float-right text-dark"
                            data-id="{{$card->id}}" data-bs-toggle="modal" data-bs-target="#cus-card-info-modal">
                            <div class="card-img-top">
                                <img class="img-fluid" src="{{$card->image}}" />
                            </div>
                        </a>
                        <div class="card-body">
                            <div class="row card-top mb-2">
                                <div class="col-sm-6 fw-bold card-number">{{$card->serial_number}}</div>
                                <div class="col-6 text-end fw-bold card-price d-none d-sm-block">{{$card->nowPrice()}}元</div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-sm-10">
                                    <h5 class="card-title">{{$card->name}}</h5>
                                    <p class="card-text">{{$card->series}}</p>
                                </div>
                                <div class="col-2 text-end fs-3 d-none d-sm-block">
                                    <a class="btn-link {{ ($card->wishlistCheck())?'remove-wishlist':'add-to-wishlist' }}" href="javascript:void(0);" data-id="{{$card->id}}">
                                        <i class="{{ ($card->wishlistCheck())?'fa-solid':'fa-regular' }} fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a><i class="fas fa-minus me-3"></i></a>
                                    <a><i class="fas fa-plus"></i></a>
                                </div>
                                <div class="col-6 text-end fw-bold">{{$card->rarity}}</div>
                            </div>
                            <div class="cus-card-footer d-flex d-sm-none">
                                <div class="col-10 fw-bold card-price">{{$card->nowPrice()}}元</div>
                                <div class="col-2 text-end fs-3">
                                    <a class="{{ ($card->wishlistCheck())?'remove-wishlist':'add-to-wishlist' }}" href="javascript:void(0);" data-id="{{$card->id}}">
                                        <i class="{{ ($card->wishlistCheck())?'fa-solid':'fa-regular' }} fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card  -->
                </div>
            @endforeach
        @endforeach
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

    <script type="text/javascript">

        $('body').on('click', '.info-modal', function (e) {
            let id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "../GetCardDataF",
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

    </script>
@endpush