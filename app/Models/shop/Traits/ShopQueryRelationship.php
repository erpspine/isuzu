<?php

namespace App\Models\shop\Traits;
use App\Models\querycategory\Querycategory;



/**
 * Class AccountRelationship
 */
trait ShopQueryRelationship
{
     public function querycategory()
    {
        return $this->hasMany('App\Models\querycategory\Querycategory','shop_id', 'id');
    }



    public function unitmovement()
    {
        return $this->hasMany('App\Models\unitmovement\Unitmovement','shop_id', 'id');
    }




 public function drrtargetshop()
    {
        return $this->hasOne('App\Models\drrtargetshop\DrrTargetShop','shop_id', 'id');
    }


    public function querybyshop()
    {
        return $this->hasManyThrough('App\Models\querymodels\QueryModels','App\Models\querycategory\Querycategory','shop_id','querycategory_id','id','id');
    }


   /* public function queries()
    {
        return $this->hasManyThrough(Querycategory::class, Querycategory::class);
    }*/

      

}
