<?php

namespace App\Models\tcm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tcm\Traits\TcmRelationship;



class Tcm extends Model
{
    use HasFactory,
    TcmRelationship;
    protected $fillable = [
        'tool_id',
        'tool_model',
        'tool_type',
        'shop_id',
        'upper_control_limit',
        'lower_control_limit',
        'last_calibration_date',
        'next_calibration_date',
        'serial_number',
        'transducer_code',
        'torque_setting_value',
        'status',
        'sku',
        'days_to_next_calibrarion',
    ];
}
