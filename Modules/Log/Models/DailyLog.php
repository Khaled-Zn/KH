<?php

namespace Modules\Log\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\WorkSpace\Models\WorkSpace;

class DailyLog extends Model
{
    use HasFactory;
    protected $table = 'daily_logs';
    protected $fillable = [
        'work_space_id',
        'created_at'
    ];
    public function workSpace ()
    {
        return $this->belongsTo(WorkSpace::class);
    }
    public function logs ()
    {
        return $this->hasMany(Log::class);
    }
    public function salesLog ()
    {
        return $this->hasMany(SalesLog::class,'daily_log_id');
    }
}
