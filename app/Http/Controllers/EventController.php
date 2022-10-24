<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
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
}
