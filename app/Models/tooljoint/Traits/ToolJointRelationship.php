<?php

namespace App\Models\tooljoint\Traits;

use App\Models\unit_model\Unit_model;

/**
 * Class ToolJointRelationship
 */
trait ToolJointRelationship
{



     public function model()
    {
        return $this->hasOne(Unit_model::class,'id','model_id');
    }
  

    

   


 
    
     

}
