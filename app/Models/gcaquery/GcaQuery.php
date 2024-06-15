<?php

namespace App\Models\gcaquery;

use App\Models\gcaquery\Traits\GcaQueryRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaQuery extends Model
{
    use HasFactory,GcaQueryRelationship;
    protected $fillable = [
        'category_name',
        'has_size',
        'zone_type',
        'has_description',
        'note',
        'position',
        'has_quality',
        'user_id',
        'status',
        'vehicle_type',
        'gca_audit_report_category_id',
        'updated_by',
        'icon',
 
    ];
}
