<?php

namespace Modules\Unregistered\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TalentUnregistered extends Model
{
    use HasFactory;
    protected $table = 'talent_unregistered';
    protected $fillable = [
        'unregistered_id',
        'talent_id'
    ];
}
