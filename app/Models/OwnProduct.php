<?php

namespace App\Models;

use App\Http\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class OwnProduct extends Model
{
    use HasJsonRelationships,FullTextSearch;
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'city_id' , 'category_ids', 'title', 'description','price', 'phone','manufacturer', 'color', 'condition','alias','status','created_at'];

    protected $casts = [
        'category_ids' => 'json',
    ];

    protected $searchable = [
        'title',
        'description',
        'manufacturer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(OwnProductImage::class, 'own_product_id','id');
    }

    /**
     * @return \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
     */
    public function categories()
    {
        return $this->belongsToJson(ProductCategory::class, 'category_ids');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(Cities::class);
    }

    public function scopeOrderByPrice($query, $order = 'asc')
    {
        $query->orderBy('own_products.price', $order)
            ->select('own_products.*');
    }
}
