<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Card;
use App\Models\CardSeries;
use App\Models\Deck;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PtcgTwCard;
use App\Models\PunchCard;
use App\Models\Wishlist;
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
    public function home()
    {

        return view('welcome');
    }
    public function terms()
    {
        return view('terms');
    }
    public function privacy()
    {
        return view('privacy');
    }
    public function index()
    {


        $banners = Banner::where('status','1')->orderBy('sort','DESC')->get();
        $events = Event::where('status','1')->orderBy('top','DESC')->orderBy('dateTime','DESC')->limit(5)->get();
        if(sizeof($events)>1){
            $biggestEvent = $events[0];
            unset($events[0]);
        }else{
            $biggestEvent = [];
        }
        $eventsList = $events;

        $cards = Card::inRandomOrder()->limit(5)->get();


        return view('home',[
            'banners'=>$banners,
            'biggestEvent'=>$biggestEvent,
            'eventsList'=>$eventsList,
            'cards'=>$cards,
        ]);
    }
    public function card(Request $request)
    {

        $queried = ['keyword'=>'','attribute'=>[], 'rarity'=>[], 'type'=>[],'series'=>[],'competition'=>''];

        $types = config('cards.Pokemon.types');
        $attributes = config('cards.Pokemon.attributes');
        $rarities = config('cards.Pokemon.rarities');
        $competitions = [
            'standard'=>app('Option')->ptcg_standard,
            'expanded'=>app('Option')->ptcg_expanded,
        ];

        $Cards = Card::whereNotNull('id');

        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $Cards = $Cards->where('name','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('attribute') && !empty($request->get('attribute'))) {
            $attributeSelected = $request->get('attribute');
            $Cards = $Cards->whereIn('attribute',$attributeSelected);
            $queried['attribute'] = $attributeSelected;
        }
        if($request->get('series') && !empty($request->get('series'))) {
            $seriesSelected = $request->get('series');
            $Cards = $Cards->whereIn('series_id',$seriesSelected);
            $queried['series'] = $seriesSelected;
        }
        if($request->get('type') && !empty($request->get('type'))) {
            $typeSelected = $request->get('type');
            $Cards = $Cards->whereIn('type',$typeSelected);
            $queried['type'] = $typeSelected;
        }
        if($request->get('rarity') && !empty($request->get('rarity'))) {
            $raritiesSelected = $request->get('rarity');
            $Cards = $Cards->whereIn('rarity',$raritiesSelected);
            $queried['rarity'] = $raritiesSelected;
        }
        if($request->get('competition')) {
            $competition = 'ptcg_'.$request->get('competition');
            $competition_number = app('Option')->$competition;
            $Cards = $Cards->whereIn('competition_number',explode(',',$competition_number));
            $queried['competition'] = $request->get('competition');
        }

        $Cards = $Cards->orderBy('created_at','ASC')->paginate(24);

        $CardSeries = CardSeries::all();

        return view('card',[
            'queried'=>$queried,
            'Cards'=>$Cards,
            'types'=>$types,
            'rarities'=>$rarities,
            'attributes'=>$attributes,
            'competitions'=>$competitions,
            'CardSeries'=>$CardSeries,
        ]);
    }
    public function deck(Request $request){
        $decks = Deck::where('is_recommend',1)->paginate(16);
        return view('deck',[
            'decks'=>$decks,
        ]);
    }

    public function deckDetail($id){
        $deck = Deck::find($id);
        if($deck->user_id){
            return redirect(route('deck'))->with(['Errormessage'=>'無法查看其他人的牌組!']);
        }

        return view('deckDetail',[
            'deck'=>$deck
        ]);
    }

    public function news()
    {
        $news = Event::where('class_id',1)->paginate(12);
        return view('news',[
            'news'=>$news,
        ]);

    }

    public function newsPost($id)
    {
        $new = Event::find($id);
        return view('newsPost',[
            'new'=>$new
        ]);

    }

    public function competitions()
    {
        $competitions = Event::where('class_id',2)->paginate(12);
        return view('competitions',[
            'competitions'=>$competitions,
        ]);

    }
    public function competitionsPost($id)
    {

        $competition = Event::find($id);
        return view('competitionsPost',[
            'competition'=>$competition,
        ]);

    }

    public function search(Request $request){

        $s = $request->get('s');

        $decks = Deck::where('is_recommend',1)->where("title","LIKE","%$s%")->get();
        $news = Event::where('class_id',1)
            ->where(function ($query) use ($s){
                $query->orwhere("title","LIKE","%$s%");
                $query->orwhere("content","LIKE","%$s%");
            })->get();
        $competitions = Event::where('class_id',2)
            ->where(function ($query) use ($s){
                $query->orwhere("title","LIKE","%$s%");
                $query->orwhere("content","LIKE","%$s%");
            })->get();

        return view('search',[
            'decks'=>$decks,
            'news'=>$news,
            'competitions'=>$competitions,
        ]);

    }

    public function deckAddToCart(Request $request,$id){
        session()->forget('cart');
        $cart=[]; $cart['total']=0; $cart['count']=0;
        $deck = Deck::find($id);
        $deckCards = $deck->deckCardInfo();
        foreach ($deckCards as $card_id => $deckCard){
            $card = Card::find($card_id);
            $cart['items'][$card_id]=[
                'name'=>$deckCard['name'],
                'image'=>$deckCard['image'],
                'number'=>$deckCard['num'],
                'unit'=>$card->nowPrice(),
                'price'=>$card->nowPrice()*$deckCard['num'],
            ];
            $cart['total'] += ($card->nowPrice()*$deckCard['num']);
            $cart['count'] += $deckCard['num'];
        }
        $cart['shipping']=0;

        session()->put('cart', $cart);;
        return redirect(route('deckDetail',['deck_id'=>$id]))->with('message', '牌組已加入購物車!');
    }

    public function deckAddToAccount(Request $request,$id){
        if(!Auth::check()){
            return redirect(route('deckDetail',['deck_id'=>$id]))->with('Errormessage', "請先<a href='".route('login')."'>登入</a>再將牌組加入帳號!!");
        }
        $deck = Deck::find($id);

        $string = "abcdefghijklmnopqrstuvwxyz@$&*+-_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $code = substr(str_shuffle($string), rand(1,10), 7);

        $new_deck = $deck->replicate();
        $new_deck->user_id=Auth::id();
        $new_deck->is_recommend=0;
        $new_deck->code = $code;
        $new_deck->save();

        return redirect(route('myAccount.myDeck'))->with('message', '已加入牌組!');

    }

    public function GetCardDataF(Request $request){
        $CID = $request->get('id');
        $card = Card::find($CID);
        $cardArray = $card->toArray();
        $skills = json_decode($cardArray['skill'], true);
        $skillHTML = '';
        $attributesImageByChinese = config('cards.Pokemon.attributesImageByChinese');
        foreach ($skills as $skill){
            $skillHTML .= "<div class='row mb-3'>";
            if($skill['name']!=''){
                $skillHTML .= "<p class='col-6 fs-5 fw-bold'>".$skill['name']."</p>";
            }
            if($skill['damage']!=''){
                $skillHTML .="<p class='col-6 fs-5 fw-bold'>".$skill['damage']."</p>";
            }
            if(!empty($skill['attribute'])){
                $skillHTML.="<div class='mb-2'>";
                foreach (explode(',',$skill['attribute']) as $skillType){
                    $skillHTML .= "<img class='energy-image' src='/storage/image/ptcg/energy/".$skillType.".jpg'>";
                }
                $skillHTML.="</div>";
            }
            if($skill['desc']!=''){
                $skillHTML.="<p>".$skill['desc']."</p>";
            }
            $skillHTML.="</div>";
        }
        $wreHTML = "<div class='col-4'><div class='badge-sm badge-black mb-2'>弱點</div><span>";
        if($card->weakpoint){
            $wreHTML .= " <img class='energy-image' src='/storage/image/ptcg/energy/".$attributesImageByChinese[$card->weakpoint].".jpg'>";
        }
        $wreHTML .= $card->weakpoint_value."</span>";
        $wreHTML .= "</div><div class='col-4'><div class='badge-sm badge-gray mb-2'>抵抗力</div><span>";
        if($card->resist != ''&& $card->resist != '--'){
            $wreHTML .= "<img class='energy-image' src='/storage/image/ptcg/energy/".$attributesImageByChinese[$card->resist].".jpg'>";
        }
        $wreHTML .= $card->resist_value."</span>";
        $wreHTML .= "</div><div class='col-4'><div class='badge-sm badge-gray mb-2'>撤退</div><span>";
        for($i=1;$i<=$card->escape;$i++){
            $wreHTML .= "<img class='energy-image' src='/storage/image/ptcg/energy/Colorless.jpg'>";
        }
        $wreHTML .= "</span></div>";
        if($card->type != '寶可夢卡'){
            $wreHTML = '';
        }
        $wishlistCheck = ($card->wishlistCheck())?'remove-wishlist':'add-to-wishlist';
        $wishlistCheckTitle = ($card->wishlistCheck())?'從願望清單移除':'加入願望清單';

        $infoHTML = "<div class='col-lg-6 mb-3 mb-lg-0'>
                        <img class='img-fluid w-100' src='{$card->image}' />
                        <div class='row align-items-center my-4'>
                            <div class='addtocart-selector col-6'>
                                <div class='addtocart-qty'>
                                    <div class='addtocart-button button-down modal-add' data-type='minus'>
                                        <span class='fas fa-minus' aria-label='increase quantity'></span>
                                    </div>
                                    <input type='text' class='addtocart-input modal-number' value='1' />
                                    <div class='addtocart-button button-up modal-add' data-type='plus'>
                                        <span class='fas fa-plus' aria-label='increase quantity'></span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6 text-end'>
                                <span class='price'>{$card->nowPrice()}元</span>
                            </div>
                        </div>
                        <div class='d-flex'>
                            <button type='button' data-id='{$card->id}' class='btn btn-sm btn-sm-yellow fs-5 w-50 me-2 {$wishlistCheck}'>{$wishlistCheckTitle}</button>
                            <button type='button' class='btn btn-sm btn-sm-black fs-5 w-50 ms-2' id='modal-add-to-cart' data-id='{$card->id}'>加入購物車</button>
                        </div>
                    </div>
                    <div class='col-lg-6'>
                        <div class='d-flex align-items-center mb-3'>
                            <span class='badge-pill badge-gray w-50 text-center fs-5 fw-bold p-2'>類型</span>
                            <span class='w-50 fs-5 fw-bold text-center'>{$card->type}</span>
                        </div>
                        <div class='d-flex align-items-center mb-3'>
                            <span class='badge-pill badge-gray w-50 text-center fs-5 fw-bold p-2'>稀有度</span>
                            <span class='w-50 fs-5 fw-bold text-center'>{$card->rarity}</span>
                            <span class='badge-pill badge-outline w-50 fs-5 fw-bold text-center'>{$card->competition_number}</span>
                        </div>
                        <div class='badge-pill badge-gray w-100 text-center fs-5 fw-bold p-2 mb-3'>招式</div>
                        <div>{$skillHTML}</div>
                        <div class='row'>{$wreHTML}</div>
                        <div class='row'><canvas id='historyPriceChart' data-value='{$card->indexHistoryPrices()}' ></canvas></div>
                    </div>";


        if($card){
            $result = array_merge(['result'=>'1','html'=>$infoHTML],$cardArray);
            return json_encode($result);
        }else{
            return json_encode(['result'=>'0','message'=>'找不到卡片資料!']);
        }
    }



}
