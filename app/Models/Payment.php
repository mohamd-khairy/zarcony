<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'to_user_id',
        'transaction_number',
        'status',
        'action_at'
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            LogSystem::addToLog('create Payment Log.', $model, 'created_payment');
        });
        static::updated(function ($model) {
            LogSystem::addToLog('Update Payment Log.', $model, 'updated_payment');
        });
        static::deleted(function ($model) {
            LogSystem::addToLog('delete Payment Log.', $model, 'deleted_payment');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function getCreatedAtAttribute($input)
    {
        return $input ? Carbon::parse($input)->diffForHumans() : $input;
    }
}
