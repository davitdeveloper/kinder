<?php

namespace App\Models;

use App\Models\Discount\ModelDiscount;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * @method static find($model_id)
 */
class ProductModel extends LocalizedModel
{
    use HasJsonRelationships;

    public const MAN = 'man';
    public const WOMEN = 'women';
    public const UNISEX = 'unisex';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'short_description', 'long_description','alias' , 'status','top_status','hot_status','manufacturer_id',
        'bulk_quantity','bulk_percent','offerable','category_ids','old_price','price','main_image','type','new_status','text',
        'gender','sub_title','watermark'
    ];

    protected $casts = [
        'category_ids' => 'json',
    ];


    /**
     * @return \Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson
     */
    public function categories()
    {
        return $this->belongsToJson(ProductCategory::class, 'category_ids');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class,'model_id','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function distributors(){
        return $this->belongsToMany(Distributor::class,'distributor_product_models','model_id','distributor_id')
            ->withPivot('quantity', 'price');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
       return $this->belongsToMany(User::class,'client_favorite_product_models','model_id','user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function discount()
    {
        return $this->hasOne(ModelDiscount::class,'model_id','id');
    }



    public function scopeOrderByPrice($query, $order = 'asc')
    {
//        $query->join('product_options', 'product_options.product_id', '=', 'products.id')
//            ->orderBy('product_options.price', $order)
//            ->select('products.*');
        $query->orderBy('product_models.price', $order)
            ->select('product_models.*');
    }


}
