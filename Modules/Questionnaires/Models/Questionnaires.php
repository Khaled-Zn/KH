<?php

namespace Modules\Questionnaires\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shared\Models\Admin;
use Modules\Shared\Models\User;

class Questionnaires extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected $hidden = [
        'updated_at',
        
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function user_questionnaires()
    {
        return $this->belongsToMany(User::class,'user_questionnaires');
    }

}
