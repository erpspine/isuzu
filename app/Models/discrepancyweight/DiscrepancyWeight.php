<?php

namespace App\Models\discrepancyweight;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscrepancyWeight extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_type','factor','description','created_by','updated_by'];
}
