<?php


namespace Modules\Questionnaires\Service;


use Modules\Questionnaires\Models\Answer;
use Modules\Questionnaires\Models\Question;
use Modules\Questionnaires\Models\Questionnaires;
use Modules\Shared\Models\User;
use Exception;
class QuestionnairesService
{

    public function create($request) {

        $col1 = collect($request->all()['questions']);
        $plu1 = $col1->pluck('question');
        $count_q = sizeof($plu1);

        for ($k = 0; $k < $count_q; $k++) {
            $plu = collect($request->questions[$k]['answers'])->pluck('answer');
            $plu2[$k]=$plu;
        }

        $questionnaire = Questionnaires::create([
            'title' => $request['title']
        ]);
        $questionsWithAnswer = [];
        for ($n = 0; $n < $count_q; $n++) {
            $a1 = $plu1[$n];
            $count_a = sizeof($plu2[$n]);
            $questions = Question::create([
                'question' => $a1,
                'questionnaires_id' => $questionnaire->id
            ]);
            $answers = [];
            for ($m = 0; $m < $count_a; $m++) {
                $a2 = $plu2[$n][$m];
                $answer = Answer::create([
                    'answer' => $a2,
                    'question_id' => $questions->id
                ]);
                
                $answers[] = $answer;
            }
            $questions->answers = $answers;
            $questionsWithAnswer[] = $questions;
        }
        $questionnaire->questions = $questionsWithAnswer;
        $users = User::all();
        $questionnaire->user_questionnaires()->attach($users);
        return[$questionnaire,200];
    }

    public function getAll() {
        $questionnaires = Questionnaires::get();
        return [$questionnaires,200];
    }

    public function getByid($id) {
        $questionnaires = Questionnaires::where('questionnaires.id',$id)
            ->with('questions.answers')
            ->first();
        if(!$questionnaires) 
            throw new Exception('There is no questionnaire with id' .$id, 404);
        $allAnswers = $questionnaires->questions->pluck('answers');
        $sumCounterAnswers = null;
        foreach($allAnswers as $answers) {
            $sumCounterAnswers = $answers->sum('count');
            foreach($answers as $answer) {
                if($answer->count)  
                    $answer->percent =  floor(($answer->count / $sumCounterAnswers) * 100); 
                else $answer->percent = 0;
            }
        }
        return [$questionnaires,200];
    }

    public function delete($id) {
        Questionnaires::where('id',$id)->delete();
        return ['',200];
    }
}
