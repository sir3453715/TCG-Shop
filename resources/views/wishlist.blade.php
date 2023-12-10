@extends('layouts.app')
@section('content')
<div id="my-wishlist" class="m-4 m-lg-5">
    <div class="row deck-list-content gx-3 gy-3">
        <h2 class="col-12 fs-3">支援者</h2>
        @for($i = 1; $i <= 10; $i++)
        <div class="col-sm-6 col-xl-3 mb-4">
                        <div class="card cus-card">
                            <a href="javascript:void(0)" class="info-modal float-right text-dark"
                                data-id="" data-bs-toggle="modal" data-bs-target="#cus-card-info-modal">
                                <div class="card-img-top">
                                    <img class="img-fluid" src="https://asia.pokemon-card.com/tw/card-img/tw00004614.png" />
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="row card-top mb-2">
                                    <div class="col-6 fw-bold card-number">240/172</div>
                                    <div class="col-6 text-end fw-bold card-price">9,999元</div>
                                </div>
                                <div class="row align-items-center mb-2">
                                    <div class="col-10">
                                        <h5 class="card-title">天空之柱</h5>
                                        <p class="card-text">sv3a F 強化擴充包「激狂駭浪」</p>
                                    </div>
                                    <div class="col-2 text-end fs-3">
                                        <a><i class="fa-regular fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <a><i class="fas fa-minus me-3"></i></a>
                                        <a><i class="fas fa-plus"></i></a>
                                    </div>
                                    <div class="col-6 text-end fw-bold">SAR</div>
                                </div>
                            </div>
                        </div>
                        <!-- end card  -->
                    </div>
         @endfor
    </div>
</div>
@endsection
@push('app-scripts')
@endpush