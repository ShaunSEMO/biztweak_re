<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phase extends Model
{
    use HasFactory;

    public function biz_profile()
    {
        return $this->hasMany('App\Models\biz_profile', 'phase_id');
    }
}
