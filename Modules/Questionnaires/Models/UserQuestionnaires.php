<?php

namespace Modules\Questionnaires\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuestionnaires extends Model
{
    use HasFactory;

    protected $fillable = ['status'];


}
