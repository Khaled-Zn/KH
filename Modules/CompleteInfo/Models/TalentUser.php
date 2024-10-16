<?php

namespace Modules\CompleteInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TalentUser extends Model
{
    use HasFactory;
    protected $table = 'talent_user';
    protected $fillable = [
        'user_id',
        'talent_id'
    ];
}
