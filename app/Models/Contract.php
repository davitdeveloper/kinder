<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create($data)
 */
class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'document','name','status','date_start','date_end','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
