<?php

namespace App\Models\qcosmonitoringsheet\Traits;

use App\Models\tcm\Tcm;
use App\Models\tcmjoint\TcmJoint;
use App\Models\unit_model\Unit_model;
use App\Models\vehicle_units\vehicle_units;

/**
 * Class AccountRelationship
 */
trait QcosMonitoringSheetRelationship
{



    public function tcm(){
        return $this->hasOne(Tcm::class, 'id','tcm_id');
    }
    public function joint(){
        return $this->hasOne(TcmJoint::class, 'id','joint_id');
    }
    public function vehicle(){
        return $this->hasOne(vehicle_units::class, 'id','vehicle_id');
    }

  


    

   


 
    
     

}
