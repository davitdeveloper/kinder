<?php

namespace App\Models;

use App\Models\Discount\ProductDiscount;
use App\Models\Size;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Product create(array $attributes)
 * @method static find($model_id)
 */
class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity','price','SCU','old_price',
        'product_model_id','color_id','size_id','status','text','min_offer_count'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo(Size::class,'size_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo(ProductModel::class,'model_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function discount()
    {
        return $this->hasOne(ProductDiscount::class);
    }

    public function distributors(){
        return $this->belongsToMany(User::class,'distributor_product','product_id','user_id')->withPivot('quantity', 'price');
    }


    public function shopUsers()
    {
        return $this->belongsToMany(User::class,'client_shop_card_products','product_id','user_id');
    }
}
