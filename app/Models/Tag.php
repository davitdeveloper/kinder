<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends LocalizedModel
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
