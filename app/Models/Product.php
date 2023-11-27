<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'vendor_id', 'card_id', 'status', 'price', 'stock'
    ];



    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class,'card_id');
    }

}
