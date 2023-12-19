@extends('layouts.app')

@section('content')
<div class="m-0 m-lg-5 bg-white">
    <div class="p-5">
        <div class="user-info d-flex align-items-center mb-5">
            <div class="d-flex">
                <p class="col-6 m-0">{{$user->name}}</p>
                <div class="col-6">
                    <p class="badge rounded-pill bg-yellow m-0">一般會員</p>
                </div>

            </div>
        </div>
        <div class="user-form">
            <div class="mb-3 fs-5">
                 <i class="fa-regular fa-pen-to-square me-2"></i>編輯會員資料
            </div>
            <form method="POST" action="{{ route('myAccount.editUser') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="mb-3">
                                <label for="email" class="form-label">帳號 / 電子信箱</label>
                                <input type="email" class="form-control" id="" aria-describedby="email" value="{{$user->email}}" disabled>
                            </div>
                            <div class="row mb-5">
                                <label for="quickLogin" class="form-label">快速登入綁定</label>
                                <div class="col-4">
                                    <a id="account-social-btn-facebook" class="account-social-btn {{($user->facebook == '')?'':"account-social-btn-disabled"}} btn" href="{{route('SocialLogin',['provider'=>'facebook','redirectURL'=>'myAccount.dashboard','binding'=>1]) }}" >
                                        <i class="fa-brands fa-facebook-f me-2"></i>Facebook {{($user->facebook == '')?'':"已綁定"}}
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a id="account-social-btn-google" class="account-social-btn  btn {{($user->google == '')?'':"account-social-btn-disabled"}} " href="{{ route('SocialLogin',['provider'=>'google','redirectURL'=>'myAccount.dashboard','binding'=>1]) }}">
                                        <i class="fa-brands fa-google me-2"></i>Google {{($user->google == '')?'':"已綁定"}}
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a id="account-social-btn-line" class="account-social-btn  btn" href="#">
                                        <i class="fa-brands fa-line me-2"></i>Line
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex">
                                    <label for="passChange" class="form-label me-3">密碼變更</label>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="passCheck">
                                        <label class="form-check-label" for="passCheck">若需修改密碼請打勾</label>
                                    </div>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" aria-describedby="" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="second_password" class="form-label">二次密碼確認</label>
                                <input type="password" class="form-control" id="second_password" name="second_password" aria-describedby="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">姓名</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="" value="{{$user->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">生日日期 (選填)</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" aria-describedby="" value="{{$user->birthday}}">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">連絡電話</label>
                            <input type="text" class="form-control" id="phone" name="phone" aria-describedby="" value="{{$user->phone}}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">地址</label>
                            <input type="text" class="form-control" id="address" name="address" aria-describedby="" value="{{$user->address}}">
                        </div>
                        <div class="d-flex">
                            <button type="" class="btn btn-sm btn-sm-yellow fs-6 w-50 me-2"> 取消 </button>
                            <button type="submit" class="btn btn-sm btn-sm-black fs-6 w-50 ms-2"> 儲存變更 </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('app-scripts')
@endpush