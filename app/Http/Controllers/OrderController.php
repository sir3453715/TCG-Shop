<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function AddToCart(Request $request){
        $card_id = $request->get('id');
        $type = $request->get('type');
        $cart = session()->get('cart');
        $card = Card::find($card_id);
        switch ($type){
            case 'plus':
                if(isset($cart['items'][$card_id])){
                    $new_number = $cart['items'][$card_id]['number']+1;
                    $cart['items'][$card_id]['number']=$new_number;
                    $cart['items'][$card_id]['price']=$new_number*$card->nowPrice();
                }else{
                    $cart['items'][$card_id]=[
                        'name'=>$card->name,
                        'image'=>$card->image,
                        'number'=>1,
                        'price'=>$card->nowPrice(),
                    ];
                }
                if(isset($cart['count'])){
                    $cart['count'] ++;
                }else{
                    $cart['count'] = 1;
                }
            break;
            case 'minus':
                if(isset($cart['items'][$card_id])){
                    if($cart['items'][$card_id]['number'] == 1){
                        unset($cart['items'][$card_id]);
                    }else{
                        $new_number = $cart['items'][$card_id]['number']-1;
                        $cart['items'][$card_id]['number']=$new_number;
                        $cart['items'][$card_id]['price']=$new_number*$card->nowPrice();
                    }
                    $cart['count'] --;
                }
            break;
        }
        if($cart['count']<0){
            $cart['count'] = 0;
        }
        $cart['total'] = 0;
        foreach ($cart['items'] as $item){
            $cart['total'] += $item['price'];
        }

        $html=view('component.mini-cart-ajax')->with('items', $cart['items'])->render();

        session()->put('cart', $cart);;
        $result = ['result'=>'1','cart'=>$cart,'html'=>$html];
        return json_encode($result);
    }

    public function CleanCart(Request $request){
        session()->forget('cart');
        return 1;
    }


    public function deckCreate(Request $request){
        dd('deckCreate');

    }
    public function deckUpdate(Request $request){
        $deck = Deck::find($request->get('deck_id'));
        $deckSession = session()->get('cart');

        foreach ($deckSession['items'] as $card_id => $deckItem){
            $card = Card::find($card_id);
            $deckInfo['card'][]=[
                'card_id' => $card_id,
                'card_num' => $deckItem['number'],
            ];
            $competitionArray[]=$card->competition_number;
        }
        $deckInfo['count']=$deckSession['count'];
        $comptitionResult = array_diff(explode(',',app('Option')->ptcg_standard),$competitionArray);
        if(empty($comptitionResult)){//結果空值，代表全部都是標準賽卡
            $competition = 'standard';
        }else{
            $competition = 'expanded';
        }
        $deckCheckResult = $this->deckCheck($deckInfo);

        if($deckCheckResult){
            $data=[
                'user_id'=>Auth::id(),
                'competition'=>$competition,
                'card_info'=>serialize($deckInfo),
            ];
            $deck = $deck->fill($data);
            ActionLog::create_log($deck);
            $deck = $deck->save();

            return redirect(route('myAccount.myDeckDetail',['deck_id'=>$request->get('deck_id')]))->with('message', '牌組已完成編輯!');
        }else{
            return redirect(route('card'))->with('Errormessage', '牌組不符合規範!!無法儲存牌組');
        }
    }
    public function cartSubmit(Request $request){
        dd('cartSubmit');
    }


    public function deckCheck($deckInfo){
        $result = false;

        if($deckInfo['count'] <=60){
            $result = true;
        }else{
            $result = false;
            return $result;
        }
        foreach ($deckInfo['card'] as $cardData){
            $card = Card::find($cardData['card_id']);
            if($card->type != '基本能量卡'){
                if($cardData['card_num'] > 4){//非能量卡大於四張
                    $result = false;
                    break;
                }else{
                    $result = true;
                }
            }
        }

        return $result;
    }


}
