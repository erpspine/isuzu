<?php

namespace App\Models\gcafollowup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaFollowup extends Model
{
    use HasFactory;
    protected $fillable = ['note','status','created_by'];
}
