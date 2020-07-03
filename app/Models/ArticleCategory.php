<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends LocalizedModel
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'image', 'alias' , 'status'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
