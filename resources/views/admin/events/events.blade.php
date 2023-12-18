@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">活動管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">活動管理</li>
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
                <a href="{{route('admin.event.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
            </div>
            <form class="filter">
                <div class="card">
                    <div class="card-body">
                        <div class="col row">
                            <div class="form-group col-12 col-sm-11 row">
                                <div class="form-group col-6 col-sm-2">
                                    <label for="keyword">關鍵字</label>
                                    <input class="form-control" type="text" id="keyword" name="keyword" value="{{$queried['keyword']}}" placeholder="名稱">
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="dateTime">活動日期</label>
                                    <input class="form-control" type="date" id="dateTime" name="dateTime" value="{{$queried['dateTime']}}" placeholder="名稱">
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="class_id">活動分類</label>
                                    <select class="form-control" id="class_id" name="class_id">
                                        <option value="" >全部</option>
                                        @foreach($eventClasses as $eventClass)
                                            <option value="{{$eventClass->id}}" {!! $html->selectSelected($eventClass->id,$queried['class_id']) !!}>{{$eventClass->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="status">狀態</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="" >全部</option>
                                        <option value="1" {!! $html->selectSelected(1,$queried['status']) !!}>上架</option>
                                        <option value="0" {!! $html->selectSelected(0,$queried['status']) !!}>下架</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="top">置頂</label>
                                    <select class="form-control" name="top" id="top">
                                        <option value="" >全部</option>
                                        <option value="1" {!! $html->selectSelected(1,$queried['top']) !!}>是</option>
                                        <option value="0" {!! $html->selectSelected(0,$queried['top']) !!}>否</option>
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
                            <th>活動標題</th>
                            <th>分類</th>
                            <th>狀態</th>
                            <th>置頂</th>
                            <th>活動日期</th>
                            <th style="width: 15%">動作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td></td>
                                <td>
                                    <a href="{{route('admin.event.edit',['event'=>$event->id])}}">
                                        <img  src="{{$event->image}}" width="100px">
                                        {{$event->title}}
                                    </a>
                                </td>
                                <td>{{$event->eventClass->title}}</td>
                                <td>
                                    @if($event->status)
                                        <span class="badge badge-success fa-1x" role="alert">上架</span>
                                    @else
                                        <span class="badge badge-danger fa-1x" role="alert">下架</span>
                                    @endif
                                </td>
                                <td>
                                    @if($event->top)
                                        <span class="badge badge-success fa-1x" role="alert">是</span>
                                    @else
                                        <span class="badge badge-danger fa-1x" role="alert">否</span>
                                    @endif
                                </td>
                                <td>{{$event->dateTime->format('Y-m-d')}}</td>
                                <td class="action">
                                    <div class=" form-inline">
                                        <a href="{{route('admin.event.edit',['event'=>$event->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                        <form action="{{ route('admin.event.destroy', ['event' => $event->id]) }}" method="post" class="form-btn">
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
                        {{ $events->appends(request()->except('page'))->links() }}
                    </div>

                    <small>
                        第 {{$events->firstItem()}} 到 {{$events->lastItem()}} 筆 共 {{$events->total()}} 筆
                    </small>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
@endsection
