<?php

namespace App\Models\attendancestatus;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\shop\Shop;

class Attendance_status extends Model
{
    use HasFactory;

    protected $table = "attendance_statuses";

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shop(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
