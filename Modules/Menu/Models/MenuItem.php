<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = 'menu_items';
    protected $fillable = [
        'menu_id',
        'price',
        'name'
    ];
    protected $hidden = [
        'menu_id',
        'created_at',
        'updated_at',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
}
