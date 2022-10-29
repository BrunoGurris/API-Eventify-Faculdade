<?php

namespace App\Http\Repositories;

use App\Models\Event;
use Exception;

class EventRepository
{
    public function create($request, $user, $upload)
    {
        try {
            $event = new Event();
            $event->user_id = $user->id;
            $event->name = $request->name;
            $event->description = $request->description;
            $event->date = date('Y-m-d', strtotime($request->date)).' '.date('H:i:s', strtotime($request->date));
            $event->zip_code = $request->zip_code;
            $event->street = $request->street;
            $event->number = $request->number;
            $event->neighborhood = $request->neighborhood;
            $event->city = $request->city;
            $event->state = $request->state;
            $event->image = $upload;
            $event->save();

            return response()->json($event, 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o evento!'
            ], 400);
        }
    }
}
