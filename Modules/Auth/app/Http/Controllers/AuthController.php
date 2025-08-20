<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function checkUser(Request $request): JsonResponse
    {
        $contact = $request->input('contact');

        $user = User::where('email', $contact)
                        ->orWhere('phone', $contact)
                        ->exists();
        if ($user) {
            return response()->json('user exists');
        }

        return response()->json('user not found', 404);
    }
}
