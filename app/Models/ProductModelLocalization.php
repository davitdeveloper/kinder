<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModelLocalization extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title', 'short_description', 'long_description','lang'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productModel()
    {
        return $this->belongsTo(ProductModel::class);
    }
}
