<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    use HasFactory;

    public function assessment_q()
    {
        return $this->belongsTo('App\Models\assessment', 'assessment_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\category', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function biz_score()
    {
        return $this->belongsTo('App\Models\biz_score', 'biz_score_id');
    }

    public function biz_profile()
    {
        return $this->belongsTo('App\Models\biz_profile', 'biz_id');
    }
}
