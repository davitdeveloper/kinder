<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientFavoriteProductModel extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id','model_id'];
}
