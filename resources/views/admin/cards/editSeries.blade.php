@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">修改卡牌系列</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.series.index')}}">卡牌系列</a></li>
                        <li class="breadcrumb-item active">修改卡牌系列</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="create-Form" class="create-Form" action="{{ route('admin.series.update',['series'=>$series->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">卡牌系列資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">

                                    <div class="col-12">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-4">
                                                <label class="field-name" for="title">系列標題</label>
                                                <input type="text" class="form-control" name="title" id="title" placeholder="系列標題" value="{{$series->title}}">
                                            </div>
                                            <div class="form-group col-4">
                                                <label class="field-name" for="title">系列編號</label>
                                                <input type="text" class="form-control" name="serial_number" id="serial_number" placeholder="系列編號" value="{{$series->serial_number}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-3">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">動作</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-12 row">
                                    <div class="form-group col-12">
                                        <label class="field-name" for="kingdom">卡牌領域</label>
                                        <select class="form-control" name="kingdom" id="kingdom">
                                            @foreach($kingdoms as $key => $kingdom)
                                                <option value="{{$key}}" {!! $html->selectSelected($key,$series->kingdom) !!}>{{$kingdom}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="field-name" for="sort">排序</label>
                                        <input type="number" step="1" class="form-control" name="sort" id="sort" value="{{$series->sort}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="submit_btn btn btn-info" >送出</button>
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
