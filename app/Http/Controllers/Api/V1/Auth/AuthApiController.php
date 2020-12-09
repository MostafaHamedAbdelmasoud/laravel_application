<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|unique:users,phone_number',
        ]);


        $user = User::create([
            'phone_number' => $request->phone_number,
        ]);

        $token = $user->createToken($user->phone_number . '-' . now());

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|exists:users,phone_number',
        ]);
        $user = User::where('phone_number',$request->phone_number)->first();

        if ($user) {

            $token = $user->createToken($user->phone_number . '-' . now());

            return response()->json([
                'token' => $token->accessToken
            ]);
        }

        return response()->json([
            'message' => 'البيانات خاطئة'
        ]);
    }
}
