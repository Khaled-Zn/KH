<?php

namespace Modules\Questionnaires\Http\Controllers;

use Modules\Questionnaires\Http\Requests\AnswerRequest;
use Illuminate\Routing\Controller;
use Modules\Questionnaires\Service\UserQuestionnairesService;

class UserQuestionnairesController extends Controller
{
    private $userQuestionnairesService;
    public function __construct(UserQuestionnairesService $userQuestionnairesService)
    {
        $this->userQuestionnairesService=$userQuestionnairesService;
    }

    public function getAll()
    {
        $getAll = $this->userQuestionnairesService->getAll();
        return response()->json($getAll[0] ,$getAll[1]);

    }

    public function getByid($id)
    {
        $getByid = $this->userQuestionnairesService->getByid($id);
        return response()->json($getByid[0] ,$getByid[1]);
    }

    public function answer(AnswerRequest $request)
    {
        $answer = $this->userQuestionnairesService->answer($request);
        return response()->json($answer[0] ,$answer[1]);

    }
}
