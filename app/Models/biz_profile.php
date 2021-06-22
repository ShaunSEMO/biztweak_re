<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class biz_profile extends Model
{
    use HasFactory;

    public function biz_owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function phase()
    {
        return $this->belongsTo('App\Models\phase', 'phase_id');
    }

    public function field_scores()
    {
        return $this->hasMany('App\Models\field_score', 'biz_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\answer', 'biz_id');
    }

    public function biz_scores()
    {
        return $this->hasMany('App\Models\biz_score', 'biz_id');
    }
}
