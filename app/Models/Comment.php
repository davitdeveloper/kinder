<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id','article_id','text'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function article(){
        return $this->belongsTo(Article::class,'article_id','id');
    }

    public function replies(){
        return $this->hasMany(Reply::class,'comment_id','id');
    }
}
