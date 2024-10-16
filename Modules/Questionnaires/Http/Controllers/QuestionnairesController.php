<?php

namespace Modules\Questionnaires\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Questionnaires\Http\Requests\CreateQuestionnairesRequest;
use Modules\Questionnaires\Models\Questionnaires;
use Modules\Questionnaires\Service\QuestionnairesService;

class QuestionnairesController extends Controller
{
    private $QuestionnairesService;
    public function __construct(QuestionnairesService $QuestionnairesService)
    {
        $this->QuestionnairesService=$QuestionnairesService;
    }

    public function create(CreateQuestionnairesRequest $request)
    {
        $create = $this->QuestionnairesService->create($request);
        return response()->json($create[0] ,$create[1]);
    }

    public function getAll()
    {
        $getAll = $this->QuestionnairesService->getAll();
        return response()->json($getAll[0] ,$getAll[1]);

    }

    public function getByid($id)
    {
        $getByid = $this->QuestionnairesService->getByid($id);
        return response()->json($getByid[0] ,$getByid[1]);
    }

    public function delete($id)
    {
        $delete = $this->QuestionnairesService->delete($id);
        return response()->json($delete[0] ,$delete[1]);

    }
}

