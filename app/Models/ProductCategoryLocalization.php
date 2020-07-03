<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryLocalization extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title','description','lang'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
