<?php

namespace App\Models;

use App\Models\LocalizedModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $only)
 */
class Size extends LocalizedModel
{
    public $timestamps = false;


    public const TOP = 'Top';
    public const PANT = 'Pant';
    public const SHOE = 'Shoe';
    public const ACCESSORY = 'Accessory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value','type','rang','sortable'
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function manufacturers($class)
    {
        if($class){
            return $this->hasMany($class);
        }
        return null;
    }

    public function manufacturerPantSizes()
    {
        return $this->hasMany(ManufacturerPantSize::class,'size_id','id');
    }

    public function manufacturerTopSizes()
    {
        return $this->hasMany(ManufacturerTopSize::class,'size_id','id');
    }

    public function manufacturerShoeSizes()
    {
        return $this->hasMany(ManufacturerShoeSize::class,'size_id','id');
    }

    public function manufacturerAccessorySizes()
    {
        return $this->hasMany(ManufacturerAccessorySize::class,'size_id','id');
    }
}
