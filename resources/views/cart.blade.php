@extends('layouts.app')
@section('content')

<div id="cart" class="m-3 m-lg-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">購物車</li>
        </ol>
    </nav>
    <div class="steps-col row text-center my-5">
        <div class="col-4">
            <span class="steps-col-items">1</span>
            <div>購物車</div>
        </div>
        <div class="col-4">
            <span class="steps-col-items">2</span>
            <div>填寫資料</div>
        </div>
        <div class="col-4">
            <span class="steps-col-items">3</span>
            <div>訂單確認</div>
        </div>
        <hr>
    </div>
    <!--end .steps-col-->
<form action="" method="">
    <div class="row mb-3 mb-lg-5">
        <div class="cus-table">
            <div class="cus-table-header">
                購物車
            </div>
            <table class="table table-cart table-mobile">
                <thead>
                    <tr>
                        <th>商品資料</th>
                        <th>數量</th>
                        <th>單價</th>
                        <th>小計</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @for($i = 1; $i <= 4; $i++) <tr>
                        <td class="product-col">
                            <div class="product d-flex align-items-center">
                                <img class="product-media me-3"
                                    src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png">
                                <h3 class="product-title">
                                    老大的指令（赤日）
                                </h3>
                            </div>
                        </td>
                        <td class="quantity-col">
                            <div class="addtocart-selector d-flex justify-content-center">
                                <div class="addtocart-qty">
                                    <div class="addtocart-button button-down"><span class="fas fa-minus"
                                            aria-label="increase quantity"></span></div>
                                    <input type="text" class="addtocart-input" value="1">
                                    <div class="addtocart-button button-up">
                                        <span class="fas fa-plus" aria-label="increase quantity"></span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="price-col"><span class="d-inline d-sm-none fw-bold">單價：</span>$84.00</td>
                        <td class="total-col"><span class="d-inline d-sm-none fw-bold">小計：</span>$11600</td>
                        <td class="remove-col"><button class="btn btn-remove"><i class="fa-solid fa-xmark"></i></button>
                        </td>
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
    </div>
    <!-- 訂單資訊 -->
    <div class="row gx-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="bg-white">
                <div class="cus-table-header">
                    送貨方式與填寫資料
                </div>
                <div class="p-3">
                    <div class="col mb-2">
                        <label for="" class="form-label">收件人:</label>
                        <input type="text" class="form-control" id="">
                    </div>
                    <div class="col mb-2">
                        <label for="" class="form-label">電話:</label>
                        <input type="text" class="form-control" id="">
                    </div>
                    <div class="col mb-2">
                        <label for="" class="form-label">信箱:</label>
                        <input type="text" class="form-control" id="">
                    </div>
                    <div class="col mb-2">
                        <label for="" class="form-label">詳細地址:</label>
                        <input type="text" class="form-control" id="">
                    </div>
                    <div class="col mb-2">
                        <label for="" class="form-label">送貨方式:</label>
                        <select class="form-select bg-white" id="">
                            <option selected>Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="my-3">
                        <p>※ 宅配物流週日不送件。</p>
                        <p>※ 週末及國定例假日並無出貨。</p>
                        <p>※ 特殊節日不保證隔日到貨，詳情可參考黑貓宅急便公告。</p>
                        <p>※煩請再次確認宅配地址是否正確，為確保宅配可以盡快送達，務必填寫 "中文" 地址喔 ※</p>
                        <p>＊不含外島配送＊</p>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-white">
                <div class="cus-table-header">
                    訂單資訊
                </div>
                <div class="p-3">
                    <div class="col mb-2 d-flex justify-content-between">
                        <div>小計:</div>
                        <div class="fw-bold">NT$ 6700</div>
                    </div>
                    <div class="col mb-2 d-flex justify-content-between">
                        <div>折抵購物金:</div>
                        <div class="fw-bold">-NT$0 購物金</div>
                    </div>
                    <div class="col mb-2 d-flex justify-content-between">
                        <div>運費:</div>
                        <div class="fw-bold">NT$95</div>
                    </div>
                    <div class="col mb-2 d-flex justify-content-between border-top border-bottom mt-5 mb-4 py-4">
                        <div>合計</div>
                        <div class="fw-bold">NT$6795</div>
                    </div>

                    <div class="col mb-2">
                        <label for="" class="form-label">付款方式:</label>
                        <select class="form-select bg-white" id="">
                            <option selected>Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="my-5">
                        <p>若您於付款程序中，不小心跳離或是關閉頁面，請重新下單即可；若您多次遇到付款失敗，請嘗試更換信用卡再次下單，或洽詢發卡行。<br>
                            【提醒您！】本公司不會透過電話要求顧客操作網路銀行或是ATM！若您接到不明來電提及上述內容，切勿提供個人資料！切勿聽信電話指示操作任何動作！並立刻撥打165反詐騙專線或者與我們聯繫！
                        </p>
                    </div>
                    <a href="{{route('invoice')}}" class="btn btn-md btn-md-yellow fs-5 w-100 mb-5 bg-light-yellow">
                        下一步</a>
                </div>

            </div>
        </div>
    </div>
</form>
</div>

@endsection
@push('app-scripts')
@endpush