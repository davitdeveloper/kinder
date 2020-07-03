<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildrenAmount extends Model
{
    protected $fillable = ['description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function babySitters()
    {
        return $this->belongsToMany(BabySitter::class,'baby_sitter_children_amount','children_amount_id','baby_sitter_id');
    }
}
