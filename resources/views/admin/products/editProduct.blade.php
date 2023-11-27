@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">修改產品 {{ $product->card->name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.product.index')}}">產品管理</a></li>
                        <li class="breadcrumb-item active">修改產品</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="create-Form" class="create-Form" action="{{ route('admin.product.update',['product'=>$product->id]) }}" method="post" enctype="multipart/form-data">
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
                                <h3 class="card-title">產品資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-12 col-md-3 row">
                                        <div class="col-6 col-md-12">
                                            <label class="field-name" for="image">卡牌圖片</label>
                                            <a href="javascript:void(0)" class="btn btn-secondary col-12" data-bs-toggle="modal" data-bs-target="#selectCard">
                                                選擇卡牌
                                            </a>
                                        </div>
                                        <div class="col-6 col-md-12">
                                            <img id="cardSelectImg" class="w-100 p-3" src="{{ $product->card->image }}">
                                            <input type="hidden" id="card_id" name="card_id" value="{{ $product->card_id }}">
                                            <input type="hidden" id="vendor_id" name="vendor_id" value="{{ $product->vendor_id }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="series">卡牌名稱</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="卡牌名稱" disabled value="{{ $product->card->name }}">
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="price">卡牌金額</label>
                                                <input type="number" min="0" step="1" class="form-control" name="price" id="price" placeholder="產品金額" value="{{ $product->price }}" >
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="stock">庫存</label>
                                                <input type="number" min="0" step="1" class="form-control" name="stock" id="stock" placeholder="庫存" value="{{ $product->stock }}" >
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
                                        <label class="field-name" for="status">狀態</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1" {!! $html->selectSelected(1,$product->status) !!}>上架</option>
                                            <option value="0" {!! $html->selectSelected(0,$product->status) !!}>下架</option>
                                        </select>
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

    <div class="modal fade" id="selectCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-m75">
            <div class="modal-content">
                <div class="modal-header bg-success-subtle">
                    <h5 class="modal-title" id="staticBackdropLabel">搜尋卡牌</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="field-name" for="keyword">搜尋關鍵字</label>
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="卡牌名稱、系列">
                            </div>
                            <div class="overflow-auto" style="height: 60vh;" >
                                <div class="col-12 row" id="CardSearchWrapper">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="selectCardBtn" class="btn btn-primary" data-bs-dismiss="modal">選擇</button>
                </div>
            </div>
        </div>
    </div><!-- modal -->

@endsection

@push('admin-app-scripts')
    <script type="text/javascript">

        $('#cardSelectImg').click(function (){
            $("#selectCard").modal('show');
        });

        $('body').on('change','#keyword',function (e){
            $.ajax({
                type: "POST",
                url:window.location.origin+"/GetProductCard",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'keyword': $('#keyword').val(),
                    'competition': $('#competition').val(),
                },
                success:function(object){
                    if(object.result === '1' ) {
                        $('#CardSearchWrapper').html(object.html);

                    }else{
                        alert('找不到卡牌資料!');
                        $('#CardSearchWrapper').html('');
                    }

                }
            });
        });


        $('body').on('click','.selectCardClick',function (e){
            $('.productCardSelected').removeClass('productCardSelected');
            $(this).closest('.CardOption').addClass('productCardSelected');
        });

        $('body').on('click','#selectCardBtn',function (e){
            let id = $('.productCardSelected').data('id'), img = $('.productCardSelected').find('img').attr('src'),name = $('.productCardSelected').find('.card-name').html();
            $('#card_id').val(id);
            $('#cardSelectImg').attr('src',img);
            $('#name').val(name);
            $('.productCardSelected').removeClass('productCardSelected');
            $('#keyword').val('');
            $('#CardSearchWrapper').html('');
        });

    </script>

@endpush
