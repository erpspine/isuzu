<?php

namespace App\Models\gcazone;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaZone extends Model
{
    use HasFactory;
    protected $fillable = ['zone_type','name','description','created_by'];
}
