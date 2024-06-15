<?php

namespace App\Models\unit_model\Traits;

use App\Models\tcmjoint\TcmJoint;
use App\Models\vehicletype\VehicleType;

/**
 * Class AccountRelationship
 */
trait UnitModelRelationship
{
     public function category()
    {
        return $this->hasOne('App\Models\vehicletype\VehicleType','id','vehicle_type_id');
    }

    public function joints()
    {
        return $this->hasMany(TcmJoint::class,'model_id','id');
    }
    public function unittype()
    {
        return $this->hasOne(VehicleType::class,'id','vehicle_type_id');
    }
     

      /*public function model()
    {
        return $this->hasOne('App\Models\unit_model\Unit_model','id','model_id');
    }  */

}
