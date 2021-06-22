<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class field_score extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function biz_profile()
    {
        return $this->belongsTo('App\Models\biz_profile', 'biz_id');
    }
}
