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
                <span class="deck-btn">{{$order->seccode}}</span>
            </div>
            <div class="d-flex flex-wrap align-items-center">
                <div class="fs-4 me-3">訂購日期</div>
                <div class="fs-4">{{$order->created_at->format('Y/m/d')}}</div>
            </div>
        </div>
    </div>
    <!-- 訂單狀態 -->
    <div class="border border-dark rounded shadow-sm p-4 bg-white mb-4 mb-sm-5">
        <div class="row">
            <h3 class="fs-4 fw-normal">訂單狀態
                <span class="order-status  ms-5 {{$orderDefaultSetting['status'][$order->status]['bg']}}"> {{$orderDefaultSetting['status'][$order->status]['title']}}</span>
            </h3>
            <h4 class="fs-4 fw-normal">收件地址</h4>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">收件人</div>
                    <div class="col-8 fs-5">{{$order->buyer_name}}</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">電話</div>
                    <div class="col-8 fs-5">{{$order->buyer_phone}}</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">取貨方式</div>
                    <div class="col-8 fs-5">{{$orderDefaultSetting['shipment'][$order->shipment]['title']}}</div>
                </div>
                @if($order->shipment == 'homeDelivery')
                    <div class="d-flex border-bottom mt-3">
                        <div class="col-4 fs-5">地址</div>
                        <div class="col-8 fs-5">{{$order->buyer_address}}</div>
                    </div>
                @elseif( in_array($order->shipment,['7-11','Family']) )
                    <div class="d-flex border-bottom mt-3">
                        <div class="col-4 fs-5">超商門市</div>
                        <div class="col-8 fs-5">{{$order->CVS_name}} ( 店號 {{$order->CVS_code}} )</div>
                    </div>
                @endif
                @if($order->shipment != 'inStore')
                    <div class="d-flex border-bottom mt-3">
                        <div class="col-4 fs-5">物流單號</div>
                        <div class="col-8 fs-5">{{($order->shipping_code)??'-'}}</div>
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">付款方式</div>
                    <div class="col-8 fs-5">{{$orderDefaultSetting['payment'][$order->payment]['title']}}</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">商品小計</div>
                    <div class="col-8 fs-5">${{$order->orderItems->sum('subtotal')}}</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">運費</div>
                    <div class="col-8 fs-5">${{$order->shipping}}</div>
                </div>
                <div class="d-flex border-bottom mt-3">
                    <div class="col-4 fs-5">訂單金額</div>
                    <div class="col-8 fs-5 text-red fw-bold">${{$order->total}}</div>
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
                    @foreach($order->orderItems as $orderItem)
                        <tr>
                            <td class="product-col">
                                <div class="product d-block d-sm-flex align-items-center">
                                    <img class="product-media me-sm-3" src="{{$orderItem->card->image}}">
                                    <h3 class="product-title"> {{$orderItem->card->title}} </h3>
                                </div>
                            </td>
                            <td class="quantity-col">{{$orderItem->number}}</td>
                            <td class="price-col">${{$orderItem->unit_price}}</td>
                            <td class="total-col">${{$orderItem->subtotal}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
@push('app-scripts')
@endpush