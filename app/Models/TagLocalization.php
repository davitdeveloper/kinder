<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagLocalization extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name','lang','tag_id'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Tag::class);
    }
}
