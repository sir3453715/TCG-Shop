@extends('layouts.app')
@section('content')
<style>
.order-list {
font-size: 20px;
font-weight: 400;
max-width: 940px;
margin:auto;
}
.order-number {
    background:#F9D61D;
    padding:0 10px;
}
.order-status{
background:#FFCCB6;
padding: 0 10px;
    border-radius: 4px;
}

@media (max-width: 576px) {
    .order-list {
font-size: 16px;
}
}
</style>
<div id="my-order" class="m-3 m-lg-5 pt-lg-0 pt-4">
@for($i = 1; $i <= 4; $i++) 
    <div class="row order-list bg-white rounded-3 border border-dark p-3 mb-4">
        <div class="col-sm-1 d-flex justify-content-md-center align-items-center mb-2 mb-md-0">
            <i class="fa-regular fa-file-lines fs-1"></i>
        </div>
        <div class="col-sm-4">
            <div class="d-flex flex-wrap justify-content-between mb-3">
                <div>訂購單編號</div>
                <div class="order-number">12345RG3A67</div>
            </div>
            <div class="d-flex flex-wrap justify-content-between">
                <div>訂購日期</div>
                <div class="order-date fw-bold">2023/04/24</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="d-flex flex-wrap justify-content-md-end">
                <div class="me-2">訂單狀態</div>
                <div class="order-status"> 處理中</div>
            </div>
        </div>
        <div class="col-sm-3 d-flex align-items-end">
            <div class="d-flex w-100 justify-content-between">
              <div>金額</div>
            <div class="text-red">$990</div>  
            </div>
            
        </div>
    </div>
@endfor
</div>
@endsection
@push('app-scripts')
@endpush