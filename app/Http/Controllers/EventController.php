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


    public function get(Request $request)
    {
        try {
            if($request->my == true) {
                $user = User::findOrFail(Auth::id());

                $events = Event::where('user_id', $user->id)->orderBy('id', 'desc')->get();
                return response()->json($events, 200);
            }
            else
            {
                $events = Event::orderBy('id', 'desc')->get();
                return response()->json($events, 200);
            }
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


    public function delete($id)
    {
        try {
            $user = User::findOrFail(Auth::id());
            $event = Event::find($id);

            return $this->eventService->delete($event, $user);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível excluir o evento!'
            ], 400);
        }
    }
}
