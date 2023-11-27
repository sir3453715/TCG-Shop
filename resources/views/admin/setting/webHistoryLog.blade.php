@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">History Log</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">History Log </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form class="filter">
                <div class="card">
                    <div class="card-body">
                        <div class="col row">
                            <div class="form-group col-12 col-sm-11 row">
                                <div class="form-group col-6 col-sm-2">
                                    <label for="id">ID</label>
                                    <input class="form-control" type="text" id="id" name="id" placeholder="ID" value="{{$queried['id']}}" >
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="table">資料表</label>
                                    <select class="form-control" id="table" name="table">
                                        <option value="">全部</option>
                                        @foreach($tables as $table)
                                            <option value="{{$table}}" {!! $html->selectSelected($table,$queried['table']) !!}>{{$table}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="action">動作</label>
                                    <select class="form-control" id="action" name="action">
                                        <option value="">全部</option>
                                        <option value="新增" {!! $html->selectSelected('新增',$queried['action']) !!}>新增</option>
                                        <option value="修改" {!! $html->selectSelected('修改',$queried['action']) !!}>修改</option>
                                        <option value="刪除" {!! $html->selectSelected('刪除',$queried['action']) !!}>刪除</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-right w-auto">
                                <button type="submit" class="form-control btn btn-outline-dark">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>
            <!-- Main row -->
            <div class="card card-warning">
                <!-- ./row -->
                <div class="card-header">
                    <h3 class="card-title">網站操作紀錄</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <table class="table-default table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>操作者</th>
                                <th>更動資料表</th>
                                <th>更動ID</th>
                                <th>動作</th>
                                <th>更動項目</th>
                                <th>時間</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($action_log as $action)
                                <tr>
                                    <td>
                                        @if($action->user)
                                            <a href="{{route('admin.user.edit',['user'=>$action->user->id])}}" target="_blank">
                                                {{$action->user->name}}
                                            </a>
                                        @else
                                            系統自動
                                        @endif
                                    </td>
                                    <td>{{$action->action_table}}</td>
                                    <td>{{$action->action_id}}</td>
                                    <td>{{$action->action}}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#detail{{$action->id}}">
                                            檢視詳細
                                        </button>
                                    </td>
                                    <td>{{$action->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $action_log->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>

    @foreach($action_log as $action)
    <div>
        <div class="modal" id="detail{{$action->id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">操作詳細更動項目</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                        <!-- Modal body -->

                    <div class="modal-body">
                        <div class="col-12">
                            <div class="col-12">
                                <ul class="list-auto">
                                    @foreach(json_decode($action->change_column) as $key =>  $change_item )
                                        <li class="list-auto-item text-lg"> {{$key}} : {!! $change_item  !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach


@endsection


@push('admin-app-scripts')
@endpush
