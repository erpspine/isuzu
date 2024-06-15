<?php

namespace App\Models\queryanswer\Traits;
use App\Models\appuser\Appuser;
use App\Models\querycategory\Querycategory;
use App\Models\routingquery\Routingquery;
use App\Models\vehicle_units\vehicle_units;

/**
 * Class AccountRelationship
 */
trait QueryanswerRelationship
{



     public function defects()
    {
        return $this->hasMany('App\Models\querydefect\Querydefect','query_anwer_id','id');
    }

      public function doneby()
    {

      return $this->hasOne(Appuser::class,'id','done_by');


    }

    public function routing()
    {


       return $this->hasOne('App\Models\routingquery\Routingquery','id','query_id');
     


    }

      public function shop()
    {
        return $this->hasOne('App\Models\shop\shop','id','shop_id');
    }

     public function vehicle()
    {
        return $this->hasOne(vehicle_units::class,'id','vehicle_id');
    }


    public function get_defects()
    {
        return $this->belongsTo('App\Models\querydefect\Querydefect','id','query_anwer_id');
    }

    public function querycategory()
    {

      return $this->hasOne(Querycategory::class,'id','category_id');


    }

    public function queries()
    {

      return $this->hasOne(Routingquery::class,'id','query_id');


    }


    


}
