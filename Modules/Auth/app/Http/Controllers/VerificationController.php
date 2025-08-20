<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\SendVerificationRequest;

class VerificationController extends Controller {

    public function sendCode(SendVerificationRequest $request)
    {
        dd('now must register User');
    }

}
