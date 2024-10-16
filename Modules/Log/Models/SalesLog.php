<?php

namespace Modules\Log\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\Models\MenuItem;

class SalesLog extends Model
{
    use HasFactory;
    protected $table = 'sales_logs';
    protected $fillable = [
        'counter',
        'daily_log_id',
        'menu_item_id'
    ];
    protected $hidden = [
        'daily_log_id',
        'menu_item_id',
        'created_at',
        'updated_at'
    ];
    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
