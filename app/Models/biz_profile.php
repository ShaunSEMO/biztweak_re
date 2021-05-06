<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class biz_profile extends Model
{
    use HasFactory;

    public function biz_owner()
    {
        return $this->belongsTo('App\Models\User');
    }
}
