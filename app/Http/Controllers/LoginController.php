<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->validated();

        $data = User::firstWhere("email", $request->email);

        if (!$data || !Hash::check($request->password, $data->password)) {
            return response()->json([
                'message' => 'NotFound'
            ], 404);
        }

        $token = $data->createToken("sanctum_token")->plainTextToken;

        return response()->json([
            "message" => 'Succes Logged',
            "token" => $token
        ], 200);
    }

    public function destroy()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Succes Logout',
            'data' => null
        ], 200);
    }
}
