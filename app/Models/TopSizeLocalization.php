<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopSizeLocalization extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'size','lang'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
