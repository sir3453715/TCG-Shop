@extends('layouts.app')
@section('content')

<div id="invoice" class="m-3 m-lg-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">首頁</a></li>
            <li class="breadcrumb-item"><a href="">購物車</a></li>
            <li class="breadcrumb-item active" aria-current="page">完成訂單</li>
        </ol>
    </nav>
    <div class="row mb-3 mb-lg-4">
    <div class="mt-4 mb-5">
            <div class="text-center">
            <h1><i class="fa-solid fa-circle-check me-4" style="color:#4BAE4F;"></i>完成訂單!</h1>
        </div>
        </div>

        <div class="mb-4">
            <div class="bg-white p-3 text-center" style="border:solid 1px #c6c6c6;">
            <h2 class=" fs-1 fw-bold">合計: NT$6795</h2>
            <p class="m-0 fs-4">訂單明細 ( 9 件)</p>
        </div>
        </div>
        
        <div>
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
                        <span class="d-inline d-sm-none fw-bold">數量：</span>5
                        </td>
                        <td class="price-col"><span class="d-inline d-sm-none fw-bold">單價：</span>$84.00</td>
                        <td class="total-col"><span class="d-inline d-sm-none fw-bold">小計：</span>$11600</td>
                        </td>
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="invloce-detail bg-white p-4 p-lg-5">
        <div class="row gx-5">
            <div class="col-lg-6 pe-lg-5">
            <!-- 訂單資訊 -->
                <span class="fs-4 fw-bold bg-light-yellow px-4 rounded">訂單資訊</span>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">訂單號碼:</div>
                    <div>NT$ 6700</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">訂單電郵:</div>
                    <div>tcg12345@gmail.com</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">訂單日期:</div>
                    <div>2023-10-24 03:47PM</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">訂單狀態:</div>
                    <div>已確認</div>
                </div>

                <!-- 顧客資訊 -->
                <span class="fs-4 fw-bold bg-light-yellow px-4 rounded">顧客資訊</span>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">名稱:</div>
                    <div>20231024074706946</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">電話號碼:</div>
                    <div>tcg12345@gmail.com</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">訂單日期:</div>
                    <div>2023-10-24 03:47PM</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">生日日期:</div>
                    <div>已確認</div>
                </div>

                  <!-- 送貨資訊 -->
                  <span class="fs-4 fw-bold bg-light-yellow px-4 rounded">送貨資訊</span>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">收件人名稱:</div>
                    <div>蕭昌元</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">收件人電話號碼:</div>
                    <div>tcg12345@gmail.com</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">送貨方式:</div>
                    <div>2023-10-24 03:47PM</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">送貨狀態:</div>
                    <div>已確認</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">送貨方式簡介:</div>
                    <div>已確認</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">地址:</div>
                    <div>70956臺南市安南區城西街2段301號20樓</div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">

            <!-- 顧客資訊 -->
            <span class="fs-4 fw-bold bg-light-yellow px-4 rounded">顧客資訊</span>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">名稱:</div>
                    <div>蕭昌元</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">電話號碼:</div>
                    <div>0918706430</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">生日日期:</div>
                    <div>1911/00/00</div>
                </div>

                  <!-- 付款資訊 -->
            <span class="fs-4 fw-bold bg-light-yellow px-4 rounded">付款資訊</span>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">付款方式:</div>
                    <div>信用卡（支援Visa, Master, JCB）</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">付款狀態:</div>
                    <div>已付款</div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">付款指示:</div>
                    <div>若您於付款程序中，不小心跳離或是關閉頁面，請重新下單即可；若您多次遇到付款失敗，請嘗試更換信用卡再次下單，或洽詢發卡行.【提醒您！】本公司不會透過電話要求顧客操作網路銀行或是ATM！若您接到不明來電提及上述內容，切勿提供個人資料！切勿聽信電話指示操作任何動作！並立刻撥打165反詐騙專線或者與我們聯繫！ </div>
                </div>
                <div class="col mb-2 d-flex justify-content-between my-2">
                    <div class="sub-title">綠界交易編號:</div>
                    <div>2310241547083115</div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
@push('app-scripts')
@endpush