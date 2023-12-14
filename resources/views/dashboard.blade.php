@extends('layouts.app')

@section('content')
<div class="m-0 m-lg-5 bg-white">
    <div class="p-5">
        <div class="user-info d-flex align-items-center mb-5">
            <div class="image-fluid me-3">
                <img src="https://picsum.photos/id/237/200/300" width="48" height="48" alt="User">
            </div>
            <div class="d-flex">
                <p class="col-6 m-0">蕭昌元</p>
                <div class="col-6">
                    <p class="badge rounded-pill bg-yellow m-0">一般會員</p>
                </div>

            </div>
        </div>
        <div class="user-form">
            <div class="mb-3 fs-5">
                 <a href="" class="btn btn-text fs-5 ps-0"><i class="fa-regular fa-pen-to-square me-2"></i>編輯會員資料</a> 
            </div>
          
            <div class="row">
                <div class="col-lg-6">
                    <form>
                        <div class="row">
                            <div class="mb-3">
                                <label for="userid" class="form-label">用戶ID</label>
                                <input type="" class="form-control" id="" aria-describedby="userId">
                            </div>
                            <div class="mb-5">
                                <label for="Email1" class="form-label">電子信箱</label>
                                <input type="email" class="form-control" id="Email1" aria-describedby="emai">
                            </div>
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label for="passChange" class="form-label me-3">密碼變更</label>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="passCheck">
                                        <label class="form-check-label" for="passCheck">若需修改密碼請打勾</label>
                                    </div>
                                </div>
                                <input type="" class="form-control" id="" aria-describedby="">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">二次密碼確認</label>
                                <input type="" class="form-control" id="" aria-describedby="">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">姓名</label>
                        <input type="" class="form-control" id="" aria-describedby="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">生日日期 (選填)</label>
                        <input type="" class="form-control" id="" aria-describedby="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">連絡電話</label>
                        <input type="" class="form-control" id="" aria-describedby="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">地址</label>
                        <input type="" class="form-control" id="" aria-describedby="">
                    </div>
                    <div class="d-flex">
                            <button type="" class="btn btn-sm btn-sm-yellow fs-6 w-50 me-2">
                            取消
                            </button>
                            <button type="submit" class="btn btn-sm btn-sm-black fs-6 w-50 ms-2">
                            儲存變更
                            </button>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@push('app-scripts')
@endpush