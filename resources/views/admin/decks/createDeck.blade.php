@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">新增牌組</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.deck.index')}}">牌組資料</a></li>
                        <li class="breadcrumb-item active">新增牌組</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="create-Form" class="create-Form" action="{{ route('admin.deck.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">牌組資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-12 col-md-6 row">
                                        <div class="col-12">
                                            <div class="card card-light">
                                                <div class="card-header">
                                                    <h3 class="card-title">牌組</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body p-sm-2">
                                                    <div class="col-12">
                                                        <div class="form-group ">
                                                            <label class="field-name col-12 d-flex justify-content-between" for="clean-deck">牌組名稱
                                                                <span><span id="deckCount">0</span> / 60張</span>
                                                                <span id="clean-btn-">
                                                                    <a id="clean-deck" class="float-right text-danger" type="button" ><i class="fa fa-trash-can">清空牌組</i></a>
                                                                </span>

                                                            </label>
                                                            <input type="text" class="form-control" name="title" id="title" placeholder="牌組名稱">
                                                        </div>
                                                        <div class="overflow-auto" style="height: 100vh;">
                                                            <div class="col-12 row" id="DeckWrapper">
                                                            @foreach($decks as $card)
                                                                <div class="col-md-3 col-6 border p-1 DeckCardInfo" id="DeckCardInfo-{{$card->id}}">
                                                                    <small>{{$card->name}}</small>
                                                                    <img class="w-100 p-1" src="{{$card->image}}" />
                                                                    <div class="d-flex justify-content-between">
                                                                        <a class="changeCardNumber" href="javascript:void(0)" data-id="{{$card->id}}" data-model="plus">                                                                            <span class="badge badge-warning ">
                                                                                <i class="fa fa-plus"></i>
                                                                            </span>
                                                                        </a>
                                                                            <span class="badge badge-secondary fa-1x" id="CardNum-{{$card->num}}">
                                                                                4
                                                                            </span>
                                                                        <a class="changeCardNumber" href="javascript:void(0)" data-id="{{$card->id}}" data-model="minus">                                                                            <span class="badge badge-warning ">
                                                                                <i class="fa fa-minus"></i>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <input type="hidden" name="card_id[]" value="{{$card->id}}">
                                                                    <input type="hidden" name="card_num[]" value="1" id="cardNumInput-{{$card->id}}">
                                                                </div>
                                                            @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 row">
                                        <div class="col-12">
                                            <div class="card card-light">
                                                <div class="card-header">
                                                    <h3 class="card-title">卡牌</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body p-sm-2">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="field-name" for="keyword">搜尋關鍵字</label>
                                                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="卡牌名稱、系列">
                                                        </div>
                                                        <div class="overflow-auto" style="height: 100vh;" >
                                                            <div class="col-12 row" id="CardSearchWrapper">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                        <div class="col-12">
                                            <label class="field-name" for="image">封面圖片</label>
                                            <input type="file" class="form-control-file" name="image" id="image">
                                        </div>
                                        <div class="col-12">
                                            <img id="cardUploadImg" class="w-100 p-3" src="/storage/image/Admin/600x400UploadImageBackground.webp">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label class="field-name" for="competition">賽制</label>
                                        <select class="form-control" name="competition" id="competition">
                                            <option value="standard" >標準賽</option>
                                            <option value="expanded" >開放賽</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="field-name" for="is_recommend">是否為推薦牌組</label>
                                        <select class="form-control" name="is_recommend" id="is_recommend">
                                            <option value="1" >是</option>
                                            <option value="0" >否</option>
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
@endsection

@push('admin-app-scripts')
    <script type="text/javascript">

        $("body").on('click','#cardUploadImg',function () {
            $('#image').click();
        });
        $(document.body).on('change', 'input[type=file]', e => {
            let reader = new FileReader(),
                $this = $(e.currentTarget),
                $preview = $('#cardUploadImg');

            if(!$this.val()) return;
            if($preview.length) {
                reader.onload = function(_e) {
                    $preview.attr('src',_e.target.result);
                }
                reader.readAsDataURL(e.currentTarget.files[0]);

            }
        });

        $('#table-filter').DataTable({
            paging: true,
            searching: true,
            "serverSide": true,
        });

        $('body').on('change','#keyword',function (e){
            $.ajax({
                type: "POST",
                url:window.location.origin+"/GetCardData",
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
        $('body').on('change','#competition',function (e){
            if($('#keyword').val() != ''){
                $.ajax({
                    type: "POST",
                    url:window.location.origin+"/GetCardData",
                    dataType:"json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'keyword': $('#keyword').val(),
                        'competition': $('#competition').val(),
                    },
                    success:function(object){
                        if(object.result === '1' ) {
                            $('#CardSearchWrapper').html(object.html);
                            $('#DeckWrapper').html('');
                            $('#deckCount').html(0);
                        }else{
                            alert('找不到卡牌資料!');
                            $('#CardSearchWrapper').html('');
                        }

                    }
                });
            }
        });



        $('body').on('click','.addToDeck',function (e){
            let id = $(this).data('id'),DeckCard = $('#DeckCardInfo-'+id);
            let CardNum = parseInt($('#CardNum-'+id).html()), deckCount = parseInt($('#deckCount').html());
            if(deckCount === 60){
                alert('牌組已到上限!')
                return false;
            }else{
                if(DeckCard.length>0){
                    if(checkCardLimit(id,CardNum)){
                        CardNum = CardNum+1; deckCount = deckCount+1;
                        $('#CardNum-'+id).html(CardNum);$('#deckCount').html(deckCount);$('#cardNumInput-'+id).val(CardNum);
                    }else{
                        alert('卡牌數量已到上限!')
                        return false;
                    }
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
                                $('#DeckWrapper').append(object.html);
                                deckCount = deckCount+1;
                                $('#deckCount').html(deckCount);
                            }else{
                                alert('無法加入牌組!');
                            }
                        }
                    });
                }
            }
        });
        $('body').on('click','.changeCardNumber',function (e){
            let id = $(this).data('id'), model = $(this).data('model'),DeckCard = $('#DeckCardInfo-'+id);
            let CardNum = parseInt($('#CardNum-'+id).html()), deckCount = parseInt($('#deckCount').html());
            if(model === 'plus'){
                if(deckCount === 60){
                    alert('牌組已到上限!')
                    return false;
                }else{
                    if(checkCardLimit(id,CardNum)){
                        CardNum = CardNum+1; deckCount = deckCount+1;
                        $('#CardNum-'+id).html(CardNum);$('#deckCount').html(deckCount);$('#cardNumInput-'+id).val(CardNum);
                    }else{
                        alert('卡牌數量已到上限!')
                        return false;
                    }
                }
            }else if(model === 'minus'){
                CardNum = CardNum-1; deckCount = deckCount-1;
                $('#CardNum-'+id).html(CardNum);$('#deckCount').html(deckCount);$('#cardNumInput-'+id).val(CardNum);
                if(CardNum === 0){
                    $('#DeckCardInfo-'+id).remove();
                }
            }
        });

        $('#clean-deck').on('click',function () {
            $('#DeckWrapper').html('');
            $('#deckCount').html('0');
            alert('已清空牌組!');
        });
        function checkCardLimit(id,CardNum){
            let result;
            $.ajax({
                type: "POST",
                url:window.location.origin+"/checkCardLimit",
                dataType:"json",
                async: false,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                    'CardNum': CardNum,
                },
                success:function(object){
                    result = object.result;
                }
            });

            return result;
        }

    </script>
@endpush
