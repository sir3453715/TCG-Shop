@extends('layouts.app')
@section('content')

</style>
<div id="order-detail" class="m-4 m-lg-5">
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="">我的訂單</a></li>
    <li class="breadcrumb-item active" aria-current="page">訂單內容</li>
  </ol>
</nav>
    <!-- 訂購單編號 -->
    <div class="d-flex bg-yellow rounded-3 p-3 align-items-center mb-4 mb-sm-5">
        <div class="col mb-2">
            <div class="d-flex flex-wrap align-items-center">
                <div class="fs-2 fw-bold me-3">訂購單編號</div>
                <a href="" class="btn deck-btn">1245488678</i>
                </a>
            </div>
            <div class="d-flex flex-wrap align-items-center">
                <div class="fs-4 me-3">訂購日期</div>
                <div class="fs-4">2023/10/10</div>
            </div>
        </div>
    </div>
    <!-- 訂單狀態 -->
    <div class="border border-dark rounded shadow-sm p-4 bg-white mb-4 mb-sm-5">
        <div class="row">
            <h3 class="fs-4 fw-normal">訂單狀態 <span class="order-status ms-5">處理中</span><!-- <span class="order-status ms-5 bg-success"> 完成</span> --></h3>
            <h4 class="fs-4 fw-normal">收件地址</h4>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">收件人</div>
                    <div class="col-8 fs-5">蕭昌元</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">電話</div>
                    <div class="col-8 fs-5">0918706430</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">地址</div>
                    <div class="col-8 fs-5">台中市豐原區社皮里社皮路78號</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">超商門市</div>
                    <div class="col-8 fs-5">豐社門市</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">店號</div>
                    <div class="col-8 fs-5">211538</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">7-ELEVEN</div>
                    <div class="col-8 fs-5">C26959967806</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">商品小計</div>
                    <div class="col-8 fs-5">$898</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">運費</div>
                    <div class="col-8 fs-5">$60</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">訂單金額</div>
                    <div class="col-8 fs-5 text-red fw-bold">$958</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">付款方式</div>
                    <div class="col-8 fs-5">信用卡/金融卡</div>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="cus-table">
            <div class="cus-table-header">
                訂單內容
            </div>
            <table class="table table-cart table-mobile">
                <thead>
                    <tr>
                        <th>商品資料</th>
                        <th>數量</th>
                        <th>單價</th>
                        <th>小計</th>
                    </tr>
                </thead>

                <tbody>
                    @for($i = 1; $i <= 4; $i++)
                        <tr>
                            <td class="product-col">
                                <div class="product d-block align-items-center">
                                    <img class="product-media me-3"
                                        src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png">
                                    <h3 class="product-title">
                                        老大的指令（赤日）
                                    </h3>
                                </div>
                            </td>
                            <td class="quantity-col">
{{--                                <span class="d-inline d-sm-none fw-bold">數量：</span>--}}
                                5
                            </td>
                            <td class="price-col">
{{--                                <span class="d-inline d-sm-none fw-bold">單價：</span>--}}
                                $84.00
                            </td>
                            <td class="total-col">
{{--                                <span class="d-inline d-sm-none fw-bold">小計：</span>--}}
                                $11600
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
@push('app-scripts')
@endpush