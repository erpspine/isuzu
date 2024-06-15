<?php

namespace App\Models\qcoscontainemnt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\qcoscontainemnt\Traits\QcosContainmentRelationship;

class QcosContainment extends Model
{
    use HasFactory,QcosContainmentRelationship;
}
