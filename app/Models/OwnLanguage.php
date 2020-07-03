<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnLanguage extends Model
{
    protected $fillable = ['description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function babySitters()
    {
        return $this->belongsToMany(BabySitter::class,'baby_sitter_own_language','own_language_id','baby_sitter_id');
    }
}
