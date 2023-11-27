@extends('layouts.app')


@push('app-styles')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
    <style>

        /*left right modal*/
        .modal.left_modal{
            position: fixed;
            z-index: 9999;
        }
        .modal.left_modal .modal-dialog{
            position: fixed;
            margin: auto;
            width: 32%;
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }
        .modal-dialog {
            /* max-width: 100%; */
            margin: 1.75rem auto;
        }
        @media (min-width: 576px)
        {
            .left_modal .modal-dialog {
                max-width: 35%;
            }
            #card_info_modal .modal-dialog {
                max-width: 50% !important;
            }

        }
        .modal.left_modal .modal-content{
            /*overflow-y: auto;
            overflow-x: hidden;*/
            height: 100vh !important;
        }
        /*!*Left*!*/
        .modal.left_modal.fade .modal-dialog{
            left: -50%;
            -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
            -o-transition: opacity 0.3s linear, left 0.3s ease-out;
            transition: opacity 0.3s linear, left 0.3s ease-out;
        }

        .modal.left_modal.fade.show .modal-dialog{
            left: 0;
            box-shadow: 0px 0px 19px
            rgba(0,0,0,.5);
        }

        /*!* ----- MODAL STYLE ----- *!*/
        .modal-content {
            border-radius: 0;
            border: none;
        }

        .modal-header.left_modal{
            padding: 10px 15px;
            border-bottom-color:
            #EEEEEE;
            background-color:
            #FAFAFA;
        }

        .modal_outer .modal-body {
            /*height:90%;*/
            overflow-y: auto;
            overflow-x: hidden;
            height: 91vh;
        }

        .modal-open {
            overflow-y: auto;
            padding-right: 0px !important;
        }

        #modal_view_left{
            border-radius: 0px 25px 25px 0px;
        }

        .box{
            text-align: center;
            border: solid 2px ;
            background-color:#333;
            color:#fff;
            border-radius: 5px;
            box-shadow: 0px 0px 12px rgba(0,0,0,0.5);
        }
        .minus,.add {
            display: inline-block;
            font-size: 15px;
        }
        .minus,.add {
            padding-left: 10px;
            padding-right: 10px;
            cursor: pointer;
        }
        .minus,.add {
            width:30px;
            -webkit-user-select: none;
        }
        .minus:hover, .add:hover {
            background-color: #666;
            color: #fff;
        }
        #card_count{
            position: absolute;
            top: 0px;
            right: 0px;
            font-size: 8px;
        }
        .energy-image{
            width: 20px;
            height: 100%;
            margin-left: 5px;
        }
        .hp{
            margin-left: 5px;
        }



        .modal.form-modal{
            position: fixed;
            z-index: 10000;
            background-color: #00000060;
        }
    </style>

@endpush
@section('content')
    <section class="content">

        <button class="btn btn-lg btn-info position-fixed " style="z-index: 99; margin-left: -10px;"  id="modal_view_left" data-bs-toggle="modal" data-bs-backdrop="true" data-bs-target="#get_quote_modal">
            <i  class="fas fa-inbox"></i>
            <span class="badge badge-danger " id="card_count">{{$count}}</span>
        </button>
        <div class="container-fluid">
            <div class="col-md-12 m-1">
                <img alt="Bootstrap Image Preview" id="banner" class="w-100" src="/storage/image/ptcg/poke-banner.jpg" />
            </div>
            <div class="row mt-5">
                <div class="col-md-3">
                    <form role="form" class="m-2">
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label for="keyword">關鍵字</label>
                                <input class="form-control" type="text" id="keyword" name="keyword" value="{{$queried['keyword']}}" placeholder="名稱">
                            </div>
                            <div class="form-group col-md-12 col-6">
                                <label for="supertypes">卡牌類型</label>
                                <select name="supertypes[]" id="supertypes" class="form-control select2" multiple>
                                    @foreach($supertypes as $supertype)
                                        <option value="{{$supertype}}" {{ in_array($supertype,$queried['supertypes'])?'selected':'' }}>{{$supertype}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-6">
                                <label for="supertypes">卡牌屬性</label>
                                <select name="types[]" id="types" class="form-control select2" multiple>
                                    @foreach($types as $key=> $type)
                                        <option value="{{$key}}" {{ in_array($key,$queried['types'])?'selected':'' }}>{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-6">
                                <label for="supertypes">稀有度</label>
                                <select name="rarity[]" id="rarity" class="form-control select2" multiple>
                                    @foreach($rarities as $rarity)
                                        <option value="{{$rarity}}" {{ in_array($rarity,$queried['rarity'])?'selected':'' }}>{{$rarity}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-6">
                                <label for="supertypes">賽制</label>
                                <select name="competition" id="competition" class="form-control" >
                                    <option value="">全部</option>
                                    @foreach($competitions as $key => $competition)
                                        <option value="{{$key}}" {{ $html->selectSelected($key,$queried['competition']) }}>{{$competition}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-secondary float-right">
                            搜尋
                        </button>
                    </form>
                </div>
                <div class="col-md-9 col-12 mt-5">
                    <div class=" scrolling-pagination" >
                        <div class="row  m-1">
                            @foreach($TWCards as $TWCard)
                                <div class="col-md-2 col-6 mb-2" >
                                    <span>{{$TWCard->name}}</span>
                                    <span class="badge badge-warning CardCount" id="CardCount-{{$TWCard->id}}">{{ ($deck[$TWCard->id]['number'])??'' }}</span>
                                    <img class="w-100 m-1" src="{{$TWCard->image}}" />
                                    <a href="javascript:void(0)" class="add-to-deck" data-id="{{$TWCard->id}}"><i class="fas fa-plus mr-1"></i>新增至牌組</a>
                                    <a href="javascript:void(0)" class="info-modal float-right text-dark" data-id="{{$TWCard->id}}" data-bs-toggle="modal"  data-bs-target="#card_info_modal" data-focus="false">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div id="pagination">
                            {{ $TWCards->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal modal_outer left_modal fade" id="get_quote_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" >
        <div class="modal-dialog w-75" role="document">
                <div class="modal-content ">
                    <button type="button" class="btn btn-outline-danger" id="clean-deck">清空牌組</button>
                    <div class="modal-header">
                        <h2 class="modal-title">我的牌組</h2> (<span id="deckCardCount">{{$count}}</span> / 60)

{{--                        <button type="button" class="btn btn-sm btn-success ml-1" id="save-deck">儲存牌組</button>--}}
                        <button type="button" class="btn btn-sm btn-success ml-1" id="send-to-cat" data-bs-toggle="modal"  data-bs-target="#SendToCatForm">發送給貓腳印</button>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="modal-body" id="deck-cards">
                        <div class="row" >
                            @foreach($deck as $CID => $Card)
                                <div class="col-md-4 col-6 mb-3 deck-card-info" data-id="{{$CID}}" id="CID-{{$CID}}" >
                                    <span>{{$Card['name']}}</span>
                                    <img class="w-100 m-1" src="{{$Card['image']}}" />
                                    <div class="box">
                                        <div class="minus changeCardNumber" data-type="minus">-</div>
                                        <span class="badge badge-secondary cardNumber">{{$Card['number']}}</span>
                                        <div class="add changeCardNumber" data-type="add">+</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div><!-- //modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    <!-- //left modal -->

    <div class="modal fade" id="card_info_modal" tabindex="-1" role="dialog" aria-labelledby="CardInfoModal" >
        <div class="modal-dialog w-50" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h2 class="modal-title "></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <div class="row" >
                        <div class="col-md-6 col-4"  >
                            <img class="w-100 m-1" id="ModalCardImage" src="" />
                        </div>
                        <div class="col-md-6 col-8 " id="ModalCardInfoHtml">
                        </div>
                    </div>
                </div>

            </div><!-- //modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->


    <div class="modal fade form-modal bg-form" id="SendToCatForm" tabindex="-1" role="dialog" aria-labelledby="SendToCat" >
        <div class="modal-dialog w-75" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h2 class="modal-title">訂單基本資料</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <form id="create-order-form" class="create-order-form" action="{{ route('orderCreate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Main content -->
                        <section class="content">
                            <div class="container-fluid">
                                <!-- Main row -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="user_id" value="{{(\Illuminate\Support\Facades\Auth::id())??'1'}}">
                                        <input type="hidden" class="form-control" name="cardData" value="{{ json_encode($deck) }}">
                                        <div class="form-group col-md-12">
                                            <label class="field-name" for="sender">姓名*</label>
                                            <input type="text" class="form-control form-required" name="sender" id="sender">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="field-name" for="s_phone">電話*</label>
                                            <input type="text" class="form-control form-required" name="s_phone" id="s_phone">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="field-name" for="s_email">信箱*</label>
                                            <input type="email" class="form-control form-required" name="s_email" id="s_email">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="field-name" for="note">訂單備註</label>
                                            <textarea name="note" id="note" rows="3" class="form-control"></textarea>
                                        </div>
                                        <button type="submit" class="submit_btn btn btn-info" >送出</button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>

            </div><!-- //modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->


@endsection

@push('app-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(".card-image").lazyload({
            effect : "fadeIn"
        });
        $(function() {
            $('.scrolling-pagination').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scrolling-pagination',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
        $('body').on('click','.add-to-deck',function (e){
            let id = $(this).data('id');
            $.ajax({
                type: "POST",
                url:"./addToDeck",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                    'number':1,
                },
                success:function(object){
                    if(object.result === '1' ){
                        $('#deckCardCount').html(object.count);
                        $('#card_count').html(object.count);
                        $('#deck-cards').html(object.html);
                        $('#CardCount-'+id).html(object.CardCount);
                    }else{
                        alert(object.message);
                    }
                }
            });
        });
        $('body').on('click','.changeCardNumber',function (e){
            let id = $(this).closest('.deck-card-info').data('id');

            $.ajax({
                type: "POST",
                url:"./ChangeDeckCard",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                    'type': $(this).data('type'),
                },
                success:function(object){
                    if(object.result === '1' ){
                        let $cardInfo = $('#CID-'+object.CID);
                        if(object.delete === false){
                            $cardInfo.find('.cardNumber').html(object.number);
                            $('#CardCount-'+id).html(object.number);
                        }else{
                            $cardInfo.remove();
                            $('#CardCount-'+id).html('');
                        }
                        $('#card_count').html(object.count);
                        $('#deckCardCount').html(object.count);

                    }else{
                        alert(object.message);
                    }
                }
            });
        });

        $('#clean-deck').on('click',function () {
            $.ajax({
                type: "POST",
                url:"./CleanDeck",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success:function(object){
                    $('#deck-cards').html('');
                    $('#card_count').html(0);
                    $('#deckCardCount').html(0);
                    $('.CardCount').html('');
                    alert('已清空牌組!');
                }
            });
        });
        $('body').on('click','.info-modal',function (e){
            let id = $(this).data('id');
            $.ajax({
                type: "POST",
                url:"./GetCardData",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                },
                success:function(object){
                    if(object.result === '1' ){
                        console.log(object);
                        $('#ModalCardInfoHtml').html(object.html);
                        $('#ModalCardImage').attr('src',object.image);
                    }else{
                        alert(object.message);
                    }
                }
            });
        });


        $('.submit_btn').on('click',function (e){
            let invalid = false;
            $('.form-required').each((index, ele) => {
                if(!$(ele).val()) {
                    invalid = true;
                    alert('請填寫完整個人資料!');
                    return false;
                }
            });
            if(invalid) {
                return false;
            }
        });
    </script>
@endpush
