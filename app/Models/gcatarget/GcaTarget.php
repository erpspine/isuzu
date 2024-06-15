<?php

namespace App\Models\gcatarget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaTarget extends Model
{
    use HasFactory;

    protected $table = "gcatarget";
    protected $fillable = [
        'user_id',
        'cvdpv',
        'cvwdpv',
        'lcvdpv',
        'lcvwdpv',
        'month',
        'target_name',
        'year_date',
        'date_to'
       
    ];

}
