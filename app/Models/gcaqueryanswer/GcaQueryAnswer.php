<?php

namespace App\Models\gcaqueryanswer;

use App\Models\gcaqueryanswer\Traits\GcaQueryAnswerRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaQueryAnswer extends Model
{
    use HasFactory,GcaQueryAnswerRelationship;
    protected $fillable = [
        'vehicle_id',
        'gca_query_item_id',
        'vehicle_type',
        'vehicle_type_id',
        'gca_audit_report_category_id',
        'defect_count',
        'defect_category',
        'defect_option',
        'defect_image',
        'step_id',
        'defect',
        'defect_tag',
        'note',
        'weight',
        'car_number',
        'gca_query_category_id',
        'user_id',
        'shop_id',
        'date_corrected',
        'correction_remarks',
        'corrected_by',
        'is_corrected',
        'gca_manual_reference',
        'responsible_team_leader',
       
 
    ];
    protected $appends = ['DefectImageUri'];
   
    public function getDefectImageUriAttribute()
    {
        if (isset($this->attributes['defect_image'])) {
            return url('upload/') . '/' . $this->attributes['defect_image'];
        }
    }
}
