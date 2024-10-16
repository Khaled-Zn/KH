<?php

namespace Modules\CompleteInfo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CompleteInfo\Http\Requests\CreateCompleteInfoStepOneRequest;
use Modules\CompleteInfo\Service\CompleteInfoService;
use Modules\CompleteInfo\Service\InfoService;

class InfoController extends Controller
{
    private InfoService $InfoService;
    public function __construct(InfoService $InfoService)
    {
        $this->InfoService = $InfoService;
    }
    public function Residences() {
        return response()->json($this->InfoService->Residences(), 200);
    }
    public function Specialities() {
        return response()->json($this->InfoService->Specialities(), 200);
    }
    public function Talents() {
        return response()->json($this->InfoService->Talents(), 200);
    }
    public function Educations() {
        return response()->json($this->InfoService->Educations(), 200);
    }
}
