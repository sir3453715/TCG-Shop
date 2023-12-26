<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DecksController extends Controller
{
    /**
     * index
     */
    function index(Request $request){

        $queried = ['keyword'=>'','is_recommend'=>'',];
        $decks = Deck::whereNotNull('id');
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $decks = $decks->where('title','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('is_recommend')) {
            $is_recommend = $request->get('is_recommend');
            if($is_recommend == 'Y'){
                $decks = $decks->where('is_recommend',true);
            }else{
                $decks = $decks->where('is_recommend',false);
            }
            $queried['is_recommend'] = $is_recommend;
        }

        $decks = $decks->orderBy('created_at','ASC')->paginate(25);

        return view('admin.decks.decks',[
            'queried'=>$queried,
            'decks'=>$decks,
        ]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cards = Card::whereNotNull('id');
        $cards = $cards->orderBy('created_at','ASC')->paginate(20);
        $decks = [];

        return view('admin.decks.createDeck',[
            'decks'=>$decks,
            'cards'=>$cards,
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
        $card_id = $request->get('card_id'); $card_num = $request->get('card_num');

        $cardSize = sizeof($request->get('card_id'));
        $deckCount = 0;

        $deckInfo = [];
        for ($i=0;$i< $cardSize;$i++){
            $deckInfo['card'][]=[
                'card_id' => $card_id[$i],
                'card_num' => $card_num[$i],
            ];
            $deckCount +=  $card_num[$i];
            $deckInfo['count']=$deckCount;
        }

        $string = "abcdefghijklmnopqrstuvwxyz@$&*+-_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $code = substr(str_shuffle($string), rand(1,10), 7);

        $image = '';
        if($request->hasFile('image')) {
            $img = $request->file('image');
            $image_name = date('YmdHis').uniqid().'.'.$img->getClientOriginalExtension();
            Storage::disk('Decks')->putFileAs('/',$img,$image_name);
            $image = Storage::url('decks/').$image_name;
        }

        $data=[
            'user_id'=>'0',
            'title'=>$request->get('title'),
            'competition'=>$request->get('competition'),
            'is_recommend'=>$request->get('is_recommend'),
            'card_info'=>serialize($deckInfo),
            'code'=>$code,
            'image'=>$image,
        ];

        $deck = Deck::create($data);

        ActionLog::create_log($deck,'新增');

        return redirect(route('admin.deck.index'))->with('message', '牌組已新增!');


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

        $cards = Card::whereNotNull('id');
        $cards = $cards->orderBy('created_at','ASC')->paginate(20);
        $deck = Deck::find($id);

        return view('admin.decks.editDeck',[
            'deck'=>$deck,
            'cards'=>$cards,
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
        $deck = Deck::find($id);

        $card_id = $request->get('card_id'); $card_num = $request->get('card_num');

        $cardSize = sizeof($request->get('card_id'));
        $deckCount = 0;
        $deckInfo = [];
        for ($i=0;$i< $cardSize;$i++){
            $deckInfo['card'][]=[
                'card_id' => $card_id[$i],
                'card_num' => $card_num[$i],
            ];
            $deckCount +=  $card_num[$i];
            $deckInfo['count']=$deckCount;
        }

        $image = $deck->image;
        if($request->hasFile('image')) {
            if($image){
                $oldImageName = explode('/',$deck->image);
                if(Storage::disk('Decks')->exists(end( $oldImageName))){
                    Storage::disk('Decks')->delete(end( $oldImageName));
                }
            }
            $img = $request->file('image');
            $image_name = date('YmdHis').uniqid().'.'.$img->getClientOriginalExtension();
            Storage::disk('Decks')->putFileAs('/',$img,$image_name);
            $image = Storage::url('decks/').$image_name;
        }

        $data=[
            'user_id'=>$request->get('user_id'),
            'title'=>$request->get('title'),
            'competition'=>$request->get('competition'),
            'is_recommend'=>$request->get('is_recommend'),
            'card_info'=>serialize($deckInfo),
            'image'=>$image,
        ];

        $deck = $deck->fill($data);
        ActionLog::create_log($deck);
        $deck = $deck->save();


        return redirect(route('admin.deck.index'))->with('message', '牌組已修改!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }


    public function GetCardData(Request $request){
        if($request->get('id')) {
            $card = Card::find($request->get('id'));
            $infoHTML = "<div class='col-md-3 col-6 border p-1 DeckCardInfo competition-$card->competition_number' id='DeckCardInfo-$card->id' data-id='$card->id' >
                            <small>$card->name</small>
                            <img class='w-100 p-1' src='$card->image' />
                            <div class='d-flex justify-content-between'>
                                <a class='changeCardNumber' href='javascript:void(0)' data-id='$card->id' data-model='plus'>                                                                            <span class='badge badge-warning '>
                                        <i class='fa fa-plus'></i>
                                    </span>
                                </a>
                                    <span class='badge badge-secondary fa-1x' id='CardNum-$card->id'>1</span>
                                <a class='changeCardNumber' href='javascript:void(0)' data-id='$card->id' data-model='minus'>                                                                            <span class='badge badge-warning '>
                                        <i class='fa fa-minus'></i>
                                    </span>
                                </a>
                            </div>
                            <input type='hidden' name='card_id[]' value='$card->id'>
                            <input type='hidden' name='card_num[]' value='1' id='cardNumInput-$card->id'>
                        </div>";

            $result = array_merge(['result'=>'1','html'=>$infoHTML]);
            return json_encode($result);

        }else{
            if($request->get('keyword')) {
                $keyword = $request->get('keyword');
                $competition = 'ptcg_'.$request->get('competition');
                $competition_number = app('Option')->$competition;
                $cards = Card::whereNotNull('id');
                $cards = $cards->whereIn('competition_number',explode(',',$competition_number));
                $cards = $cards->where(function ($query) use ($keyword){
                    $query->orwhere('name','LIKE','%'.$keyword.'%');//產品編號
                    $query->orwhere('series','LIKE','%'.$keyword.'%');//產品標題
    //                $query->orwhere('skill','LIKE','%'.json_encode($keyword).'%');//技能
                });
                $cards = $cards->orderBy('created_at','ASC')->get();
            }else{
                return json_encode(['result'=>'0']);
            }

            $infoHTML = '';
            foreach($cards as $card){
                $infoHTML .= "<div class='col-md-3 col-6 p-1 CardInfo'>
                                <img class='w-100 p-1' src='$card->image' />
                            <div class='d-flex justify-content-between'>
                                <small>$card->name</small>
                                <a class='addToDeck' href='javascript:void(0)' data-id='$card->id'>
                                    <span class='badge badge-warning fa-1x' >
                                        <i class='fa fa-plus'></i>
                                    </span>
                                </a>
                            </div>
                        </div>";
            }

            $result = array_merge(['result'=>'1','html'=>$infoHTML]);
            return json_encode($result);
        }
    }

    public function ChangeDeckCard(Request $request){
        $CID = $request->get('id');
        $type = $request->get('type');
        $deck = session()->get('deck');
        $card = PtcgTwCard::find($CID);
        $delete = false;
        if($type == 'add'){
            if($deck['count']<60 ){
                if($card->supertypes != '基本能量卡'){
                    if($deck[$CID]['number'] <4){
                        $deck[$CID]=[
                            'name'=>$card->name,
                            'image'=>$card->image,
                            'number'=>($deck[$CID]['number']+1)
                        ];
                    }else{
                        $result = ['result'=>'2','message'=>'每張卡牌最多只能加4張!'];
                        return json_encode($result);
                    }
                }else{
                    $deck[$CID]=[
                        'name'=>$card->name,
                        'image'=>$card->image,
                        'number'=>($deck[$CID]['number']+1)
                    ];
                }
                $deck['count']++;
            }else{
                $result = ['result'=>'2','message'=>'每份牌組最多只能有60張!'];
                return json_encode($result);
            }
        }elseif($type == 'minus'){
            if($deck[$CID]['number'] == 1){
                unset($deck[$CID]);
                $delete = true;
            }else{
                $deck[$CID]=[
                    'name'=>$card->name,
                    'image'=>$card->image,
                    'number'=>($deck[$CID]['number']-1)
                ];
            }
            $deck['count']--;
        }
        if($delete){
            $result = ['result'=>'1','CID'=>$CID,'number'=>0,'count'=>$deck['count'],'delete'=>$delete];
        }else{
            $result = ['result'=>'1','CID'=>$CID,'number'=>$deck[$CID]['number'],'count'=>$deck['count'],'delete'=>$delete];
        }
        session()->put('deck', $deck);
        return json_encode($result);

    }
    public function CleanDeck(Request $request){
        session()->forget('deck');
        return 1;
    }

    public function checkCardLimit(Request $request){
        $CardNum = $request->get('CardNum');
        $card = Card::find($request->get('id'));
        if($card->type != '基本能量卡'){
            if($CardNum < 4)
                $result = ['result'=>true];
            else
                $result = ['result'=>false];
        }else{
            $result = ['result'=>true];
        }

        return json_encode($result);
    }


    public function build($id,Request $request){

        $deckCards = [];
        $deck = Deck::find($id);
        $deckCards = $deck->deckBuildCategoryInfo();
        $deckCategoryTotal = $deck->deckBuildCategoryTotal();

        return view('admin.decks.buildImage',[
            'deckCards'=>$deckCards,
            'deckCategoryTotal'=>$deckCategoryTotal
        ]);

    }
}
