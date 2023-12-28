<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Card;
use App\Models\Deck;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function dashboard(){
        $user = Auth::user();
        return view('dashboard',[
            'user'=>$user
        ]);
    }

    public function myDeck(){
        $decks = Deck::where('user_id',Auth::id())->paginate(16);

        return view('myDeck',[
            'decks'=>$decks,
        ]);
    }

    public function myDeckDetail($id){
        $deck = Deck::find($id);
        if($deck->user_id != Auth::id()){
           return redirect(route('myAccount.myDeck'))->with(['Errormessage'=>'無法查看其他人的牌組!']);
        }

        return view('myDeckDetail',[
            'deck'=>$deck
        ]);
    }


    public function wishlist(){
        $wishlists = Wishlist::where('user_id',Auth::id())->get();
        foreach ($wishlists as $wishlist){
            $card = $wishlist->card();
            $deck[$card->type][$card->id]=$card;
        }
        $wishlistArray = [];
        $types = config('cards.Pokemon.types');
        foreach ($types as $type){
            if(isset($deck[$type])){
                $wishlistArray[$type]=$deck[$type];

            }
        }


        return view('wishlist',[
            'wishlistArray'=>$wishlistArray,
        ]);
    }

    public function order(){
        $orders = Order::where('user_id',Auth::id())->orderBy('created_at','DESC')->paginate(16);

        $orderDefaultSetting = config('defaultSetting.order');
        return view('order',[
            'orders'=>$orders,
            'orderDefaultSetting'=>$orderDefaultSetting,
        ]);
    }

    public function orderDetail($id){
        $order = Order::find($id);
        $orderDefaultSetting = config('defaultSetting.order');

        return view('orderDetail',[
            'order'=>$order,
            'orderDefaultSetting'=>$orderDefaultSetting,
        ]);
    }


    public function editUser(Request $request){
        $validator = Validator::make($request->toArray(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|same:second_password',
            'second_password'=>'required',
        ]);

        $user = Auth::user();
        $data=[
            'name'=>$request->get('name'),
            'phone'=>$request->get('phone'),
            'address'=>$request->get('address'),
            'birthday'=>$request->get('birthday'),
        ];
        if($request->get('change_password')=='1'){
            if($request->get('password')){
                $data['password'] = Hash::make($request->get('password'));
            }
        }
        $user->fill($data);
        ActionLog::create_log($user);
        $user->save();

        return redirect(route('myAccount.dashboard',[
                'user'=>Auth::id()
        ]))->with('message', '資料已更新!');

    }
    public function deckImport(Request $request){
        $code = $request->get('code');
        $deck = Deck::where('code',$code)->first();
        $new_deck = $deck->replicate();
        $new_deck->user_id=Auth::id();
        $new_deck->is_recommend=0;
        $new_deck->save();

        return redirect(route('myAccount.myDeck'))->with('message', '已匯入牌組!');

    }

    public function deckSaveTitle(Request $request,$id){
        $deck = Deck::find($id);
        $data=[
            'title'=>$request->get('title'),
        ];
        $deck = $deck->fill($data);
        ActionLog::create_log($deck);
        $deck = $deck->save();

        return redirect(route('myAccount.myDeckDetail',['deck_id'=>$id]));
    }
    public function deckEdit(Request $request,$id){
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
                'price'=>$card->nowPrice(),
            ];
            $cart['total'] += ($card->nowPrice()*$deckCard['num']);
            $cart['count'] += $deckCard['num'];
        }
        $cart['edit'] = $deck->id;

        session()->put('cart', $cart);;
        return redirect(route('card'))->with('message', '牌組已加入編輯!');
    }

    public function deckDel(Request $request,$id){
        $deck = Deck::find($id);
        if($deck){
            $deck->delete();
            ActionLog::create_log($deck,'刪除');
        }

        return redirect(route('myAccount.myDeck'))->with('message', '牌組已刪除!');

    }


    public function AddToWishlist(Request $request){
        $card_id = $request->get('id');
        $user_id = Auth::id();
        $wishlist = Wishlist::where('card_id',$card_id)->where('user_id',$user_id)->exists();
        if(!$wishlist){
            $data=[
                'card_id'=>$card_id,
                'user_id'=>$user_id,
            ];
            Wishlist::create($data);
            return json_encode(['result'=>'1']);
        }
        return json_encode(['result'=>'0']);
    }

    public function RemoveWishlist(Request $request){
        $card_id = $request->get('id');
        $user_id = Auth::id();
        $wishlist = Wishlist::where('card_id',$card_id)->where('user_id',$user_id)->first();
        if($wishlist){
            $wishlist->delete();
            return json_encode(['result'=>'1']);
        }
        return json_encode(['result'=>'0']);
    }

    public function build($id,Request $request){

        $deckCards = [];
        $deck = Deck::find($id);
        if($deck->user_id != Auth::id() && $deck->user_id != ''){
            return redirect(route('myAccount.myDeck'))->with('Errormessage', '無法獲得此牌組的構築表!!');
        }
        $deckCards = $deck->deckBuildCategoryInfo();
        $deckCategoryTotal = $deck->deckBuildCategoryTotal();

        return view('admin.decks.buildImage',[
            'deckCards'=>$deckCards,
            'deckCategoryTotal'=>$deckCategoryTotal
        ]);

    }
}
