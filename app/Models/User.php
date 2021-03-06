<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     *
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'profile_picture',
        'email',
        'password',
        'user_type',
        'biz_code',
        'is_admin',
        'designation',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function biz_profiles()
    {
        return $this->hasMany('App\Models\biz_profile', 'user_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\answer', 'user_id');
    }

    public function biz_scores()
    {
        return $this->hasMany('App\Models\biz_score', 'user_id');
    }

    public function field_scores()
    {
        return $this->hasMany('App\Models\field_score', 'user_id');
    }
    
}
