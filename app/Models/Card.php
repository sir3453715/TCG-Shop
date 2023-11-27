<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
