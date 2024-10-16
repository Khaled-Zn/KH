<?php

namespace Modules\Unregistered\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Models\Client;
use Modules\CompleteInfo\Models\Residence;
use Modules\CompleteInfo\Models\Talent;

class Unregistered extends Model
{
    use HasFactory;
    protected $table = 'unregistereds';
    protected $fillable = [
        'number',
        'email',
        'full_name',
        'username',
        'age',
        'residence_id',
        'study_id',
        'study_type',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'residence_id',
        'study_id',
        'study_type'

    ];
    public function residence ()
    {
        return $this->belongsTo(Residence::class);
    }
    public function talents ()
    {
        return $this->belongsToMany(Talent::class);
    }
    public function study()
    {
        return $this->morphTo();
    }
    public function clients()
    {
        return $this->morphMany(Client::class, 'clientable');
    }
}
