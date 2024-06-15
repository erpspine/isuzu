<?php

namespace App\Models\materialdistributionmodel\Traits;


use App\Models\unit_model\Unit_model;


/**
 * Class AccountRelationship
 */
trait MaterialDistributionModelRelationship
{
     public function category()
    {
        return $this->hasOne(Unit_model::class,'id','unit_model_id');
    }


}
