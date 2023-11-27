<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CardsController extends Controller
{
    /**
     * index
     */
    function index(Request $request){

        $queried = ['keyword'=>'','attribute'=>'', 'rarity'=>'', 'type'=>'','competition'=>''];
        $cards = Card::whereNotNull('id');
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $cards = $cards->where('name','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('attribute')) {
            $attribute = $request->get('attribute');
            $cards = $cards->where('attribute',$attribute);
            $queried['attribute'] = $attribute;
        }
        if($request->get('rarity')) {
            $rarity = $request->get('rarity');
            $cards = $cards->where('rarity',$rarity);
            $queried['rarity'] = $rarity;
        }
        if($request->get('type')) {
            $type = $request->get('type');
            $cards = $cards->where('type',$type);
            $queried['type'] = $type;
        }
        if($request->get('seriess')) {
            $seriess = $request->get('seriess');
            $cards = $cards->whereIn('set_id', $seriess);
            $queried['seriess'] = $seriess;
        }
        if($request->get('competition')) {
            $competition = $request->get('competition');
            $competitionOption = 'ptcg_'.$competition;
            $cards = $cards->whereIn('competition_number',explode(',',app('Option')->$competitionOption));
            $queried['competition'] = $competition;
        }

        $cards = $cards->orderBy('created_at','ASC')->paginate(25);

        $types = config('cards.Pokemon.types');
        $attributes = config('cards.Pokemon.attributes');
        $rarities = config('cards.Pokemon.rarities');

        return view('admin.cards.cards',[
            'queried'=>$queried,
            'cards'=>$cards,
            'rarities'=>$rarities,
            'types'=>$types,
            'attributes'=>$attributes,
        ]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = config('cards.Pokemon.types');
        $attributes = config('cards.Pokemon.attributes');
        $rarities = config('cards.Pokemon.rarities');
        $competitions = config('cards.Pokemon.competitions');
        $kingdoms = config('cards.kingdoms');

        return view('admin.cards.createCard',[
            'rarities'=>$rarities,
            'types'=>$types,
            'attributes'=>$attributes,
            'competitions'=>$competitions,
            'kingdoms'=>$kingdoms,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = '';
        if($request->hasFile('image')) {
            $img = $request->file('image');
            $image_name = date('YmdHis').uniqid().'.'.$img->getClientOriginalExtension();
            Storage::disk('Cards')->putFileAs('/image/',$img,$image_name);
            $image = Storage::url('cards/image/').$image_name;
        }

        $skill = [];
        if($request->get('skill_name')){
            $skillSize = sizeof($request->get('skill_name'));
            for($i=0;$i<$skillSize;$i++){
                $skill[$i]=[
                    'name'=>$request->get('skill_name')[$i],
                    'attribute'=>$request->get('skill_attribute')[$i],
                    'damage'=>$request->get('skill_damage')[$i],
                    'desc'=>$request->get('skill_desc')[$i],
                ];
            }
        }

        $data = [
            'lang'=>$request->get('lang'),
            'tw_id'=>($request->get('tw_id'))??0,
            'name'=>$request->get('name'),
            'hp'=>$request->get('hp'),
            'image'=>$image,
            'series'=>$request->get('series'),
            'serial_code'=>$request->get('serial_code'),
            'serial_number'=>$request->get('serial_number'),
            'attribute'=>$request->get('attribute'),
            'type'=>$request->get('type'),
            'skill'=>json_encode($skill),
            'weakpoint'=>$request->get('weakpoint'),
            'weakpoint_value'=>$request->get('weakpoint_value'),
            'resist'=>$request->get('resist'),
            'resist_value'=>$request->get('resist_value'),
            'escape'=>$request->get('escape'),
            'rarity'=>$request->get('rarity'),
            'competition_number'=>$request->get('competition_number'),
            'default_price'=>$request->get('default_price'),
            'kingdom'=>$request->get('kingdom'),
        ];

        $card = Card::create($data);

        ActionLog::create_log($card,'新增');

        return redirect(route('admin.card.index'))->with('message', '卡牌已新增!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $card = Card::find($id);
        $types = config('cards.Pokemon.types');
        $attributes = config('cards.Pokemon.attributes');
        $rarities = config('cards.Pokemon.rarities');
        $competitions = config('cards.Pokemon.competitions');
        $kingdoms = config('cards.kingdoms');

        $day7 = json_encode($card->historyPrices()->orderBy('dateTime','DESC')->limit(7)->get()->toArray());
        $day30 = json_encode($card->historyPrices()->orderBy('dateTime','DESC')->limit(30)->get()->toArray());

        return view('admin.cards.editCard',[
            'card'=>$card,
            'rarities'=>$rarities,
            'types'=>$types,
            'attributes'=>$attributes,
            'competitions'=>$competitions,
            'kingdoms'=>$kingdoms,
            'day7'=>$day7,
            'day30'=>$day30,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $card = Card::find($id);

        $image = $card->image;
        if($request->hasFile('image')) {
            if($image){
                $oldImageName = explode('/',$card->image);
                if(Storage::disk('Cards')->exists('image/'.end( $oldImageName))){
                    Storage::disk('Cards')->delete('image/'.end( $oldImageName));
                }
            }
            $img = $request->file('image');
            $image_name = date('YmdHis').uniqid().'.'.$img->getClientOriginalExtension();
            Storage::disk('Cards')->putFileAs('/image/',$img,$image_name);
            $image = Storage::url('cards/image/').$image_name;
        }

        $skill = [];
        if($request->get('skill_name')){
            $skillSize = sizeof($request->get('skill_name'));
            for($i=0;$i<$skillSize;$i++){
                $skill[$i]=[
                    'name'=>$request->get('skill_name')[$i],
                    'attribute'=>$request->get('skill_attribute')[$i],
                    'damage'=>$request->get('skill_damage')[$i],
                    'desc'=>$request->get('skill_desc')[$i],
                ];
            }
        }
        $data = [
            'lang'=>$request->get('lang'),
            'tw_id'=>($request->get('tw_id'))??0,
            'name'=>$request->get('name'),
            'hp'=>$request->get('hp'),
            'image'=>$image,
            'series'=>$request->get('series'),
            'serial_code'=>$request->get('serial_code'),
            'serial_number'=>$request->get('serial_number'),
            'attribute'=>$request->get('attribute'),
            'type'=>$request->get('type'),
            'skill'=>json_encode($skill),
            'weakpoint'=>$request->get('weakpoint'),
            'weakpoint_value'=>$request->get('weakpoint_value'),
            'resist'=>$request->get('resist'),
            'resist_value'=>$request->get('resist_value'),
            'escape'=>$request->get('escape'),
            'rarity'=>$request->get('rarity'),
            'competition_number'=>$request->get('competition_number'),
            'default_price'=>$request->get('default_price'),
            'kingdom'=>$request->get('kingdom'),
        ];

        $card->fill($data);
        ActionLog::create_log($card,'修改');
        $card->save();

        return redirect(route('admin.card.index'))->with('message', '卡牌已修改!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Card::find($id);
        if($card){
            $image = $card->image;
            if($image){
                $oldImageName = explode('/',$card->image);
                if(Storage::disk('Cards')->exists('image/'.end( $oldImageName))){
                    Storage::disk('Cards')->delete('image/'.end( $oldImageName));
                }
            }

            $card->delete();
            ActionLog::create_log($card,'刪除');
        }

        return redirect(route('admin.card.index'))->with('message', '卡牌已刪除!');


    }

    public function reinstall()
    {
        $files = Storage::disk('ptcgCardDataSet_TW')->allFiles();
        foreach ($files as $file){
            $data = Excel::toArray('',Storage::disk('ptcgCardDataSet_TW')->path($file))[0];

            unset($data[0]);
            foreach ($data as $card){
                $nameClean = str_replace(' ','',$card[0]);
                $nameArray = explode(PHP_EOL,$nameClean);
                $name = end($nameArray);
                $type= ($card[2])?str_replace(['https://asia.pokemon-card.com/various_images/energy/','.png'],'',$card[2]):'';
                if($card[4]){
                    $supertypes = ($card[4]=='招式')?'寶可夢卡':$card[4];
                }else{
                    $supertypes = ($name == '雙重渦輪能量')?'特殊能量卡':'';
                }
                $skill = [];

                $skill[0]=[
                    'name'=>($card[5])??'',
                    'attribute'=>($card[6])?$this->cleanImportUselessImageHTML($card[6],'string'):'',
                    'damage'=>($card[7])??'',
                    'desc'=>($card[8])??'',
                ];
                $skill[1]=[
                    'name'=>($card[9])??'',
                    'attribute'=>($card[10])?$this->cleanImportUselessImageHTML($card[10],'string'):'',
                    'damage'=>($card[11])??'',
                    'desc'=>($card[12])??'',
                ];
                $skill[2]=[
                    'name'=>($card[13])??'',
                    'attribute'=>($card[14])?$this->cleanImportUselessImageHTML($card[14],'string'):'',
                    'damage'=>($card[15])??'',
                    'desc'=>($card[16])??'',
                ];
                $skill[3]=[
                    'name'=>($card[17])??'',
                    'attribute'=>($card[18])?$this->cleanImportUselessImageHTML($card[18],'string'):'',
                    'damage'=>($card[19])??'',
                    'desc'=>($card[20])??'',
                ];
                $cardData = [
                    'lang' => 'tw',
                    'tw_id' => '0',
                    'name' => $name,
                    'image'=>$card[1],
                    'series'=>$card[25],
                    'serial_number'=>($card[27])??null,
                    'attribute'=>$type,
                    'type'=>$supertypes,
                    'hp'=>(is_numeric($card[3]))?$card[3]:null,
                    'skill'=>json_encode($skill),
                    'weakpoint'=>($card[21])?$this->cleanImportUselessImageHTML($card[21],'string'):'',
                    'weakpoint_value'=>($card[21])?$this->cleanImportUselessImageHTML($card[21],'string'):'',
                    'resist'=>($card[22])?$this->cleanImportUselessImageHTML($card[22],'string'):'',
                    'resist_value'=>($card[22])?$this->cleanImportUselessImageHTML($card[22],'string'):'',
                    'escape'=>($card[23])?$this->cleanImportUselessImageHTML($card[23],'string'):'',
                    'rarity'=>'',
                    'competition_number'=>($card[26])??null,
                    'default_price'=>'',
                    'kingdom'=>'PTCG',
                ];
                $ptcgTWCard = Card::create($cardData);
            }
        }

        return redirect(route('admin.ptcg-card-tw.index'))->with('message', '卡牌已全部重置匯入!');
    }


    public function cleanImportUselessImageHTML($resource,$type = 'array'){
        $stringClean = $resource;
        if($resource != ''){
            $stringClean = str_replace(['<img src="https://asia.pokemon-card.com/various_images/energy/','.png">'],'',$resource);
            $stringClean = str_replace(' ','',$stringClean);
            $stringCleanArray = explode(PHP_EOL,$stringClean);
            $stringCleanArray = array_filter($stringCleanArray);
            $output = $stringCleanArray;
            if($type == 'string'){
                $output = implode(',',$stringCleanArray);
            }
        }
        return $output;
    }
    public function rarity(Request $request)
    {
        if($request->hasFile('import')) {
            $extension = $request->file('import')->getClientOriginalExtension(); //副檔名
            $path1 = time() . "." . $extension;    //重新命名
            $request->file('import')->move(storage_path('app') . '/temp', $path1); //移動至指定目錄
            $path = storage_path('app') . '/temp/' . $path1;
            $excel = Excel::toCollection('', $path);
            $data = array();
            foreach ($excel as $key => $sheets) { // 各個表分別撈出來

                foreach ($sheets as $rows => $column) {
                    if ($rows > 0) { //排除檔案標題欄位
                        $rarity = $column[0];
                        $image = $column[1];
                        $card = Card::where('image',$image)->first();
                        $card->fill(['rarity'=>$rarity]);
                        $card->save();
                    }
                }
            }
            unlink(storage_path('app/temp/' . $path1));
            return redirect(route('admin.import-export.index'))->with('message', '檔案成功匯入!')->with('data', $data);
        }
    }

    public function searchCard(Request $request){

        $cardsQuery = Card::whereNotNull('id');
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $cardsQuery = $cardsQuery->where(function ($query) use ($keyword){
                $query->orwhere('name','LIKE','%'.$keyword.'%');//產品編號
                $query->orwhere('series','LIKE','%'.$keyword.'%');//產品標題
            });
        }else{
            $cardsQuery->orderBy('created_at','Desc')->limit(30);
        }

        $cards = $cardsQuery->get();

        return response()->json([
            'cards' => $cards
        ]);
    }

}
