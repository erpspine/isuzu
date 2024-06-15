<?php

namespace App\Models\calibrationhistory;

use App\Models\calibrationhistory\Traits\CalibrationRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationHistory extends Model
{
    use HasFactory,CalibrationRelationship;
    protected $fillable = [
        'tcm_id',
        'date_calibrated',
        'days_to_next_calibrarion',
        'next_calibration_date',
        'calibration_status',
        'created_by',
        'note'
     
    ];
}
