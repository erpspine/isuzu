<?php

namespace App\Models\gcaqueryitemtag;

use App\Models\gcaqueryitemtag\Traits\GcaQueryItemTagRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcaQueryItemTag extends Model
{
    use HasFactory,GcaQueryItemTagRelationship;
}
