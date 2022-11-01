<?php

namespace App\Http\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function register($request)
    {
        try {
            $user = new User();
            $user->name = strtoupper($request->name);
            $user->username = strtolower($request->username);
            $user->email = strtolower($request->email);
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json($user, 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o usuario!'
            ], 400);
        }
    }
}
