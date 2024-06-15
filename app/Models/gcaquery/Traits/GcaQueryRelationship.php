<?php

namespace App\Models\gcaquery\Traits;

use App\Models\gcaauditcategory\GcaAuditReportCategory;
use App\Models\gcaqueritemy\GcaQueryItem;
use App\Models\user\User;

/**
 * Class GcaQueryRelationship
 */
trait GcaQueryRelationship
{



    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function user_updated()
    {
        return $this->hasOne(User::class,'id','updated_by');
    }
    public function query_items()
    {
        return $this->hasMany(GcaQueryItem::class,'gca_query_id','id');
    }
    public function category()
    {
        return $this->hasOne(GcaAuditReportCategory::class,'id','gca_audit_report_category_id');
    }

  



}
