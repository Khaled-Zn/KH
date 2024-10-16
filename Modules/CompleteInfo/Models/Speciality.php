<?php

namespace Modules\CompleteInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shared\Models\User;

class Speciality extends Model
{
    use HasFactory;
    protected $table = 'specialities';
    protected $fillable = [
        'speciality'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function users()
    {
        return $this->morphMany(User::class, 'study');
    }
    public function unregistereds()
    {
        return $this->morphMany(User::class, 'study');
    }
}
