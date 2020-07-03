<?php

namespace App\Models\Discount;

use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $only)
 * @method static find(int $id)
 */
class ModelDiscount extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id', 'start','end','percent'
    ];

    public function model()
    {
        return $this->belongsTo(ProductModel::class);
    }
}
