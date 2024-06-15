<?php

namespace App\Models\Pna;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\materialdistributionmodel\MaterialDistributionModel;

class Part_Template extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_distribution_model_id',
        'partnumber',
        'Description',
        'upc',
        'pna_case',
        'Box',
        'FNA',
        'LOC1',
        'QTY1',
        'LOC2',
        'QTY2',
        'LOC3',
        'QTY3',
        'LOC4',
        'QTY4',
        'LOC5',
        'QTY5',
        'LOC6',
        'QTY6',
        'LOC7',
        'QTY7',
        'LOC8',
        'QTY8',
        'LOC9',
        'QTY9',
        'LOC10',
        'QTY10',
        'LOC11',
        'QTY11',
        'LOC12',
        'QTY12'



    ];
    public function model()
    {
        return $this->hasOne(MaterialDistributionModel::class,'id','material_distribution_model_id');
    }
}
