<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'parent_id', 'vendor_id', 'seccode', 'user_id', 'status', 'total', 'payment', 'pay_status',
        'shipment', 'buyer_name', 'buyer_phone', 'buyer_address', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function orderComment()
    {
        return $this->hasMany(OrderComment::class)->orderBy('created_at','DESC');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'order_id');
    }
    public function orderItemsSort()
    {

        $orderItems =  $this->hasMany(OrderItem::class,'order_id')->get();
        foreach ($orderItems as $orderItem){
            $orderItemsArray[$orderItem->card->type][]=[
                "id" => $orderItem->id,
                "card_id" => $orderItem->card_id,
                "name" => $orderItem->card->name,
                "image" => $orderItem->card->image,
                "number" => $orderItem->number,
                "unit_price" => $orderItem->unit_price,
                "subtotal" => $orderItem->subtotal,
            ];
        }

        $types = config('cards.Pokemon.types');
        foreach ($types as $type){
            if(isset($orderItemsArray[$type])){
                $newOrderItemsArray[$type]=$orderItemsArray[$type];
            }
        }

        return $newOrderItemsArray;
    }

}
