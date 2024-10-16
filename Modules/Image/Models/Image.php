<?php

namespace Modules\Image\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path','type_id'];
    protected $hidden = ['created_at',
    'updated_at'];
    
}
