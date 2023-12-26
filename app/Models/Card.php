<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Card extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lang', 'tw_id', 'name', 'hp', 'image', 'series', 'serial_number', 'serial_code', 'attribute', 'type',
        'skill', 'rarity', 'competition_number', 'kingdom', 'weakpoint', 'weakpoint_value', 'resist', 'resist_value', 'escape', 'default_price',
    ];


    public function historyPrices()
    {
        return $this->hasMany(HistoryPrice::class,'card_id');
    }

    public function indexHistoryPrices()
    {
        $indexHistoryPrice = $this->historyPrices()->orderBy('dateTime','DESC')->limit(7)->get()->toArray();


        return json_encode($indexHistoryPrice);
    }

    public function nowPrice(){
        $price = $this->default_price;
        $productPrices = Product::where('card_id',$this->id)->pluck('price')->toArray();
        if(!empty($productPrices)){
            $SortProductPrices = sort($productPrices);
            $count = sizeof($SortProductPrices);
            $getNum = ceil($count/10)-$count;
            $price = array_slice($SortProductPrices,$getNum,1);
        }

        return $price;
    }


    public function wishlistCheck(){
        $user_id = Auth::id();
        $wishlist_exists = Wishlist::where('card_id',$this->id)->where('user_id',$user_id)->exists();

        return $wishlist_exists;
    }

}
