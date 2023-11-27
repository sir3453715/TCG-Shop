@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">店家管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">店家管理</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="text-right form-group">
                <a href="{{route('admin.vendor.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
            </div>
            <form class="filter">
                <div class="card">
                    <div class="card-body">
                        <div class="col row">
                            <div class="form-group col-12 col-sm-11 row">
                                <div class="form-group col-6 col-sm-2">
                                    <label for="keyword">關鍵字</label>
                                    <input class="form-control" type="text" id="keyword" name="keyword" value="{{$queried['keyword']}}" placeholder="店家名稱">
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="status">狀態</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="" >全部</option>
                                        <option value="1" {!! $html->selectSelected(1,$queried['status']) !!}>上架</option>
                                        <option value="0" {!! $html->selectSelected(0,$queried['status']) !!}>下架</option>
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
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table-default table  w-100">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>店家名稱</th>
                            <th>綁定帳號</th>
                            <th>狀態</th>
                            <th style="width: 15%">動作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vendors as $vendor)
                            <tr>
                                <td></td>
                                <td>
                                    <a href="{{route('admin.vendor.edit',['vendor'=>$vendor->id])}}">{{$vendor->name}}</a>
                                </td>
                                <td>
                                    {{$vendor->user->name}}( {{$vendor->user->email}} )
                                </td>
                                <td>
                                    @if($vendor->status)
                                        <span class="badge badge-success fa-1x" role="alert">啟用</span>
                                    @else
                                        <span class="badge badge-danger fa-1x" role="alert">不啟用</span>
                                    @endif
                                </td>
                                <td class="action">
                                    <div class=" form-inline">
                                        <a href="{{route('admin.vendor.edit',['vendor'=>$vendor->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                        <form action="{{ route('admin.vendor.destroy', ['vendor' => $vendor->id]) }}" method="post" class="form-btn">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-danger delete-confirm">刪除</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix bg-white">
                    <div class="col">
                        {{ $vendors->appends(request()->except('page'))->links() }}
                    </div>

                    <small>
                        第 {{$vendors->firstItem()}} 到 {{$vendors->lastItem()}} 筆 共 {{$vendors->total()}} 筆
                    </small>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
@endsection
