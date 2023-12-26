<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
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
}
