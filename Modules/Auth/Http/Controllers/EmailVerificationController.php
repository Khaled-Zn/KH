<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Services\EmailVerificationService;

class EmailVerificationController extends Controller
{
    private $EmailVerificationService;
    public function __construct(EmailVerificationService $EmailVerificationService) {
        $this->EmailVerificationService = $EmailVerificationService;
    }
    public function VerifyEmail(Request $request) {

        $verify = $this->EmailVerificationService->VerifyEmail($request->verificationCode);
        return response()->json($verify[0],$verify[1]);

    }

}


