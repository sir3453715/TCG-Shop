@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">產品管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">產品管理</li>
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
                <a href="{{route('admin.product.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
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
                                    <label for="card_id">卡牌編號</label>
                                    <input class="form-control" type="text" id="card_id" name="card_id" value="{{$queried['card_id']}}" placeholder="名稱">
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label for="status">狀態</label>
                                    <select id="status" class="form-control " name="status" >
                                        <option value="" >請選擇</option>
                                        <option value="1" {!! $html->selectSelected('1',$queried['status']) !!}>是</option>
                                        <option value="0" {!! $html->selectSelected('0',$queried['status']) !!}>否</option>
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
                    <table class="table-default table w-100">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>卡牌名稱</th>
                            <th>圖片</th>
                            <th @if($vendor_id)data-visible="false" @endif>店家</th>
                            <th>狀態</th>
                            <th>金額</th>
                            <th>庫存</th>
                            <th style="width: 15%">動作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td></td>
                                    <td>
                                        <a href="{{route('admin.product.edit',['product'=>$product->id])}}">{{$product->card->name}}</a>
                                    </td>
                                    <td>
                                        <img class="zoomIn-img" src="{{$product->card->image}}" width="100px">
                                    </td>
                                    <td>{{ $product->vendor->name }}</td>
                                    <td>
                                        @if($product->status)
                                            <span class="badge badge-success fa-1x" role="alert">上架</span>
                                        @else
                                            <span class="badge badge-danger fa-1x" role="alert">下架</span>
                                        @endif
                                    </td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->stock}}</td>
                                    <td class="action">
                                        <div class="d-flex">
                                            <a href="{{route('admin.product.edit',['product'=>$product->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                            <form action="{{ route('admin.product.destroy', ['product' => $product->id]) }}" method="post" class="form-btn">
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
                <div class="card-footer clearfix">
                    {{ $products->appends(request()->except('page'))->links() }}
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection
