<?php

namespace App\Models\tcmjoint\Traits;

use App\Models\shop\Shop;
use App\Models\tcm\Tcm;
use App\Models\tooljoint\ToolJoint;
use App\Models\user\User;

/**
 * Class AccountRelationship
 */
trait TcmJointRelationship
{



     public function tool()
    {
        return $this->hasOne(Tcm::class,'id','tcm_id');
    }
    public function ptool()
    {
        return $this->hasOne(Tcm::class,'id','production_tool');
    }

    public function toolmodel()
    {
        return $this->hasMany(ToolJoint::class,'tcm_joint_id','id');
    }
    public function team_leader()
    {
        return $this->hasOne(User::class,'id','team_leader_id');
    }
    public function shop()
    {
        return $this->hasOne(Shop::class,'id','shop_id');
    }
  

    

   


 
    
     

}
