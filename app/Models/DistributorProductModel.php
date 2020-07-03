<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorProductModel extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['distributor_id','product_model_id','quantity','price'];


}
