<?php

namespace Modules\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Log\Models\Log;
use Modules\WorkSpace\Models\WorkSpace;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'clientable_id',
        'clientable_type',
        'work_space_id'
    ];
    public function logs ()
    {
        return $this->hasMany(Log::class);
    }
    public function clientable()
    {
        return $this->morphTo();
    }
    public function workSpace ()
    {
        return $this->belongsTo(WorkSpace::class);
    }
}
