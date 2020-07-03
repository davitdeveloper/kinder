<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{


    const ROLE_ADMIN = 1;

    const ROLE_CUSTOMER = 2;

    const ROLE_DISTRIBUTOR = 3;

    const ROLE_COPYWRITER = 4;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return mixed
     */
    public function user(){

        return $this->HasMany(User::class);
    }
}
