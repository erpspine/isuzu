<?php

namespace App\Models\qcosmonitoringsheet;

use App\Models\qcosmonitoringsheet\Traits\QcosMonitoringSheetRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcosMonitoringSheet extends Model
{
    use HasFactory,QcosMonitoringSheetRelationship;

    protected $fillable = [
       'result_type',
       'reading',
       'result_status',
       'category_id',
       'vehicle_id',
       'created_by',
       'tcm_id',
       'joint_id',
       'reading_date',
       'vin_no',
       'qcos_ref',
       'paired'
   ];


}
