<?php


namespace Modules\Questionnaires\Service;



use Illuminate\Support\Facades\DB;
use Modules\Questionnaires\Models\Answer;
use Modules\Questionnaires\Models\Question;
use Modules\Questionnaires\Models\Questionnaires;
use Modules\Questionnaires\Models\UserQuestionnaires;
use Exception;
use Modules\Questionnaires\Enums\Status;

class UserQuestionnairesService {

    public function getAll() {
        $user = auth()->user()->id;
        $userQuestionnaires = UserQuestionnaires::where('user_id','=',$user)
            ->get(['questionnaires_id','status']);
        $questionnaires = Questionnaires::whereIn('id', $userQuestionnaires->pluck('questionnaires_id'))
            ->get();
        for ($questionnaire = 0; $questionnaire < count($questionnaires) ; $questionnaire++) { 
            $questionnaires[$questionnaire]->status = $userQuestionnaires[$questionnaire]->status ? Status::answered->value : Status::not_answered->value;
        }
        return [$questionnaires,200];
    }

    public function getByid($id) {
        $user = auth()->user()->id;
        $questionnaires = Questionnaires::where('questionnaires.id',$id)
        ->with('questions.answers')
        ->first();
        if(!$questionnaires) 
            throw new Exception('There is no questionnaire with id' .$id, 404);
        $query = UserQuestionnaires::where([
            'user_id' => $user,
            'questionnaires_id' => $id
        ])->first();
        $col1 = collect($questionnaires->questions);
        $allAnswers = $col1->pluck('answers');
        foreach($allAnswers as $answers) {
            foreach($answers as $answer) {
                unset($answer->count);
            }
        }
        if($query->status == 0)
        {
            $questionnaires->status = Status::not_answered->value;
            return [$questionnaires,200];
        }

        if($query->status == 1)
        {
            $questionnaires->status = Status::answered->value;
            $plu1 = $col1->pluck('id');
            $useranswers = DB::table('user_questions_answers')
                ->where('user_id','=',$user)
                ->whereIn('question_id',$plu1)
                ->get(['answer_id as answer']);
            for ($question = 0; $question < count($useranswers) ; $question++) { 
                $questionnaires->questions[$question]->user_answer = $useranswers[$question]->answer;
            }
            return [$questionnaires,200];
        }
    }

    public function answer($request) {
        $user = auth()->user()->id;
        $answers = $request['answers'];
        Answer::whereIn('id',$answers)
            ->update(['count' => Answer::raw('count + 1')]);
        $questions = Answer::whereIn('id',$answers)
            ->pluck('question_id');
        $questionnaire = Question::whereIn('id',$questions)
            ->pluck('questionnaires_id');
        $questionnaire_id = $questionnaire[0];
        $count_a = sizeof($answers);
        for ($n = 0; $n < $count_a; $n++) {
            $question = $questions[$n];
            $answer = $answers[$n];
            DB::table('user_questions_answers')->insert([
                    'user_id' => $user,
                    'question_id' => $question,
                    'answer_id' => $answer
                ]
            );

        }
        UserQuestionnaires::where([
           'user_id' => $user,
           'questionnaires_id' => $questionnaire_id
        ])->update(['status' => 1]);
        $questionnaires = Questionnaires::where('questionnaires.id',$questionnaire_id)
        ->with('questions.answers')
        ->first();
        $questionnaires->status = Status::answered->value;
        $col1 = collect($questionnaires->questions);
        $plu1 = $col1->pluck('id');
        $useranswers = DB::table('user_questions_answers')
            ->where('user_id','=',$user)
            ->whereIn('question_id',$plu1)
            ->get(['answer_id as answer']);
        $allAnswers = $col1->pluck('answers');
        foreach($allAnswers as $answers) {
            foreach($answers as $answer) {
                unset($answer->count);
            }
        }
        for ($question =0; $question < count($useranswers) ; $question++) { 
            $questionnaires->questions[$question]->user_answer = $useranswers[$question]->answer;
        }
        return [$questionnaires,200];
    }
}
