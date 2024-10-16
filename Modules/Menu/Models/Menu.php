<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\WorkSpace\Models\WorkSpace;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = [
        'work_space_id'
    ];
    protected $hidden = [
        'work_space_id',
        'created_at',
        'updated_at',
    ];
    public function workSpace()
    {
        return $this->belongsTo(WorkSpace::class);
    }
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
