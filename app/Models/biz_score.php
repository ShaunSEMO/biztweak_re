<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class biz_score extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\category', 'category_id');
    }

    public function field()
    {
        return $this->belongsTo('App\Models\assess_field', 'field_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\answer', 'biz_score_id');
    }
}
