<?php

namespace Modules\Traffic\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\WorkSpace\Models\WorkSpace;

class Traffic extends Model
{
    use HasFactory;
    protected $table = 'traffic';
    protected $fillable = [
        'work_space_id',
        'count',
        'full'
    ];
    public function workSpace ()
    {
        return $this->belongsTo(WorkSpace::class);
    }
}
