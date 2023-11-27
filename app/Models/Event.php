<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'image', 'content', 'dateTime', 'class_id', 'status', 'top'
    ];


    protected $dates = ['dateTime'];


    public function eventClass()
    {
        return $this->belongsTo(EventClass::class,'class_id');
    }
}
