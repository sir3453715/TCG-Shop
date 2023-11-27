@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">會員資料 {{ $user->name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.user.index')}}">會員管理</a></li>
                        <li class="breadcrumb-item active">修改會員</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-form" class="admin-form" action="{{ route('admin.user.update',['user'=>$user->id]) }}" method="post">
        @csrf
        @method('PUT')
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
                                        <label for="name">姓名</label>
                                        <input type="text" class="form-control form-required" name="name" id="name" value="{{$user->name}}" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">帳號(電子郵件)</label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}" disabled>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="phone">電話</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{$user->phone}}" autocomplete="new-password">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="field-name" for="password">密碼</label>
                                        <button type="button" class="btn btn-sm btn-outline-secondary random-password"><i class="fas fa-random"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary view-password"><i class="fas fa-eye"></i></button>
                                        @if($user) <small><label class="help-label"><input type="checkbox" name="change_password" value="1"> 若要修改密碼請打勾</label></small> @endif
                                        <input type="password" id="password" class="form-control" name="password" value="" autocomplete="new-password">
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
                            <div class="card-body">
                                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator'))
                                    <div class="form-group">
                                        <label for="status">啟用狀態</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="0" {!! $html->selectSelected(0, $user->status) !!}>未啟用</option>
                                            <option value="1" {!! $html->selectSelected(1, $user->status) !!}>啟用</option>
                                        </select>
                                    </div>
                                @endif
                                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator') || \Illuminate\Support\Facades\Auth::user()->hasRole('manager'))
                                    <div class="form-group">
                                        <label for="status">角色</label>
                                        <select name="users_role" id="users-role" class="form-control select2">
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" {!! $html->selectSelected($role->id, $user_roles) !!}>{{$role->display_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
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

@push('admin-app-scripts')
@endpush