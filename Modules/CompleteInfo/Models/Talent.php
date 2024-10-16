<?php

namespace Modules\CompleteInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shared\Models\User;
use Modules\Unregistered\Models\Unregistered;

class Talent extends Model
{
    use HasFactory;
    protected $table = 'talents';
    protected $fillable = [
        'talent'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];
    public function users ()
    {
        return $this->hasMany(User::class);
    }
    public function unregistereds ()
    {
        return $this->hasMany(Unregistered::class);
    }
}
