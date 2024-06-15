<?php

namespace App\Models\qcosemail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcosEmail extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'created_by',
        'user_id',
        'source',
   
    ];
}
