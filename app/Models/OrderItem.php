<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $table = 'order_items';
    protected $fillable = [
        'order_id', 'product_id', 'card_id', 'number', 'unit_price', 'subtotal', 'title'
    ];


    public function card()
    {
        return $this->belongsTo(Card::class,'card_id');
    }

}
