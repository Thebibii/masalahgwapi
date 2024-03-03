<?php

namespace App\Http\Controllers;

use App\Http\Helpers\AnonymousGenerator;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\ProfilResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function store(UserRegisterRequest $request)
    {
        $data = $request->validated();

        if (User::where('name', $data['name'])->count() == 1) {
            // ada di database?
            throw new HttpResponseException(response([
                "errors" => [
                    "name" => [
                        "Name already registered"
                    ]
                ]
            ], 409));
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->anonymous = AnonymousGenerator::generateUniqueCode();
        $user->id_role = 2;
        try {

            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Success created user",
                'error' => $e->getMessage()
            ]);
        }
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function profileUser($name)
    {
        $user = User::with(["post" => function ($query) {
            $query->where('anonymous', false)->get();
        }])->where('name', $name)->first();

        // ->first();
        // dd($user);
        return new ProfilResource($user);
    }

    public function updateUser(UserUpdateRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        // $user->password = Hash::make($data['password']);
        $user->update($data);
        return new UserResource($user);
    }

    public function getUser()
    {
        $data = Auth::user();
        $data->load('role');
        // $data->load('notification');

        return new UserResource($data);
    }
}
