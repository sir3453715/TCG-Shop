<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventClass extends Model
{
    use SoftDeletes;
    protected $table = 'event_classes';

    protected $fillable = [
        'title',
    ];
}
