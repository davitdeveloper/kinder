<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadHabit extends Model
{
    protected $fillable = ['description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function babySitters()
    {
        return $this->belongsToMany(BabySitter::class,'baby_sitter_bad_habit','bad_habit_id','baby_sitter_id');
    }
}
