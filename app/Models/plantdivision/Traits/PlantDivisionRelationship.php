<?php

namespace App\Models\plantdivision\Traits;



/**
 * Class PlantDivisionRelationship
 */
trait PlantDivisionRelationship
{
     public function shop()
    {
        return $this->hasMany('App\Models\shop\Shop','plant_division_id','id');
    }
      

}
