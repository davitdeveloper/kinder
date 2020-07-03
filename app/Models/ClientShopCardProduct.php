<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientShopCardProduct extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id','product_id'];
}
