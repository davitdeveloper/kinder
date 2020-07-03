<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static User find($user_id)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public const ADMIN = 1;
    public const CUSTOMER = 2;
    public const DISTRIBUTOR = 3;
    public const COPYWRITER = 4;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'role_id', 'email', 'password','status','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return mixed
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrens()
    {
        return $this->hasMany(UserChildren::class);
    }

    /**
     * @return mixed
     */
    public function distributor()
    {
        return $this->HasOne(Distributor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shopProducts()
    {
        return $this->belongsToMany(Product::class,'client_shop_card_products','user_id','product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoriteProducts()
    {
        return $this->belongsToMany(ProductModel::class,'client_favorite_product_models','user_id','model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(){
        return $this->belongsToMany(Product::class,'distributor_product')->withPivot('quantity', 'price');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function myProducts()
    {
        return $this->hasMany(OwnProduct::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function babySitter()
    {
        return $this->hasOne(BabySitter::class);
    }

    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }
}
