@extends('admin.layouts.appIframeMode')

{{--@section('title', '會員註冊')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">TCG SHOP 註冊申請</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-form" class="admin-form" action="{{ route('staffRegisterAction') }}" method="post">
    @csrf
        <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="{{$vendor_id}}" >
    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-10">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">基本資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="form-group col-md-4">
                                        <label class="required-label" for="name">姓名</label>
                                        <input type="text" class="form-control form-required" name="name" id="name" value="{{ old('name') }}" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="required-label" for="email">帳號</label>
                                        <input type="email" class="form-control form-required" name="email" id="email" value="{{ $email }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="phone">電話</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="required-label" for="password">密碼</label>
                                        <button type="button" class="btn btn-sm btn-outline-secondary random-password"><i class="fas fa-random"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary view-password"><i class="fas fa-eye"></i></button>
                                        <input type="password" id="password" class="form-control form-required" name="password" value="" autocomplete="new-password">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="required-label" for="password">二次密碼確認</label>
                                        <input type="password" id="second_password" class="form-control form-required" name="second_password" value="" autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-2">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">動作</h3>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">送出</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
