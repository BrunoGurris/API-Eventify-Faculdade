<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        try {
            return $this->userService->register($request);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o usuario!'
            ], 400);
        }
    }
}
