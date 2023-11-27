@extends('layouts.app')


@push('app-styles')
    <style>
        @media (min-width: 576px)
        {
            #card_info_modal .modal-dialog {
                max-width: 50% !important;
            }

        }
        .energy-image{
            width: 20px;
            height: 100%;
            margin-left: 5px;
        }
        .hp{
            margin-left: 5px;
        }
    </style>
@endpush
@section('content')
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
                </div>
                <button type="submit" class="btn btn-outline-secondary float-right">
                    搜尋
                </button>
            </form>
        </div>
        <div class="col-md-9 col-12 mt-5">
            <div class="row">
                <h1>卡牌資料</h1>
            </div>
            <div class=" scrolling-pagination" >
                <div class="row m-1">
                    @foreach($TWCards as $TWCard)
                        <div class="col-md-2 col-6">
                            <span>{{$TWCard->name}}</span>
                            <span class="badge badge-warning CardCount" id="CardCount-{{$TWCard->id}}">{{ ($deck[$TWCard->id]['number'])??'' }}</span>
                            <img class="w-100 m-1" src="{{$TWCard->image}}" />
                            <a href="javascript:void(0)" class="info-modal float-right text-dark" data-id="{{$TWCard->id}}" data-toggle="modal"  data-target="#card_info_modal" data-focus="false">
                                <i class="fas fa-exclamation-circle"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div id="pagination">
                    {{ $TWCards->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="card_info_modal" tabindex="-1" role="dialog" aria-labelledby="CardInfoModal" >
        <div class="modal-dialog w-50" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h2 class="modal-title "></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body get_quote_view_modal_body" id="">
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


@endsection

@push('app-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
    <script type="text/javascript">

        $(".card-image").lazyload({
            effect : "fadeIn"
        });


        $('ul.pagination').hide();
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
                        $('#ModalCardInfoHtml').html(object.html);
                        $('#ModalCardImage').attr('src',object.image);
                    }else{
                        alert(object.message);
                    }
                }
            });
        });
    </script>
@endpush
