<?php

namespace Modules\Questionnaires\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shared\Models\User;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question','questionnaires_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'questionnaires_id'
    ];


    public function questionnaires()
    {
        return $this->belongsTo(Questionnaires::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function user_questions()
    {
        return $this->belongsToMany(User::class,'user_questions_answers');
    }
}
