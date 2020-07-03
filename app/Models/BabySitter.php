<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BabySitter extends Model
{
    protected $fillable = ['user_id', 'full_name','birthday','family_status', 'city', 'phone','personal_qualities'];

    //*

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiences()
    {
        return $this->hasMany(Experience::class,'baby_sitter_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educations()
    {
        return $this->hasMany(Education::class,'baby_sitter_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workTypes()
    {
        return $this->belongsToMany(WorkType::class,'baby_sitter_work_type','baby_sitter_id','work_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childrenAges()
    {
        return $this->belongsToMany(ChildrenAge::class,'baby_sitter_children_age','baby_sitter_id','children_age_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childrenAmounts()
    {
        return $this->belongsToMany(ChildrenAmount::class,'baby_sitter_children_amount','baby_sitter_id','children_amount_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ownLanguages()
    {
        return $this->belongsToMany(OwnLanguage::class,'baby_sitter_own_language','baby_sitter_id','own_language_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function badHabits()
    {
        return $this->belongsToMany(BadHabit::class,'baby_sitter_bad_habit','baby_sitter_id','bad_habit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class,'baby_sitter_skill','baby_sitter_id','skill_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regions()
    {
        return $this->belongsToMany(Cities::class,'baby_sitter_cities','baby_sitter_id','region_id');
    }
}
