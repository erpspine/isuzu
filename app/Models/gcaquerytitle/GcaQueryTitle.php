<?php

namespace App\Models\gcaquerytitle;

use App\Models\gcaqueryanswer\GcaQueryAnswer;
use App\Models\gcaquerycategorycv\GcaQueryCategoryCv;
use App\Models\gcaquerycategoryitemcv\GcaQueryCategoryItemCv;
use App\Models\gcasteps\GcaSteps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaQueryTitle extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_type','query_group_name','title','gca_stage_id'];

    public function querycategories()
    {
        return $this->hasMany(GcaQueryCategoryCv::class,'gca_query_title_id','id');
    }

    public function answered()
    {
        return $this->hasManyThrough(GcaQueryAnswer::class, GcaQueryCategoryCv::class,'gca_query_title_id','gca_audit_report_category_id');
    }

    public function gcaSteps()
    {
        return $this->hasOne(GcaSteps::class,'id','gca_stage_id');
    }
 
}
