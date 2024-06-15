<?php

namespace App\Models\gcaqueryitems;

use App\Models\gcaqueryitems\Traits\GcaQueryItemRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaQueryItem extends Model
{
    use HasFactory,GcaQueryItemRelationship;
    protected $fillable = [
        'gca_query_id',
        'defect',
        'query_name',
        'description',
        'size',
        'quantity',
        'zonea',
        'zoneb',
        'zonec',
        'zoned',
        'exterior',
        'interiorprimary',
        'interiorsecondary',
        'weightfactor'
      
 
    ];
}
