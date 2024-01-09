<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Deck extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'competition', 'is_recommend', 'card_info', 'code', 'image'
    ];


    public function user(){
        if($this->user_id){
            return $this->belongsTo(User::class,'user_id')->first()->name;
        }
    }

    public function deckCardInfo(){
        if($this->card_info){
            $deck= [];
            $deckInfo = unserialize($this->card_info);
            $cards = $deckInfo['card'];
            foreach ($cards as $card){
                $cardFind = Card::find($card['card_id']);
                $deck[$card['card_id']]=[
                    'name'=>$cardFind->name,
                    'image'=>$cardFind->image,
                    'num'=>$card['card_num'],
                ];
            }
            return $deck;
        }
    }
    public function deckCardCategoryInfo(){

        if($this->card_info){
            $deck= [];
            $deckInfo = unserialize($this->card_info);
            $cards = $deckInfo['card'];
            foreach ($cards as $card){
                $cardFind = Card::find($card['card_id']);
                $deck[$cardFind->type][$card['card_id']]=[
                    'name'=>$cardFind->name,
                    'image'=>$cardFind->image,
                    'num'=>$card['card_num'],
                ];
            }
            $sortDeck = [];
            $types = config('cards.Pokemon.types');
            foreach ($types as $type){
                if(isset($deck[$type])){
                    $sortDeck[$type]=$deck[$type];
                }
            }

            return $sortDeck;
        }
    }
    public function deckBuildCategoryInfo(){

        if($this->card_info){
            $deck= [];
            $deckInfo = unserialize($this->card_info);
            $cards = $deckInfo['card'];
            foreach ($cards as $card){
                $cardFind = Card::find($card['card_id']);
                $deck[$cardFind->type][$card['card_id']]=[
                    'name'=>$cardFind->name,
                    'serial_code'=>$cardFind->serial_code,
                    'serial_number'=>$cardFind->serial_number,
                    'num'=>$card['card_num'],
                ];
            }
            $sortDeck = [];
            $types = config('cards.Pokemon.types');
            foreach ($types as $type){
                if(isset($deck[$type])){
                    $sortDeck[$type]=$deck[$type];

                }
            }

            return $sortDeck;
        }
    }
    public function deckBuildCategoryTotal(){
        $types = config('cards.Pokemon.types');
        foreach ($types as $type){
                $total[$type]=0;
        }
        if($this->card_info){
            $total['total']=0;
            $deckInfo = unserialize($this->card_info);
            $cards = $deckInfo['card'];
            foreach ($cards as $card){
                $cardFind = Card::find($card['card_id']);
                if(isset($total[$cardFind->type])){
                    $total[$cardFind->type]+=$card['card_num'];
                }else{
                    $total[$cardFind->type]=$card['card_num'];
                }
                $total['total']+=$card['card_num'];
            }
            return $total;
        }
    }
    public function deckUnserialize(){
        if($this->card_info){
            $deckInfo = unserialize($this->card_info);
            return $deckInfo;
        }
    }
}
