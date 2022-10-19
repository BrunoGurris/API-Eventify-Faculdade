<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['username', 'password']);

            if(!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Usuário ou senha estão incorretos!'
                ], 401);
            }

            return $this->respondWithToken($token);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível fazer o login!'
            ], 400);
        }
    }


    public function me()
    {
        return response()->json([
            auth()->user()
        ], 200);
    }


    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'message' => 'Deslogado com sucesso!'
            ], 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível deslogar!'
            ], 400);
        }

    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
