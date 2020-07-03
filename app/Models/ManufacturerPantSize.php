<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManufacturerPantSize extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manufacturer_id','size_id', 'waist','height','weight'
    ];

    public function manufacturer(){
        return $this->hasOne(Manufacturer::class,'id','manufacturer_id');
    }

    public function size(){
        return $this->hasOne(Size::class,'id','size_id');
    }
}
