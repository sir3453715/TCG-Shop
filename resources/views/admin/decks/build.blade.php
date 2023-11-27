<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <title>生成構築表</title>
    <link href="" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'msyh';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/msyh.ttf') }}) format('truetype');
        }
        body {
            font-family: msyh, DejaVu Sans, sans-serif;
            line-height:1;
        }

        table {
            width: 97%;
            margin: auto;
            border: none;
            border-collapse: collapse;
            font-size: 22px;
            text-align: center;
        }
        td {
            border: none;
        }
        .main-sender {
            height: 100px;
        }
        .table-border td{
            border: 1px solid #000 !important;
        }
        .mb-50{
            margin-bottom: 30px;
        }
        .card-table{
            vertical-align: top
        }
        td.border-none{
            border: none !important;
        }
        td.text-left{
            text-align: left !important;
        }
        .notification{
            font-size: 15px;
        }
        .card-table td{
            height: 25px;
        }
        #pokemon-table td:nth-child(1){
            width: 40%;
        }
        #pokemon-table td:nth-child(4){
            width: 15%;
        }
        #energy-table td:nth-child(1){
            width: 50%;
        }
        #energy-table td:nth-child(4){
            width: 15%;
        }
        #item-table td:nth-child(1){
            width: 55%;
        }
        #support-table td:nth-child(1){
            width: 55%;
        }
        #area-table td:nth-child(1){
            width: 55%;
        }
        #total-table td:nth-child(1){
            width: 55%;
        }
        #content-table{
            width: 65% !important;
        }
        #content-table td:nth-child(1){
            width: 45%;
        }

        .header-bg{
            background-color: #bfbfbf !important;
        }
        .example-bg{
            background-color: #d9d9d9 !important;
        }

    </style>
</head>
<body>
    <table class="build-table">
        <tr class="border-none table-padding">
            <td colspan="2">
                <img src="{{url('/storage/image/ptcg/build.webp')}}" style="width: 350px;">
            </td>
            <td colspan="5">
                <div style="padding-bottom: 35px; margin-right: -90px;">
                    <table id="content-table" class="table-border header-table">
                        <tr>
                            <td colspan="2" style="padding: 15px;">套牌構築表</td>
                        </tr>
                        <tr>
                            <td>比賽名稱</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>舉辦地點</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>姓名</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>參賽編號</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>來自地區</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr class="card-table border-none">
            <td colspan="3">
                <table id="pokemon-table" class="table-border mb-50">
                    <tr class="header-bg">
                        <td>寶可夢</td>
                        <td>擴充包角標</td>
                        <td>集換NO.</td>
                        <td>張數</td>
                    </tr>
                    <tr class="example-bg">
                        <td>例: 噴火龍GX</td>
                        <td>AC1a</td>
                        <td>32</td>
                        <td>3</td>
                    </tr>
                    @for($i=1;$i<=15;$i++)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endfor
                    <tr>
                        <td class="border-none"></td>
                        <td class="border-none"></td>
                        <td class="border-none">小計:</td>
                        <td></td>
                    </tr>
                </table>

                <table id="energy-table" class="table-border">
                    <tr class="header-bg">
                        <td colspan="3">能量</td>
                        <td>張數</td>
                    </tr>
                    @for($i=1;$i<=4;$i++)
                    <tr>
                        <td colspan="3"></td>
                        <td></td>
                    </tr>
                    @endfor
                    <tr>
                        <td class="border-none"></td>
                        <td class="border-none"></td>
                        <td class="border-none">小計:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td colspan="2">
                <table id="item-table" class="table-border">
                    <tr class="header-bg">
                        <td>物品</td>
                        <td>張數</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    @for($i=1;$i<=22;$i++)
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                    <tr>
                        <td class="border-none">小計:</td>
                        <td></td>
                    </tr>
                </table>

            </td>
            <td colspan="2">
                <table id="support-table" class="table-border mb-50">
                    <tr class="header-bg">
                        <td>支援者</td>
                        <td>張數</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    @for($i=1;$i<=14;$i++)
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                    <tr>
                        <td class="border-none">小計:</td>
                        <td></td>
                    </tr>
                </table>
                <table  class="table-border mb-50">
                    <tr id="area-table" class="header-bg">
                        <td>競技場</td>
                        <td>張數</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    @for($i=1;$i<=4;$i++)
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                    <tr>
                        <td class="border-none">小計:</td>
                        <td></td>
                    </tr>
                </table>
                <table id="total-table" class="table-border mb-50">
                    <tr>
                        <td class="border-none">總計:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class=" border-none">
            <td class="text-left notification" colspan="7">
                <p style="padding-left: 50px;">注意事項:</p>
                <ul>
                    <li>[寶可夢]請一定要寫下系列及編號。</li>
                    <li>[寶可夢]如果有相同能力及敘述的卡牌，但是不同的編號，可以只寫其中的一張卡牌的系列及編號。</li>
                    <li>如果套牌及套牌構築表不符，或是張數及構築規則不符合大會規定，則將會有相應懲罰。</li>
                    <li>請用繁體中文填寫並確保字跡能讓裁判變事，否則將可能影響您比賽權益。</li>
                </ul>
            </td>
        </tr>
        <tr class=" border-none">
            <td class="notification" colspan="7">
                <span>©2020 Pokémon. ©1995 - 2023 Nintendo/Creatures Inc./GAME FREAK inc.<br/> TM and ® are trademarks of Nintendo.</span>
            </td>
        </tr>
    </table>
</body>
</html>

