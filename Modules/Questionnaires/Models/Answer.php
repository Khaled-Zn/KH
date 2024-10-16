<?php

namespace Modules\Questionnaires\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shared\Models\User;
use function Symfony\Component\String\b;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['answer','question_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'question_id'
    ];

    public function question()
    {
         return $this->belongsTo(Question::class);
    }
    public function user_answers()
    {
        return $this->belongsToMany(User::class,'user_questions_answers');
    }
}
