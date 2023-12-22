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

    public function order(){
        $orders = Order::where('user_id',Auth::id())->orderBy('created_at','DESC')->paginate(16);

        $orderDefaultSetting = config('defaultSetting.order');
        return view('order',[
            'orders'=>$orders,
            'orderDefaultSetting'=>$orderDefaultSetting,
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

    public function orderDetail(){

        return view('orderDetail');
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

}
