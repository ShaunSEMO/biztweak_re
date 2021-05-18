<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assessment extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->hasMany('App\Models\answer', 'assessment_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\category', 'category_id');
    }

    public function phase()
    {
        return $this->belongsTo('App\Models\phase', 'phase_id');
    }
}
