<?php

namespace App\Models\tcm\Traits;

use App\Models\tcmjoint\TcmJoint;

/**
 * Class AccountRelationship
 */
trait TcmRelationship
{



     public function shop()
    {
        return $this->hasOne('App\Models\shop\Shop','id','shop_id');
    }

    public function tcmjoint()
    {
        return $this->hasMany(TcmJoint::class,'tcm_id');
    }

   


 
    
     

}
