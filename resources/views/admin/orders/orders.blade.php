@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">訂單管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">訂單管理</li>
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
                <a href="{{route('admin.order.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
            </div>
            <form class="filter">
                <div class="card">
                    <div class="card-body">
                        <div class="col row">
                            <div class="form-group col-12 col-sm-11 row">
                                <div class="form-group col-6 col-sm-2">
                                    <label for="keyword">關鍵字</label>
                                    <input class="form-control" type="text" id="keyword" name="keyword" value="{{$queried['keyword']}}" placeholder="訂單編號、姓名、電話">
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="status">狀態</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="" >全部</option>
                                        @foreach($orderDefaultSetting['status'] as $value => $status)
                                            <option value="{{$value}}" {!! $html->selectSelected($value, $queried['status']) !!}>{{$status['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="payment">付款方式</label>
                                    <select class="form-control" name="payment" id="payment">
                                        <option value="" >全部</option>
                                        @foreach($orderDefaultSetting['payment'] as $value => $payment)
                                            <option value="{{$value}}" {!! $html->selectSelected($value, $queried['payment']) !!}>{{$payment['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="pay_status">付款狀態</label>
                                    <select class="form-control" name="pay_status" id="pay_status">
                                        <option value="" >全部</option>
                                        <option value="1" {!! $html->selectSelected(1, $queried['pay_status']) !!}>已付款</option>
                                        <option value="0" {!! $html->selectSelected(0, $queried['pay_status']) !!}>未付款</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="shipment">取貨方式</label>
                                    <select class="form-control" name="shipment" id="shipment">
                                        <option value="" >全部</option>
                                        @foreach($orderDefaultSetting['shipment'] as $value => $shipment)
                                            <option value="{{$value}}" {!! $html->selectSelected($value, $queried['shipment']) !!}>{{$shipment['title']}}</option>
                                        @endforeach
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
                            <th>訂單編號</th>
                            <th>顧客姓名</th>
                            <th>顧客電話</th>
                            <th>訂單狀態</th>
                            <th>付款方式</th>
                            <th>付款狀態</th>
                            <th>取貨方式</th>
                            <th>訂單金額</th>
                            <th style="width: 15%">動作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{{route('admin.order.edit',['order'=>$order->id])}}">{{$order->seccode}}</a></td>
                                <td>{{$order->buyer_name}}</td>
                                <td>{{$order->buyer_phone}}</td>
                                <td>
                                    <span class="badge {{$orderDefaultSetting['status'][$order->status]['badge']}} fa-1x" role="alert">
                                        {{$orderDefaultSetting['status'][$order->status]['title']}}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{$orderDefaultSetting['payment'][$order->payment]['badge']}} fa-1x" role="alert">
                                        {{$orderDefaultSetting['payment'][$order->payment]['title']}}
                                    </span>
                                </td>
                                <td>
                                    @if($order->pay_status)
                                        <span class="badge badge-success fa-1x" role="alert">已付款</span>
                                    @else
                                        <span class="badge badge-danger fa-1x" role="alert">未付款</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{$orderDefaultSetting['shipment'][$order->shipment]['badge']}} fa-1x" role="alert">
                                        {{$orderDefaultSetting['shipment'][$order->shipment]['title']}}
                                    </span>
                                </td>
                                <td>
                                    {{$order->total}}
                                </td>
                                <td class="action form-inline">
                                    <a href="{{route('admin.order.edit',['order'=>$order->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                    <form action="{{ route('admin.order.destroy', ['order' => $order->id]) }}" method="post" class="form-btn">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger delete-confirm">刪除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <div class="card-footer clearfix bg-white">
                    <div class="col">
                        {{ $orders->appends(request()->except('page'))->links() }}
                    </div>
                    <small>
                        第 {{$orders->firstItem()}} 到 {{$orders->lastItem()}} 筆 共 {{$orders->total()}} 筆
                    </small>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
@endsection
