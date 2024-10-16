<?php

namespace Modules\CompleteInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shared\Models\User;

class Education extends Model
{
    use HasFactory;
    protected $table = 'educations';
    protected $fillable = [
        'education'
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
