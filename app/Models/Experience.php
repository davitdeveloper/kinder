<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['baby_sitter_id','start','end','description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function baby_sitter(){
        return $this->belongsTo(BabySitter::class,'baby_sitter_id','id');
    }
}
