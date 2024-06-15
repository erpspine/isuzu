<?php

namespace App\Models\gcaqueryitemtag\Traits;

use App\Models\gcaqueryitems\GcaQueryItem;

/**
 * Class GcaQueryItemRelationship
 */
trait GcaQueryItemTagRelationship
{



    public function gcaqueryitems()
    {
        return $this->hasOne(GcaQueryItem::class,'id','gca_query_item_id');
    }
 

  



}
