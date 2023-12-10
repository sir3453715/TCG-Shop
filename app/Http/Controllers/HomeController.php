<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PtcgTwCard;
use App\Models\PunchCard;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $TWCards = Card::inRandomOrder()->limit(12)->get();
        return view('home',[
            'TWCards'=>$TWCards,
        ]);
    }
    public function card(Request $request)
    {

        $supertypes = ['基本能量卡','寶可夢卡','寶可夢道具','支援者卡','物品卡','特殊能量卡','競技場卡','能量卡'];
        $types = ['Grass'=>'草', 'Fire'=>'火', 'Water'=>'水', 'Lightning'=>'雷', 'Psychic'=>'超', 'Fighting'=>'鬥','Darkness'=>'惡', 'Metal'=>'鋼', 'Fairy'=>'妖', 'Dragon'=>'龍', 'Colorless'=>'無'];
        $rarities =['C','U','R','RR','RRR','PR','TR','SR','K','AR','SAR','無標記'];

        $queried = ['keyword'=>'','supertypes'=>[''],'types'=>[''],'rarity'=>['']];
        $TWCards = Card::whereNotNull('id');

        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $TWCards = $TWCards->where('name','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('supertypes')) {
            $supertypesSelected = $request->get('supertypes');
            $TWCards = $TWCards->whereIn('supertypes',$supertypesSelected);
            $queried['supertypes'] = $supertypesSelected;
        }
        if($request->get('types')) {
            $typesSelected = $request->get('types');
            $TWCards = $TWCards->whereIn('type',$typesSelected);
            $queried['types'] = $typesSelected;
        }
        if($request->get('rarity')) {
            $raritiesSelected = $request->get('rarity');
            $TWCards = $TWCards->whereIn('rarity',$raritiesSelected);
            $queried['rarity'] = $raritiesSelected;
        }

        $TWCards = $TWCards->orderBy('created_at','DESC')->paginate(24);

        return view('card',[
            'queried'=>$queried,
            'TWCards'=>$TWCards,
            'supertypes'=>$supertypes,
            'types'=>$types,
            'rarities'=>$rarities,
        ]);
    }
    public function deck(Request $request){

        $supertypes = ['寶可夢卡','寶可夢道具','支援者卡','物品卡','競技場卡','能量卡'];
        $types = ['Grass'=>'草', 'Fire'=>'火', 'Water'=>'水', 'Lightning'=>'雷', 'Psychic'=>'超', 'Fighting'=>'鬥','Darkness'=>'惡', 'Metal'=>'鋼', 'Fairy'=>'妖', 'Dragon'=>'龍', 'Colorless'=>'無'];
        $rarities =['C','U','R','RR','RRR','PR','TR','SR','K','AR','SAR','無標記'];
        $competitions = ['E,F,G'=>'標準','A,B,C,D'=>'開放'];

        $queried = ['keyword'=>'','supertypes'=>[''],'types'=>[''],'rarity'=>[''],'competition'=>''];
        $TWCards = Card::whereNotNull('id');

        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $TWCards = $TWCards->where('name','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('supertypes')) {
            $supertypesSelected = $request->get('supertypes');
            if(in_array('能量卡',$supertypesSelected)){
                $supertypesSelected = array_merge($supertypesSelected,['基本能量卡','特殊能量卡']);
            }
            $TWCards = $TWCards->whereIn('supertypes',$supertypesSelected);
            $queried['supertypes'] = $supertypesSelected;
        }
        if($request->get('types')) {
            $typesSelected = $request->get('types');
            $TWCards = $TWCards->whereIn('type',$typesSelected);
            $queried['types'] = $typesSelected;
        }
        if($request->get('rarity')) {
            $raritiesSelected = $request->get('rarity');
            $TWCards = $TWCards->whereIn('rarity',$raritiesSelected);
            $queried['rarity'] = $raritiesSelected;
        }
        if($request->get('competition')) {
            $competitionSelected = $request->get('competition');
            $competitionSelectedArray = explode(',',$competitionSelected);
            $TWCards = $TWCards->whereIn('Competition_number',$competitionSelectedArray);
            $queried['competition'] = $competitionSelected;
        }

        $TWCards = $TWCards->orderBy('created_at','DESC')->paginate(24);

        $deck = session()->get('deck');

        if(!$deck){
            $deck=[];        $count = 0;
        }else{
            $count = $deck['count'];
            unset($deck['count']);
        }

        return view('deck',[
            'queried'=>$queried,
            'TWCards'=>$TWCards,
            'deck'=>$deck,
            'count'=>$count,
            'supertypes'=>$supertypes,
            'types'=>$types,
            'rarities'=>$rarities,
            'competitions'=>$competitions,
        ]);
    }
    public function home()
    {

        return view('welcome');

    }

    public function news()
    {

        return view('news');

    }

    public function newsPost()
    {

        return view('newsPost');

    }

    public function dashboard()
    {

        return view('dashboard');

    }

    public function myDeck()
    {

        return view('myDeck');

    }

    public function myDeckDetail()
    {

        return view('myDeckDetail');

    }

    public function order()
    {

        return view('order');

    }


    public function addToDeck(Request $request){
        $CID = $request->get('id');
        $number = $request->get('number');
        $card = PtcgTwCard::find($CID);
        $deck = session()->get('deck');
        if(!$deck){
            $deck[$CID]=[
                'name'=>$card->name,
                'image'=>$card->image,
                'number'=>$number
            ];
            $deck['count']=1;
            session()->put('deck', $deck);
            $html=view('component.deck-cards')->with('deck', $deck)->render();
            $result = ['result'=>'1','html'=>$html,'count'=>$deck['count']];
            return json_encode($result);
        }else{
            if($deck['count']<60 ){
                if(!isset($deck[$CID])){
                    $deck[$CID]=[
                        'name'=>$card->name,
                        'image'=>$card->image,
                        'number'=>$number
                    ];
                }else{
                    if($card->supertypes != '基本能量卡'){
                        if($deck[$CID]['number'] <4){
                            $deck[$CID]=[
                                'name'=>$card->name,
                                'image'=>$card->image,
                                'number'=>($deck[$CID]['number']+$number)
                            ];
                        }else{
                            $result = ['result'=>'2','message'=>'每張卡牌最多只能加4張!'];
                            return json_encode($result);
                        }
                    }else{
                        $deck[$CID]=[
                            'name'=>$card->name,
                            'image'=>$card->image,
                            'number'=>($deck[$CID]['number']+$number)
                        ];
                    }
                }

                $html=view('component.deck-cards')->with('deck', $deck)->render();
                $deck['count']++;
                session()->put('deck', $deck);
                $result = ['result'=>'1','html'=>$html,'count'=>$deck['count'],'CardCount'=>$deck[$CID]['number']];
                return json_encode($result);
            }else{
                $result = ['result'=>'2','message'=>'每份牌組最多只能有60張!'];
                return json_encode($result);
            }
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

    public function GetCardData(Request $request){
        $CID = $request->get('id');
        $card = PtcgTwCard::find($CID)->toArray();
        $skills = json_decode($card['skill'], true);
        $infoHTML = '<div><div><h4>系列： '.$card['set'].'</h4></div>';
        if($card['type']){
            $infoHTML .= '<div class="d-flex"><h4>屬性</h4><img class="energy-image" src="/storage/image/ptcg/energy/'.$card['type'].'.jpg"></div>';
        }
        if($card['hp']){
            $infoHTML .= '<div class="d-flex"><h4>HP</h4><span class="hp">'.$card['hp'].'</span></div>';
        }
        $infoHTML .= '<h4>技能</h4><div class="list-group">';


        foreach ($skills as $skill){
            Log::info($skill);
            if($skill['name']!=''){
                $infoHTML .= '<div class="list-group-item d-flex justify-content-between"><div class="d-flex h-100"><h4 class="list-group-item-heading">'.$skill['name'].'</h4>';
                if(!empty($skill['type'])){
                    foreach ($skill['type'] as $skillType){
                        $infoHTML .= '<img class="energy-image" src="/storage/image/ptcg/energy/'.$skillType.'.jpg">';
                    }
                }
                $infoHTML .='</div>';
                if($skill['damage']!=''){
                    $infoHTML .='<span>'.$skill['damage'].'</span>';
                }
                $infoHTML .= '</div> <div class="list-group-item"> 
                    <p class="list-group-item-text"> '.$skill['desc'].' </p>
                </div>';
            }
        }
        $infoHTML .= '</div>';

        if($card){
            $result = array_merge(['result'=>'1','html'=>$infoHTML],$card);
            return json_encode($result);
        }else{
            return json_encode(['result'=>'0','message'=>'找不到卡片資料!']);
        }
    }


    public function orderCreate(Request $request){
        $requestData = $request->toArray();
        $cardData = json_decode($requestData['cardData'],true);
        if(empty($cardData)){
            $cardData = session()->get('deck');
            unset($cardData['count']);
        }
        if(!empty($cardData)){
            $tempcode2 = 'TEST-'.date('ymd');
            $seccode_order = Order::where('seccode','LIKE','%'.$tempcode2.'%')->orderBy('created_at','DESC')->get();
            if($seccode_order){
                $num = count($seccode_order);
                do{
                    $num ++;
                    $tempseccode = $tempcode2.str_pad($num,3,0,STR_PAD_LEFT);
                    $chk_seccode = Order::where('seccode','=',$tempseccode)->first();//判斷已產生的訂單編號是否存在
                } while ($chk_seccode);
            }else{
                $tempseccode = $tempcode2.'001';
            }
            $data = [
                'seccode'=>$tempseccode,
                'sender'=>$requestData['sender'],
                's_phone'=>$requestData['s_phone'],
                's_email'=>$requestData['s_email'],
                'user_id'=>$requestData['user_id'],
                'note'=>$requestData['note'],
            ];
            $order = Order::create($data);
            foreach ($cardData as $card_id => $item){
                $itemData = [
                    'order_id'=>$order->id,
                    'product_id'=>$card_id,
                    'num'=>$item['number'],
                    'unit'=>'0',
                    'subtotal'=>'0',
                    'title'=>$item['name'],
                ];
                $orderItem = OrderItem::create($itemData);
            }
            return redirect(route('deck'))->with('message', '已發送訂單至貓腳印!');
        }else{
            return redirect(route('deck'))->with('error', '沒有卡牌資料!');
        }





    }

}
