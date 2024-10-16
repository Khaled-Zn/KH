<?php

namespace Modules\WorkSpace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Models\Client;
use Modules\Image\Models\Image;
use Modules\Log\Models\DailyLog;
use Modules\Menu\Models\Menu;
use Modules\Shared\Models\Admin;
use Modules\Traffic\Models\Traffic;

class WorkSpace extends Model
{
    use HasFactory;
    protected $fillable = [
    'name',
    'description',
    'phone_number',
    'address',
    'working_days',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];
    public function clients ()
    {
        return $this->hasMany(Client::class);
    }
    public function traffic()
    {
        return $this->hasOne(Traffic::class,'work_space_id');
    }
    public function dailyLogs ()
    {
        return $this->hasMany(DailyLog::class);
    }
    public function admins ()
    {
        return $this->hasMany(Admin::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class,'image_workspaces');
    }
    public function menu()
    {
        return $this->hasOne(Menu::class,'work_space_id');
    }
}
