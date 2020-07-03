<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildrenAge extends Model
{
    protected $fillable = ['description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function babySitters()
    {
        return $this->belongsToMany(BabySitter::class,'baby_sitter_children_age','children_age_id','baby_sitter_id');
    }
}
