<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardSeries extends Model
{

    use SoftDeletes;
    protected $table = 'card_series';

    protected $fillable = [
        'title', 'serial_number', 'sort', 'kingdom',
    ];

}
