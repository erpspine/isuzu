<?php

namespace App\Models\gcaquerycategorycv;

use App\Models\gcaauditcategory\GcaAuditReportCategory;
use App\Models\gcaqueryanswer\GcaQueryAnswer;
use App\Models\gcaquerycategoryitemcv\GcaQueryCategoryItemCv;
use App\Models\gcaquerytitle\GcaQueryTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaQueryCategoryCv extends Model
{
    use HasFactory;

    protected $fillable = ['name','position','gca_audit_report_category_id','gca_query_title_id'];
    public function titles()
    {
        return $this->belongsTo(GcaQueryTitle::class,'gca_query_title_id','id');
    }
    public function categoryItems()
    {
        return $this->hasMany(GcaQueryCategoryItemCv::class,'gca_query_category_cv_id','id');
    }

    public function classification()
    {
        return $this->belongsTo(GcaAuditReportCategory::class,'gca_audit_report_category_id','id');
    }

    public function categoryanswer()
    {
        return $this->hasMany(GcaQueryAnswer::class,'gca_query_category_id','id');
    }

    
  
}
