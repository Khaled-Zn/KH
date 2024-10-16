<?php

namespace Modules\CompleteInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shared\Models\User;
use Modules\Unregistered\Models\Unregistered;

class Residence extends Model
{
    use HasFactory;
    protected $table = 'residences';
    protected $fillable = [
        'residence'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
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
