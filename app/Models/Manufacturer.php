<?php

namespace App\Models;

use App\Models\ManufacturerTopSize;
use App\Models\ManufacturerPantSize;
use App\Models\ManufacturerShoeSize;
use App\Models\ManufacturerAccessorySize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends LocalizedModel
{

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description','logo'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(ProductModel::class);
    }

    /**
     * @param $class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizes($class)
    {
        if($class){
            return $this->hasMany($class);
        }
        return null;
    }

}
