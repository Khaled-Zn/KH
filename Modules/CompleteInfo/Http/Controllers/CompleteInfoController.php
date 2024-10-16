<?php

namespace Modules\CompleteInfo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CompleteInfo\Http\Requests\CreateCompleteInfoStepTwoRequest;
use Modules\CompleteInfo\Service\CompleteInfoService;
use Modules\CompleteInfo\Http\Requests\CreateCompleteInfoStepOneRequest;

class CompleteInfoController extends Controller
{
    private CompleteInfoService $CompleteInfoService;
    public function __construct(CompleteInfoService $CompleteInfoService )
    {
        $this->CompleteInfoService = $CompleteInfoService;
    }
    public function CompleteInfoStepOne(CreateCompleteInfoStepOneRequest $request) {
        return response()->json($this->CompleteInfoService->CompleteInfoStepOne($request), 200);
    }
    public function CompleteInfoStepTwo(CreateCompleteInfoStepTwoRequest $request) {
        return response()->json($this->CompleteInfoService->CompleteInfoStepTwo($request), 200);
    }
    public function CompleteInfoStage() {
        return response()->json($this->CompleteInfoService->CompleteInfoStage(), 200);
    }
}
