<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnProductImage extends Model
{
    protected $fillable = ['own_product_id','image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(OwnProduct::class,'own_product_id', 'id');
    }
}
