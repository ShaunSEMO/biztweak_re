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
}
