@extends('admin.layouts.app')

@section('admin-page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">會員管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">會員管理</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="row">
                        <ul class="list-unstyled d-flex col">
                            <li class="pl-1 pr-1 small border-right border-secondary"><a href="{{'admin.user.index'}}">全部({{$users->total()}})</a></li>
                        @foreach($userCounts as $userCount)
                            <li class="pl-1 pr-1 small border-right border-secondary"><a href="?role={{$userCount['id']}}">{{$userCount['display_name']}}({{$userCount['users_count']}})</a></li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col d-flex filter-form">
                            <form class="form-inline filter">
                                <div class="form-group mr-3">
                                    <label for="users-role">角色</label>
                                    <select name="role" id="users-role" class="form-control ml-3">
                                        <option value="" >全部</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" {{(isset($queried['role']) && $queried['role']==$role->id )?'selected':''}}>{{$role->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <label for="">關鍵字</label>
                                    <input type="text" name="keyword" class="form-control ml-3" placeholder="keyword" value="{{(isset($queried['keyword'])?$queried['keyword']:'')}}">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-outline-dark">篩選</button>
                                </div>
                            </form>
                            <div class="ml-auto">
                                <a href="{{route('admin.user.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Main row -->
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table-default table table-bordered">
                            <thead>
                            <tr>
                                <th>名稱</th>
                                <th>帳號</th>
                                <th>狀態</th>
                                <th>角色</th>
                                <th style="width: 15%">動作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td><a href="{{route('admin.user.edit',['user'=>$user->id])}}">{{$user->name}}</a></td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @switch($user->status)
                                                @case(1)
                                                <span class="badge badge-success fa-1x" role="alert">啟用</span>
                                                @break
                                                @case(0)
                                                <span class="badge badge-danger fa-1x" role="alert">未啟用</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>{{ $user->roles->first()->display_name }}</td>
                                        <td class="action form-inline">
                                            <a href="{{route('admin.user.edit',['user'=>$user->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator'))
                                            <form action="{{ route('admin.user.destroy', ['user' => $user->id]) }}" method="post" class="form-btn">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger delete-confirm mr-1">刪除</button>
                                            </form>
                                            @endif
                                            @if(!$user->email_verified_at)
                                                <a href="{{route('admin.user.resendConfirm',['user'=>$user->id])}}" class="btn btn-sm btn-outline-secondary mr-1">重發驗證信</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <small>
                            第 {{$users->firstItem()}} 到 {{$users->lastItem()}} 筆 共 {{$users->total()}} 筆
                        </small>
                        {{ $users->appends(request()->except('page'))->links() }}
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection

