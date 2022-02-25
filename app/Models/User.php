<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'balance'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            LogSystem::addToLog('create user Log.', $model, 'created_user');
        });
        static::updated(function ($model) {
            LogSystem::addToLog('Update user Log.', $model, 'updated_user');
        });
        static::deleted(function ($model) {
            LogSystem::addToLog('delete user Log.', $model, 'deleted_user');
        });
    }

    public function setPasswordAttribute($input)
    {
        $this->attributes['password'] = $input && Hash::needsRehash($input) ? Hash::make($input) : $input;
    }

    public function getCreatedAtAttribute($input)
    {
        return $input ? Carbon::parse($input)->diffForHumans() : $input;
    }
}
