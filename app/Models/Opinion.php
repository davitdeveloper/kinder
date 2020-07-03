<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $fillable = ['user_id','text','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
