<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assess_field extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasMany('App\Models\category', 'field_id');
    }
    public function field()
    {
        return $this->hasMany('App\Models\biz_score', 'field_id');
    }
}

