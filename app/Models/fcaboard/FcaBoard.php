<?php

namespace App\Models\fcaboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcaBoard extends Model
{
    use HasFactory;
    protected $fillable = ['ref_id','defect','shop','model','defect_weight','lot_job','fca_date','done_by','created_at','updated_at'];
}
