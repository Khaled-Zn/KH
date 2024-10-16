<?php

namespace Modules\Log\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Models\Client;

class Log extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $fillable = [
        'daily_log_id',
        'client_id',
        'created_at'
    ];
    public function dailyLog ()
    {
        return $this->belongsTo(DailyLog::class);
    }
    public function client ()
    {
        return $this->belongsTo(Client::class);
    }
}
