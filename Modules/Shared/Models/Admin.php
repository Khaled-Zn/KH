<?php

namespace Modules\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\WorkSpace\Models\WorkSpace;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'work_space_id',
    ];


    protected $hidden = [
        //'created_at',
        'updated_at',
        'password',
        'remember_token',

    ];
    public function workSpace ()
    {
        return $this->belongsTo(WorkSpace::class);
    }

}
