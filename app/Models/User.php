<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens, Notifiable;
    public $timestamp = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'user_type',
        'email',
        'boss_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userType() {
        return $this->belongsTo(UserType::class, 'user_type', 'id');
    }

    public function blogs() {
        return $this->hasMany(Blog::class, 'created_by', 'id');
    }

    public function userBoss() {
        return $this->hasOne(User::class, 'id', 'boss_id');
    }

    public function usersBossList() {
        return $this->hasMany(User::class, 'boss_id', 'id');
    }
}
