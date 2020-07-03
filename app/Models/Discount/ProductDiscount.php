<?php

namespace App\Models\Discount;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $only)
 */
class ProductDiscount extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'start','end','percent'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
