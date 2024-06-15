<?php
namespace App\Models\qcoscontainemnt\Traits;
use App\Models\appuser\Appuser;
use App\Models\shop\Shop;
use App\Models\tcmjoint\TcmJoint;

/**
 * Class PlantDivisionRelationship
 */
trait QcosContainmentRelationship
{
   
    public function doneby()
    {

      return $this->hasOne(Appuser::class,'id','generated_by');


    }    

    public function shop()
    {

      return $this->hasOne(Shop::class,'id','shop_id');


    }   
    public function joint()
    {

      return $this->hasOne(TcmJoint::class,'id','joint_id');


    }  

}
