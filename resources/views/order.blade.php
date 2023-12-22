@extends('layouts.app')
@section('content')

<div id="my-order" class="m-3 m-lg-5 pt-lg-0 pt-4">
    @foreach($orders as $order)
        <a class="text-decoration-none text-dark" href="{{route('myAccount.orderDetail',['order_id'=>$order->id])}}">
            <div class="row order-list bg-white rounded-3 border border-dark p-3 mb-4">
                <div class="col-sm-1 d-flex justify-content-md-center align-items-center mb-2 mb-md-0">
                    <i class="fa-regular fa-file-lines fs-1"></i>
                </div>
                <div class="col-sm-4">
                    <div class="d-flex flex-wrap justify-content-between mb-md-3 mb-2">
                        <div>訂購單編號</div>
                        <div class="order-number">{{$order->seccode}}</div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between mb-md-3 mb-2">
                        <div>訂購日期</div>
                        <div class="order-date fw-bold">{{$order->created_at->format('Y/m/d')}}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="d-flex flex-wrap justify-content-md-start justify-content-between mb-md-3 mb-2">
                        <div class="me-2">訂單狀態</div>
                        <div class="order-status {{$orderDefaultSetting['status'][$order->status]['bg']}}"> {{$orderDefaultSetting['status'][$order->status]['title']}}</div>

                    </div>
                </div>
                <div class="col-sm-3 d-flex align-items-end mb-md-3 mb-2">
                    <div class="d-flex w-100 justify-content-between">
                      <div>金額</div>
                    <div class="text-red">${{$order->total}}</div>
                    </div>

                </div>
            </div>
        </a>
    @endforeach

    <div class="frontend-pagination">
        {{ $orders->appends(request()->except('page'))->links() }}
    </div>
</div>
@endsection
@push('app-scripts')
@endpush