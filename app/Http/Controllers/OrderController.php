<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Card;
use App\Models\Deck;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function cart(){
        $cart = session()->get('cart');
        $orderDefaultSetting = config('defaultSetting.order');
        $user = Auth::user();

        return view('cart',[
            'user'=>$user,
            'cart'=>$cart,
            'orderDefaultSetting'=>$orderDefaultSetting,
        ]);
    }


    public function orderCreate(Request $request){

        $tempcode2 = 'TS'.date('ymd');
        $seccode_order = Order::where('seccode','LIKE','%'.$tempcode2.'%')->orderBy('created_at','DESC')->get();
        if($seccode_order){
            $num = count($seccode_order);
            do{
                $num ++;
                $tempseccode = $tempcode2.str_pad($num,4,0,STR_PAD_LEFT);
                $chk_seccode = Order::where('seccode','=',$tempseccode)->first();//判斷已產生的訂單編號是否存在
            } while ($chk_seccode);
        }else{
            $tempseccode = $tempcode2.'0001';
        }

        $data =[
            'seccode'=>$tempseccode,
            'user_id'=>Auth::id(),
            "buyer_name" => ($request->get('buyer_name'))??'',
            "buyer_phone" => ($request->get('buyer_phone'))??'',
            "buyer_address" => ($request->get('buyer_address'))??'',
            "payment" => ($request->get('payment'))??'',
            "shipment" => ($request->get('shipment'))??'',
            "note" => ($request->get('note'))??'',
            "pay_status" => 1,
            "status" => 1,
            "CVS_name" =>($request->get('CVS_name'))??'',
            "CVS_code" =>($request->get('CVS_code'))??'',
        ];

        $order = Order::create($data);

        $card_ids = $request->get('item_card_id');
        $number = $request->get('item_num');
        $unit_price = $request->get('item_unit');
        $card_name = $request->get('item_name');

        $total = 0;
        foreach ($card_ids as $index => $card_id){
            $itemData = [
                'order_id'=>$order->id,
                'card_id'=>$card_id,
                'number'=>$number[$index],
                'unit_price'=>$unit_price[$index],
                'subtotal'=>intval($number[$index])*intval($unit_price[$index]),
                'title'=>$card_name[$index],
            ];
            $orderItem = OrderItem::create($itemData);

            $total += $itemData['subtotal'];
        }

//        $total += $shipping;//運費計算

        $order->fill(['total'=>$total]);
        $order->save();
        ActionLog::create_log($order,'新增');

        return redirect(route('invoice',['seccode'=>base64_encode($tempseccode)]))->with('message', '已成功下單!');
    }

    public function invoice($bs64_seccode){
        $seccode = base64_decode($bs64_seccode);
        $order = Order::where('seccode',$seccode)->first();
        $orderDefaultSetting = config('defaultSetting.order');
        $user = Auth::user();
        if(!$order || $order->user_id != Auth::id()){
            return redirect(route('index'))->with('Errormessage', '無法查看此訂單!');
        }

        return view('invoice',[
            'order'=>$order,
            'orderDefaultSetting'=>$orderDefaultSetting,
            'user'=>$user,
        ]);
    }

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
                    $cart['items'][$card_id]['unit']=$card->nowPrice();
                    $cart['items'][$card_id]['price']=$new_number*$card->nowPrice();
                }else{
                    $cart['items'][$card_id]=[
                        'name'=>$card->name,
                        'image'=>$card->image,
                        'number'=>1,
                        'unit'=>$card->nowPrice(),
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
                        $cart['items'][$card_id]['unit']=$card->nowPrice();
                        $cart['items'][$card_id]['price']=$new_number*$card->nowPrice();
                    }
                    $cart['count'] --;
                }
            break;
            case 'change':

                if(isset($cart['items'][$card_id])){
                    $original_num =$cart['items'][$card_id]['number'];
                    $new_number = $request->get('num');
                    $diff = $new_number - $original_num; // 新跟舊的差額
                    if($new_number == 0){
                        unset($cart['items'][$card_id]);
                    }else{
                        $cart['items'][$card_id]['number']=$new_number;
                        $cart['items'][$card_id]['unit']=$card->nowPrice();
                        $cart['items'][$card_id]['price']=$new_number*$card->nowPrice();
                    }
                    $cart['count'] += $diff;
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
        $cart['shipping']=0;

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
            $title = '我的牌組';
            $string = "abcdefghijklmnopqrstuvwxyz@$&*+-_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $code = substr(str_shuffle($string), rand(1,10), 7);
            $titleCount = Deck::where('user_id',Auth::id())->where('title','LIKE','我的牌組%')->count();
            if($titleCount >=1){
                $title .= "($titleCount)";
            }
            $data=[
                'user_id'=>Auth::id(),
                'title'=>$title,
                'competition'=>$competition,
                'card_info'=>serialize($deckInfo),
                'is_recommend'=>0,
                'code'=>$code,
            ];

            $deck = Deck::create($data);

            ActionLog::create_log($deck,'新增');

            return redirect(route('myAccount.myDeckDetail',['deck_id'=>$deck->id]))->with('message', '牌組已建立!');
        }else{
            return redirect(route('card'))->with('Errormessage', '牌組不符合規範!!無法儲存牌組');
        }
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
        return redirect(route('cart'));
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
