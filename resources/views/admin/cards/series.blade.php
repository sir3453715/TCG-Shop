@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">卡牌系列</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">卡牌系列</li>
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
                <a href="{{route('admin.series.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
            </div>
            <!-- Main row -->
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table-default table  w-100">
                        <thead>
                        <tr>
                            <th>系列名稱</th>
                            <th>系列編號</th>
                            <th>排序</th>
                            <th style="width: 15%">動作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($serieses as $series)
                            <tr>
                                <td>
                                    <a href="{{route('admin.series.edit',['series'=>$series->id])}}">{{$series->title}}</a>
                                </td>
                                <td>
                                    {{$series->serial_number}}
                                </td>
                                <td>
                                    {{$series->sort}}
                                </td>
                                <td class="action">
                                    <div class=" form-inline">
                                        <a href="{{route('admin.series.edit',['series'=>$series->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                        <form action="{{ route('admin.series.destroy', ['series' => $series->id]) }}" method="post" class="form-btn">
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
                        {{ $serieses->appends(request()->except('page'))->links() }}
                    </div>

                    <small>
                        第 {{$serieses->firstItem()}} 到 {{$serieses->lastItem()}} 筆 共 {{$serieses->total()}} 筆
                    </small>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
@endsection
