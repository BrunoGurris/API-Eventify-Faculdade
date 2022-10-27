<?php

namespace App\Http\Controllers;

use App\Http\Services\EventService;
use App\Models\Event;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }


    public function getAll()
    {
        try {
            $events = Event::orderBy('id', 'desc')->get();
            return response()->json($events, 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível carregar todos eventos!'
            ], 400);
        }
    }


    public function create(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::id());
            return $this->eventService->create($request, $user);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o evento!'
            ], 400);
        }
    }
}
