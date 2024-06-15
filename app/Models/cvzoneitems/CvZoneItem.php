<?php

namespace App\Models\cvzoneitems;

use App\Models\cvzones\CvZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvZoneItem extends Model
{
    use HasFactory;
    protected $fillable = ['cv_zone_id','zone','defination','template_position','applicable_portion'];

    public function cvzone()
    {

      return $this->belongsTo(CvZone::class,'cv_zone_id');


    }
}
