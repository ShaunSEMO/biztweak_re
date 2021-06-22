<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    public function assessments()
    {
        return $this->hasMany('App\Models\assessment', 'category_id');
    }

    public function biz_scores()
    {
        return $this->hasMany('App\Models\biz_score', 'category_id');
    }

    public function cate_group()
    {
        return $this->belongsTo('App\Models\cate_groups', 'group_id');
    }

    public function field()
    {
        return $this->belongsTo('App\Models\cate_groups', 'group_id');
    }
}
