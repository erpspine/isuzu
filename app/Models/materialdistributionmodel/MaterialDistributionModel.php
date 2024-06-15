<?php

namespace App\Models\materialdistributionmodel;

use App\Models\materialdistributionmodel\Traits\MaterialDistributionModelRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDistributionModel extends Model
{
    use HasFactory,MaterialDistributionModelRelationship;
    protected $fillable = [
        'unit_model_id',
        'name',
        'created_at',
        'updated_at',
    ];
}
