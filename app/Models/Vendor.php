<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function vendorStaff()
    {
        return $this->hasMany(VendorStaff::class,'vendor_id');
    }
}
