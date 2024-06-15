<?php

namespace App\Models\tooljoint;

use App\Models\tooljoint\Traits\ToolJointRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolJoint extends Model
{
    use HasFactory,ToolJointRelationship;
}
