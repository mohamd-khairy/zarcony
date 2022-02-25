<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject', 'query_request', 'query_type', 'transaction_number',
        'url', 'method', 'ip', 'agent', 'user_id'
    ];


    public static function addToLog($subject, $queryRequest, $queryType)
    {
        if ($queryRequest != NULL) {
            $queryRequest = json_encode($queryRequest);
        }

        $log = [];
        $log['subject'] = $subject;
        $log['query_request'] = $queryRequest;
        $log['query_type'] = $queryType;
        $log['url'] = request()->fullUrl();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 0;

        static::create($log);

        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($input)
    {
        return $input ? Carbon::parse($input)->diffForHumans() : $input;
    }
}
