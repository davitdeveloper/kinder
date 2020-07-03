<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChildren extends Model
{
    protected $fillable = [
        'name', 'birthday', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
