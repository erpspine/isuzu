<?php

namespace App\Models\calibrationhistory\Traits;

use App\Models\tcm\Tcm;

/**
 * Class AccountRelationship
 */
trait CalibrationRelationship
{



     public function tools(){
        return $this->hasOne(Tcm::class, 'id','tcm_id');
    }

   


 
    
     

}
