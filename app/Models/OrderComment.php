<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderComment extends Model
{
    protected $table = 'order_comment';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'order_id', 'dateTime', 'content'
    ];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function order()
    {
        return $this->belongsTo(User::class,'order_id');
    }

}
