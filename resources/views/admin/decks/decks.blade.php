@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">牌組資料</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">牌組資料</li>
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
                <a href="{{route('admin.deck.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
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
                                    <label for="is_recommend">是否是推薦牌組</label>
                                    <select id="is_recommend" class="form-control form-required " name="is_recommend" >
                                        <option value="" >請選擇</option>
                                        <option value="Y" {!! $html->selectSelected('Y',$queried['is_recommend']) !!}>是</option>
                                        <option value="N" {!! $html->selectSelected('N',$queried['is_recommend']) !!}>否</option>
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
                            <th>牌組名稱</th>
                            <th>牌組代碼</th>
                            <th>是否推薦</th>
                            <th>卡牌數量</th>
                            <th>所屬會員</th>
                            <th>構築表</th>
                            <th style="width: 15%">動作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($decks as $deck)
                            <tr>
                                <td></td>
                                <td>
                                    <a href="{{route('admin.deck.edit',['deck'=>$deck->id])}}">{{$deck->title}}</a>
                                </td>
                                <td>{{$deck->code}}</td>
                                <td>
                                    @switch($deck->is_recommend)
                                        @case(true)
                                        <span class="badge badge-success fa-1x" role="alert">是</span>
                                        @break
                                        @case(false)
                                        <span class="badge badge-danger fa-1x" role="alert">否</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>{{$deck->deckUnserialize()['count']}}</td>
                                <td>{{$deck->user()}}</td>
                                <td>
                                    <a href="{{route('admin.deck.build',['deck'=>$deck->id])}}" class="btn btn-sm btn-outline-secondary mr-1" target="_blank">生成構築表</a>
                                </td>
                                <td class="action">
                                    <div class="d-flex">
                                        <a href="{{route('admin.deck.edit',['deck'=>$deck->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                        <form action="{{ route('admin.deck.destroy', ['deck' => $deck->id]) }}" method="post" class="form-btn">
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
                        {{ $decks->appends(request()->except('page'))->links() }}
                    </div>

                    <small>
                        第 {{$decks->firstItem()}} 到 {{$decks->lastItem()}} 筆 共 {{$decks->total()}} 筆
                    </small>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
@endsection
