<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{

    protected $fillable = [
        'user_id', 'card_id',
    ];


    public function card()
    {
        return $this->belongsTo(Card::class,'card_id')->first();
    }

}
