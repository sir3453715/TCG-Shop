<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorStaff extends Model
{
    protected $table = 'vendor_staffs';

    use SoftDeletes;

    protected $fillable = [
        'vendor_id', 'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

}
