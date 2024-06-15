<?php

namespace App\Models\gcaauditcategory;

use App\Models\gcaqueryanswer\GcaQueryAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaAuditReportCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','short_form','user_id',
    ];

    public function answers()
    {
        return $this->hasMany(GcaQueryAnswer::class,'gca_audit_report_category_id','id');
    }

  
}
