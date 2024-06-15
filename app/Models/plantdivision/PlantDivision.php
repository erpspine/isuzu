<?php

namespace App\Models\plantdivision;

use App\Models\plantdivision\Traits\PlantDivisionRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantDivision extends Model
{
    use HasFactory,PlantDivisionRelationship;
    protected $fillable = [
        'division_name',
    ];

       protected $hidden = [
        'password', 'created_at', 'updated_at',
    ];

    
}
