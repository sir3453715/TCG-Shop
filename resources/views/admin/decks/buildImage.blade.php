<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <title>生成構築表</title>
    <link href="{{ url('css/admin/admin.css') }}" rel="stylesheet">
    <link href="{{ url('css/admin/custom-admin.css') }}" rel="stylesheet">
    <style>
        #deckImageWrapper{
            width: auto;
        }
        #deckImage{
            position: absolute;
            z-index: -1;
            height: auto;
        }
        body{
            font-size: 17px;
        }
        /** 參賽資訊*/
        #competition-info-wrapper{
            position: absolute;
            top: 142px;
            left: 525px;
            font-size: 14px;
            width: 300px;
            line-height: 1.1;
        }
        #competition-info{
            display: grid;
            grid-template-columns: 1fr ;
        }
        /** 寶可夢卡*/
        #pokemon{
            position: absolute;
            width: 310px;
            top: 285px;
            left: 80px;
            font-size: 12px;
            line-height: 1.3;
        }
        #pokemon .ptcgCard{
            display: grid;
            grid-template-columns: 125px 55px 75px auto;
        }
        #pokemon-subtotal{
            position: absolute;
            top: 235px;
            left: 252px;
        }

        /** 能量卡*/
        #energy{
            position: absolute;
            width: 305px;
            top: 570px;
            left: 80px;
            font-size: 12px;
            line-height: 1.3;
        }
        #energy .energyCard{
            display: grid;
            grid-template-columns: 255px auto;
        }
        #energy-subtotal{
            position: absolute;
            top: 75px;
            left: 255px;
        }

        /** 物品卡*/
        #items{
            position: absolute;
            width: 120px;
            top: 270px;
            left: 390px;
            font-size: 12px;
            line-height: 1.3;
        }
        #items .itemCard{
            display: grid;
            grid-template-columns: 2fr 1fr ;
        }
        #items .itemCard .title{
            align-self: center;
            font-size: 12px;
        }
        #item-subtotal{
            position: absolute;
            top: 360px;
            left: 80px;
        }

        /** 支援者卡*/
        #support{
            position: absolute;
            width: 130px;
            top: 270px;
            left: 525px;
            font-size: 12px;
            line-height: 1.3;
        }
        #support .supportCard{
            display: grid;
            grid-template-columns: 2fr 1fr ;
        }
        #support .supportCard .title{
            font-size: 12px;
        }
        #support-subtotal{
            position: absolute;
            top: 235px;
            left: 80px;
        }

        /** 競技場卡*/
        #area{
            position: absolute;
            width: 130px;
            top: 553px;
            left: 525px;
            font-size: 12px;
            line-height: 1.3;
        }
        #area .areaCard{
            display: grid;
            grid-template-columns: 2fr 1fr ;
        }
        #area .areaCard .title{
            font-size: 12px;
        }
        #area-subtotal{
            position: absolute;
            top: 77px;
            left: 85px;
        }
        #deckTotal{
            position: absolute;
            top: 660px;
            left: 603px;
            font-size: 14px;
        }
        #deckbuild-btn{
            position: absolute;
        }
        .fn-9{
            font-size: 9px !important;
        }
    </style>
</head>
<body>
    <div id="deckbuild-btn">
        <a id="download-deckbuild" href="#" class="btn btn-outline-primary">下載圖檔</a>
        <a id="parent-consent-link" href="#" class="btn btn-outline-success">家長同意書</a>
{{--        <a id="print-deckbuild" href="#" class="btn btn-outline-success">列印</a>--}}
    </div>
    <section id="deckBuildSection" class="content">
        <div class="container-fluid">
            <div id="deckImageWrapper">
                <img id="deckImage" src="{{ url('/storage/image/ptcg/deckBuildEmpty.webp')}}">
                <div>
                    <div id="competition-info-wrapper">
                        <div id="competition-info">
                            <div>地區聯盟賽-台北站</div>
                            <div>世貿中心一館</div>
                            <div>油膩boy</div>
                        </div>
                    </div>
                    <div id="deck-info">
                        <div>
                            <div id="pokemon" >
                                @foreach($deckCards['寶可夢卡'] as $pokemonCard)
                                    <div class="ptcgCard">
                                        <div>{{$pokemonCard['name']}}</div>
                                        <div>{{$pokemonCard['serial_code']}}</div>
                                        <div>{{$pokemonCard['serial_number']}}</div>
                                        <div>{{$pokemonCard['num']}}</div>
                                    </div>
                                @endforeach
                                <div id="pokemon-subtotal">{{$deckCategoryTotal['寶可夢卡']}}</div>
                            </div>
                            <div id="energy" >
                                @foreach($deckCards['基本能量卡'] as $pokemonCard)
                                    <div class="energyCard">
                                        <div>{{$pokemonCard['name']}}</div>
                                        <div>{{$pokemonCard['num']}}</div>
                                    </div>
                                @endforeach
                                @foreach($deckCards['特殊能量卡'] as $pokemonCard)
                                    <div class="energyCard">
                                        <div>{{$pokemonCard['name']}}</div>
                                        <div>{{$pokemonCard['num']}}</div>
                                    </div>
                                @endforeach
                                <div id="energy-subtotal">{{($deckCategoryTotal['特殊能量卡']+$deckCategoryTotal['基本能量卡'])}}</div>
                            </div>
                        </div>
                        <div id="items" >
                            @foreach($deckCards['物品卡'] as $pokemonCard)
                                <div class="itemCard">
                                    <div class="title {{(mb_strlen($pokemonCard['name'])>=7)?'fn-9':'' }}">{{$pokemonCard['name']}}</div>
                                    <div class="title">{{$pokemonCard['num']}}</div>
                                </div>
                            @endforeach
                            @foreach($deckCards['寶可夢道具'] as $pokemonCard)
                                <div class="itemCard">
                                    <div class="title {{(mb_strlen($pokemonCard['name'])>=7)?'fn-9':'' }}">{{$pokemonCard['name']}}</div>
                                    <div class="title">{{$pokemonCard['num']}}</div>
                                </div>
                            @endforeach
                            <div id="item-subtotal">{{($deckCategoryTotal['物品卡']+$deckCategoryTotal['寶可夢道具'])}}</div>
                        </div>
                        <div>
                            <div id="support" >
                                @foreach($deckCards['支援者卡'] as $pokemonCard)
                                    <div class="supportCard">
                                        <div class="title {{(mb_strlen($pokemonCard['name'])>=7)?'fn-9':'' }}">{{$pokemonCard['name']}}</div>
                                        <div class="title">{{$pokemonCard['num']}}</div>
                                    </div>
                                @endforeach
                                <div id="support-subtotal">{{$deckCategoryTotal['支援者卡']}}</div>
                            </div>
                            <div id="area" >
                                @foreach($deckCards['競技場卡'] as $pokemonCard)
                                    <div class="areaCard">
                                        <div class="title {{(mb_strlen($pokemonCard['name'])>=7)?'fn-9':'' }}">{{$pokemonCard['name']}}</div>
                                        <div class="title">{{$pokemonCard['num']}}</div>
                                    </div>
                                @endforeach
                                <div id="area-subtotal">{{$deckCategoryTotal['競技場卡']}}</div>
                            </div>
                            <div id="deckTotal">
                                <div>{{$deckCategoryTotal['total']}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>



<script src="{{ asset('js/admin/admin.js') }}"></script>
<script src="{{ asset('js/admin/app.js') }}"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/printthis@0.1.5/printThis.min.js"></script>--}}

<script type="text/javascript">
    $(window).on('load', function() {
        html2canvas(document.getElementById('deckBuildSection'),{
            windowWidth:700,width:700,height:1000,
        }).then(function(canvas) {
            canvas.id = "h2canvas";
            canvas.style='display:none';
            document.body.appendChild(canvas);
            var a = $('#download-deckbuild');
            a.attr('href' , canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream"));
            a.attr('download', 'deckBuild.jpg');
        });
        // $('#print-deckbuild').on('click',function (e){
        //     $('#deckBuildSection').printThis();
        // });

    });
</script>
