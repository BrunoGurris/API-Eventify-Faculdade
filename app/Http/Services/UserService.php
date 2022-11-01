<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use Exception;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($request)
    {
        try {
            /* Verifica o nome completo */
            if(strlen($request->name) < 5) {
                return response()->json([
                    'message' => 'O nome completo deve ter no minino 5 digitos!'
                ], 400);
            }
            /* */

            /* Verifica o usuario */
            if(strlen($request->username) < 5) {
                return response()->json([
                    'message' => 'O usuario deve ter no minino 5 digitos!'
                ], 400);
            }
            /* */

            /* Verifica se o usaurio já existe */
            if(!is_null(User::where('username', $request->username)->first())) {
                return response()->json([
                    'message' => 'Este usuario já esta cadastrado!'
                ], 400);
            }
            /* */

            /* Verifica o email */
            if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'message' => 'Este email não é válido!'
                ], 400);
            }
            /* */

            /* Verifica se já existe um usuario com este email */
            if(!is_null(User::where('email', $request->email)->first())) {
                return response()->json([
                    'message' => 'Este email já esta cadastrado!'
                ], 400);
            }
            /* */

            /* Verifica a senha */
            if(strlen($request->password) < 6) {
                return response()->json([
                    'message' => 'A senha deve ter no minino 6 digitos'
                ], 400);
            }
            /* */

            /* Verifica se as senhas estão iguais */
            if($request->password != $request->password_confirm) {
                return response()->json([
                    'message' => 'As senhas não esta iguais'
                ], 400);
            }
            /* */

            return $this->userRepository->register($request);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o usuario!'
            ], 400);
        }
    }
}
