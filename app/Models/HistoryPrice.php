<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryPrice extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'card_id', 'price', 'dateTime'
    ];
}
