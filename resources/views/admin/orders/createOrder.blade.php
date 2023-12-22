@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">新增訂單</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.order.index')}}">訂單資料</a></li>
                        <li class="breadcrumb-item active">新增訂單</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="create-Form" class="create-Form" action="{{ route('admin.order.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">訂單資訊</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-12 row">
                                        <div class="col-12 col-md-4 row align-content-start">
                                            <div class="form-group col-6 col-md-12">
                                                <label class="field-name" for="seccode">訂單編號</label>
                                                <input type="text" class="form-control" name="seccode" id="seccode" placeholder="訂單編號" disabled>
                                            </div>
                                            <div class="form-group col-6 col-md-12">
                                                <label class="field-name" for="user_id">會員</label>
                                                <select name="user_id" class="form-control search-user" data-placeholder="Search User">
                                                </select>
                                            </div>
                                            <div class="form-group col-6 col-md-12">
                                                <label class="field-name" for="payment">付款方式</label>
                                                <select name="payment" id="payment" class="form-control">
                                                    <option value="" hidden>請選擇</option>
                                                    @foreach($orderDefaultSetting['payment'] as $value => $payment)
                                                        <option value="{{$value}}" >{{$payment['title']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6 col-md-12">
                                                <label class="field-name" for="pay_status">付款狀態</label>
                                                <select name="pay_status" id="pay_status" class="form-control">
                                                    <option value="" hidden>請選擇</option>
                                                    <option value="0">未付款</option>
                                                    <option value="1">已付款</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 row align-content-start">
                                            <div class="form-group col-12 col-md-12">
                                                <label class="field-name" for="shipment">物流方式</label>
                                                <select name="shipment" id="shipment" class="form-control">
                                                    <option value="" hidden>請選擇</option>
                                                    @foreach($orderDefaultSetting['shipment'] as $value => $shipment)
                                                        <option value="{{$value}}" >{{$shipment['title']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group  col-6 col-md-12">
                                                <label class="field-name" for="shipping">物流運費</label>
                                                <input type="number" min="0" class="form-control" name="shipping" id="shipping" placeholder="物流運費" value="0">
                                            </div>
                                            <div class="form-group  col-6 col-md-12">
                                                <label class="field-name" for="shipping_code">物流單號</label>
                                                <input type="text" class="form-control" name="shipping_code" id="shipping_code" placeholder="物流單號" >
                                            </div>
                                            <div class="form-group d-none col-6 col-md-12 cvs-field">
                                                <label class="field-name" for="CVS_name">超商門市名稱</label>
                                                <input type="text" class="form-control" name="CVS_name" id="CVS_name" placeholder="超商門市名稱" >
                                            </div>
                                            <div class="form-group d-none col-6 col-md-12 cvs-field">
                                                <label class="field-name" for="CVS_code">超商店號</label>
                                                <input type="text" class="form-control" name="CVS_code" id="CVS_code" placeholder="超商店號" >
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4  row align-content-start">
                                            <div class="form-group  col-6 col-md-12">
                                                <label class="field-name" for="buyer_name">購買人姓名</label>
                                                <input type="text" class="form-control" name="buyer_name" id="buyer_name" placeholder="購買人姓名">
                                            </div>
                                            <div class="form-group col-6 col-md-12">
                                                <label class="field-name" for="buyer_phone">購買人電話</label>
                                                <input type="text" class="form-control" name="buyer_phone" id="buyer_phone" placeholder="購買人電話">
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <label class="field-name" for="buyer_address">購買人地址</label>
                                                <input type="text" class="form-control" name="buyer_address" id="buyer_address" placeholder="購買人地址">
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <label class="field-name" for="note">訂單備註</label>
                                                <textarea class="form-control" name="note" id="note" rows="3" placeholder="訂單備註"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">訂單商品內容</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                    <div class="form-group col-12">
                                        <table class="table-default table table-bordered w-100">
                                            <thead>
                                            <tr>
                                                <th style="width: 2%">#</th>
                                                <th class="desktop">卡牌名稱</th>
                                                <th class="desktop">類型</th>
                                                <th>數量</th>
                                                <th>金額</th>
                                                <th>小計</th>
                                                <th>動作</th>
                                            </tr>
                                            </thead>
                                            <tbody id="item-tbody">
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            <div class="card-footer">
                                <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#selectItems">
                                    +新增商品
                                </a>
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
                                        <label class="field-name" for="status">訂單狀態</label>
                                        <select class="form-control" name="status" id="status">
                                            @foreach($orderDefaultSetting['status'] as $value => $status)
                                                <option value="{{$value}}" >{{$status['title']}}</option>
                                            @endforeach
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

    <div class="modal fade" id="selectItems" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-m75">
            <div class="modal-content">
                <div class="modal-header bg-success-subtle">
                    <h5 class="modal-title" id="staticBackdropLabel">新增商品</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul class="nav nav-tabs" id="addItemTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#keywordSearch" class="nav-link active" id="keywordSearch-tab" data-bs-toggle="tab" data-bs-target="#keywordSearch" type="button" role="tab" aria-controls="keywordSearch" aria-selected="true">搜尋關鍵字</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#importCode" class="nav-link" id="importCode-tab" data-bs-toggle="tab" data-bs-target="#importCode" type="button" role="tab" aria-controls="importCode" aria-selected="false">代碼匯入</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="addItemTabContent">
                        <div class="tab-pane fade show active" id="keywordSearch" role="tabpanel" aria-labelledby="keywordSearch-tab">
                            <div class="col-12 row pt-3">
                                <div class="col-12 col-md-6 row">
                                    <div class="form-group col-md-4 col-6">
                                        <label class="field-name" for="keyword">搜尋關鍵字</label>
                                        <input type="text" class="form-control" name="keyword" id="keyword" placeholder="卡牌名稱、系列">
                                    </div>
                                    <div class="form-group col-md-4 col-6">
                                        <label class="field-name" for="competition">賽制</label>
                                        <select class="form-control" name="competition" id="competition">
                                            <option value="standard" >標準賽</option>
                                            <option value="expanded" >開放賽</option>
                                        </select>
                                    </div>
                                    <div class="overflow-auto" style="height: 60vh;" >
                                        <div class="col-12 row keywordSearchHtml" id="ItemsSearchWrapper">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 row">
                                    <div class="form-group">
                                        <label class="field-name" for="keyword">已選擇</label>
                                        <a id="clean-select" class="float-right text-danger" type="button" ><i class="fa fa-trash-can">清空選擇</i></a>
                                    </div>
                                    <div class="overflow-auto" style="height: 60vh;" >
                                        <div class="col-12 row keywordSearchHtml" id="ItemsSelectedWrapper">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="selectItemsBtn" class="btn btn-primary" data-bs-dismiss="modal">加入商品</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="importCode" role="tabpanel" aria-labelledby="importCode-tab">
                            <div class="col-12 row pt-3">
                                <div class="col-12 row">
                                    <div class="form-group col-4">
                                        <label class="field-name" for="code">牌組代碼</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="code" id="code" placeholder="請輸入牌組代碼">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-info btn-flat" id="importCodeBtn">匯入</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="overflow-auto" style="height: 60vh;" >
                                        <div class="col-12 row importCodeHtml" id="ItemsImportWrapper">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="importItemBtn" class="btn btn-primary" data-bs-dismiss="modal">加入商品</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- modal -->

@endsection

@push('admin-app-scripts')
    <script type="text/javascript">
        $('.search-user').on('select2:select', function (e) {
            var user_id = e.params.data.id;
            $.ajax({
                type: "POST",
                url:window.location.origin+"/getUser",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'user_id': user_id,
                },
                success:function(object){
                    if(object.result === '1' ) {
                        $('#buyer_name').val(object.user.name);
                        $('#buyer_phone').val(object.user.phone);
                        $('#buyer_address').val(object.user.address);
                    }else{
                        alert('找不到會員資料!');
                    }
                }
            });
        });

        /** 加入商品-搜尋卡牌 */
        $('body').on('change','#keyword',function (e){
            $.ajax({
                type: "POST",
                url:window.location.origin+"/GetItemCard",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'keyword': $('#keyword').val(),
                    'competition': $('#competition').val(),
                },
                success:function(object){
                    if(object.result === '1' ) {
                        $('#ItemsSearchWrapper').html(object.html);
                    }else{
                        alert('找不到商品資料!');
                        $('#ItemsSearchWrapper').html('');
                    }
                }
            });
        });
        $('body').on('change','#competition',function (e){
            if($('#keyword').val() != ''){
                $.ajax({
                    type: "POST",
                    url:window.location.origin+"/GetItemCard",
                    dataType:"json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'keyword': $('#keyword').val(),
                        'competition': $('#competition').val(),
                    },
                    success:function(object){
                        if(object.result === '1' ) {
                            $('#ItemsSearchWrapper').html(object.html);
                        }else{
                            alert('找不到卡牌資料!');
                            $('#ItemsSearchWrapper').html('');
                        }

                    }
                });
            }
        });


        /** 加入商品-卡牌選擇動作 */
        $('body').on('click','.selectItemClick',function (e){
            let id = $(this).data('id'),DeckCard = $('#DeckCardInfo-'+id);
            let CardNum = parseInt($('#CardNum-'+id).html()), deckCount = parseInt($('#deckCount').html());
            if(DeckCard.length>0){
                CardNum = CardNum+1;
                $('#CardNum-'+id).html(CardNum);$('#cardNumInput-'+id).val(CardNum);
            }else{
                $.ajax({
                    type: "POST",
                    url:window.location.origin+"/GetCardData",
                    dataType:"json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': id,
                        'competition': $('#competition').val(),
                    },
                    success:function(object){
                        if(object.result === '1' ) {
                            $('#ItemsSelectedWrapper').append(object.html);
                        }else{
                            alert('無法加入牌組!');
                        }
                    }
                });
            }

        });

        /** 加入商品-卡牌數量變更動作 */
        $('body').on('click','.changeCardNumber',function (e){
            let id = $(this).data('id'), model = $(this).data('model'),DeckCard = $('#DeckCardInfo-'+id);
            let CardNum = parseInt($('#CardNum-'+id).html());
            if(model === 'plus'){
                CardNum = CardNum+1;
                $('#CardNum-'+id).html(CardNum);$('#cardNumInput-'+id).val(CardNum);
            }else if(model === 'minus'){
                CardNum = CardNum-1;
                $('#CardNum-'+id).html(CardNum);$('#cardNumInput-'+id).val(CardNum);
                if(CardNum === 0){
                    $('#DeckCardInfo-'+id).remove();
                }
            }
        });
        /** 加入商品-清空選擇 */
        $('#clean-select').on('click',function () {
            $('#ItemsSelectedWrapper').html('');
            alert('已清空選擇!');
        });



        /** 加入商品-代碼匯入 */
        $('body').on('click','#importCodeBtn',function (e){
            let code = $('#code').val();
            $.ajax({
                type: "POST",
                url:window.location.origin+"/ImportCodeCard",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'code': code,
                },
                success:function(object){
                    if(object.result === '1' ) {
                        $('#ItemsImportWrapper').html('');
                        $('#ItemsImportWrapper').append(object.html);
                    }else{
                        alert('無法加入牌組!');
                    }
                }
            });
        });

        /** 加入商品-tab切換清空畫面 */
        $('#importCode-tab').on('show.bs.tab', function(event){
            cleanAddItemModelHtml();
        });
        $('#keywordSearch-tab').on('show.bs.tab', function(event){
            cleanAddItemModelHtml();
        });

        /** 加入商品-已選商品加入表單 */
        $('body').on('click','#importItemBtn, #selectItemsBtn',function (e){
            var card_ids = $("input[name='card_id[]']")
                .map(function(){
                    return $(this).val();
                }).get();
            var card_nums = $("input[name='card_num[]']")
                .map(function(){
                    return $(this).val();
                }).get();

            $.ajax({
                type: "POST",
                url:window.location.origin+"/addOrderItem",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'card_ids': card_ids,
                    'card_nums': card_nums,
                },
                success:function(object){
                    if(object.result === '1' ) {
                        if($('.dataTables_empty').length>0){
                            $('.dataTables_empty').closest('tr').remove();
                        }
                        object.addItemArray.forEach(function (item,index,arr){
                            let card_id = item.item_card_id; alreadyAddItemCard = $('#item_card_id-'+card_id).length;
                            if(alreadyAddItemCard >0){
                                let AddNumber = item.item_number,ItemNumber = $('#number-'+card_id).val(),ItemUnit = $('#unit_price-'+card_id).val()
                                let newAddNumber = parseInt(ItemNumber) + parseInt(AddNumber);
                                let newSubtotal = ItemUnit*newAddNumber;
                                $('#number-'+card_id).val(newAddNumber);
                                $('#subtotal-'+card_id).val(newSubtotal);
                            }else{
                                let ItemHtml = "<tr><td><div class='d-flex'><input type='hidden' id='item_card_id-"+card_id+"' class='form-control' name='item_card_id[]' value="+card_id+" readonly><img src="+item.item_card_image+" style='width: 40px'></div></td>"+
                                    "<td><input type='text' class='form-control' name='item_card_name[]' value="+item.item_card_name+" readonly></td>"+
                                    "<td><input type='text' class='form-control' name='item_card_type[]' value="+item.item_card_type+" readonly></td>"+
                                    "<td><input type='number' min='1' step='1' class='form-control item_change' id='number-"+card_id+"' data-id='"+item.item_number+"' name='item_number[]' value='"+item.item_number+"'></td>"+
                                    "<td><input type='number' min='0' step='1' class='form-control item_change' id='unit_price-"+card_id+"' data-id="+item.item_unit_price+" name='item_unit_price[]' value="+item.item_unit_price+"></td>"+
                                    "<td><input type='number' min='1' step='1' class='form-control item_subtotal' id='subtotal-"+card_id+"' data-id="+item.item_subtotal+" name='item_subtotal[]' value='"+item.item_subtotal+"' disabled></td>"+
                                    "<td><button type='button' class='btn btn-sm btn-danger item-delete'><i class='fa fa-trash'></i></button></td></tr>";

                                $('#item-tbody').append(ItemHtml);
                            }
                        });
                        cleanAddItemModelHtml();
                    }else{
                        alert('無法加入商品!');
                    }
                }
            });
        });

        /** 加入商品-金額動作 */
        $('body').on('change','.item_change',function (e){
            let id = $(this).data('id'),$sub=0,subtotal=$('#subtotal-'+id);
            let number=$('#number-'+id).val(),unit_price=$('#unit_price-'+id).val();
            $sub = number*unit_price;
            subtotal.val($sub);
        });

        /** 加入商品-刪除商品 */
        $('body').on('click','.item-delete',function (e){
            $(this).closest('tr').remove();
        });


        function cleanAddItemModelHtml(){
            $('#keyword').val('');
            $('#code').val('');
            $('.keywordSearchHtml').html('');
            $('.importCodeHtml').html('');
        }


        /** 物流欄位變動 */
        $('body').on('change','#shipment',function (e){
            let shipment = $(this).val(), CVS_option = ['7-11','Family'];
            console.log(shipment);
            console.log(CVS_option);
            if($.inArray(shipment,CVS_option) != -1){
                $('.cvs-field').removeClass('d-none');
            }else{
                $('.cvs-field').addClass('d-none');
                $('#CVS_name').val('');
                $('#CVS_code').val('');
            }
        });

    </script>
@endpush
