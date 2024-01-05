@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">卡牌管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">卡牌管理</li>
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
                @role('administrator')
                <a href="{{route('admin.card.reinstall')}}"><button type="button" class="btn btn-info">重置卡牌資料</button></a>
                @endrole

                <a href="{{route('admin.card.create')}}"><button type="button" class="btn btn-primary">新增</button></a>
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
                                    <label class="field-name" for="supertypes">卡牌類型</label>
                                    <select id="type" class="form-control form-required " name="type">
                                        <option value="" >請選擇</option>
                                        @foreach($types as $type)
                                            <option value="{{$type}}" {!! $html->selectSelected($type,$queried['type']) !!}>{{ trans($type) }}</option>
                                        @endforeach
                                   </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label class="field-name" for="rarity">卡牌等級</label>
                                    <select id="rarity" class="form-control form-required " name="rarity">
                                        <option value="" >請選擇</option>
                                        @foreach($rarities as $rarity)
                                            <option value="{{$rarity}}" {!! $html->selectSelected($rarity,$queried['rarity']) !!}>{{ trans($rarity) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label class="field-name" for="type">屬性</label>
                                    <select id="attribute" class="form-control form-required " name="attribute" >
                                        <option value="" >請選擇</option>
                                        @foreach($attributes as $attribute)
                                            <option value="{{$attribute}}" {!! $html->selectSelected($attribute,$queried['attribute']) !!}>{{ trans($attribute) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 col-sm-2">
                                    <label class="field-name" for="competition">賽制</label>
                                    <select id="competition" class="form-control form-required " name="competition" >
                                        <option value="" >請選擇</option>
                                        <option value="standard" {!! $html->selectSelected('standard',$queried['competition']) !!}>標準賽</option>
                                        <option value="expanded" {!! $html->selectSelected('expanded',$queried['competition']) !!}>開放賽</option>
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
                                <th>名稱</th>
                                <th>圖片</th>
                                <th>類型</th>
                                <th>屬性</th>
                                <th>稀有度</th>
                                <th>系列</th>
                                <th>賽制</th>
                                <th style="width: 15%">動作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cards as $card)
                                <tr>
                                    <td></td>
                                    <td>
                                        <a href="{{route('admin.card.edit',['card'=>$card->id])}}">{{$card->name}}</a>
                                    </td>
                                    <td>
                                        <img class="zoomIn-img" src="{{$card->image}}" width="100px">
{{--                                        <img src="{{$card->image}}" width="400px">--}}
                                    </td>
                                    <td>{{$card->type}}</td>
                                    <td>{{$card->attribute}}</td>
                                    <td>{{$card->rarity}}</td>
{{--                                    <td>--}}
{{--                                        <select class="form-control form-required rarity-change {{($card->rarity)?'bg-info':''}}" data-id="{{$card->id}}">--}}
{{--                                            <option value="" >請選擇</option>--}}
{{--                                            @foreach($rarities as $rarity)--}}
{{--                                                <option value="{{$rarity}}" {!! $html->selectSelected($rarity,$card->rarity) !!}>{{ trans($rarity) }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </td>--}}
                                    <td>{{$card->series->title}}</td>
                                    <td>
                                        @if(in_array($card->competition_number,explode(',',app('Option')->ptcg_standard)))
                                            <span class="badge badge-warning" role="alert">標準賽</span>
                                        @endif
                                        @if(in_array($card->competition_number,explode(',',app('Option')->ptcg_expanded)))
                                            <span class="badge badge-success" role="alert">開放賽</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <div class="d-flex">
                                            <a href="{{route('admin.card.edit',['card'=>$card->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                            <form action="{{ route('admin.card.destroy', ['card' => $card->id]) }}" method="post" class="form-btn">
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
                            {{ $cards->appends(request()->except('page'))->links() }}
                        </div>

                        <small>
                            第 {{$cards->firstItem()}} 到 {{$cards->lastItem()}} 筆 共 {{$cards->total()}} 筆
                        </small>
                    </div>
                </div>
                <!-- /.card -->
            </div>
    </section>
@endsection


@push('admin-app-scripts')
    <script type="text/javascript">

        $('body').on('change','.rarity-change',function (e){
            let $this = $(this);
            if($(this).val() != ''){
                $.ajax({
                    type: "POST",
                    url:"card/changeRarity",
                    dataType:"json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $(this).data('id'),
                        'rarity': $(this).val(),
                    },
                    success:function(object){
                        $this.addClass("bg-info");
                    }
                });
            }
        });

    </script>

@endpush
