<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use App\Models\Event;
use App\Models\EventUser;
use Exception;
use Illuminate\Support\Facades\Storage;

class EventRepository
{
    public function getByID($event)
    {
        try {
            return response()->json($event, 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível carregar o evento!'
            ], 400);
        }
    }


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

            return response()->json($event, 201);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o evento!'
            ], 400);
        }
    }


    public function delete($event)
    {
        try {
            Storage::delete($event->image);
            $event->delete();

            return response()->json($event, 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível excluir o evento!'
            ], 400);
        }
    }


    public function comment($event, $request, $user)
    {
        try {
            $comment = new Comment();
            $comment->event_id = $event->id;
            $comment->user_id = $user->id;
            $comment->message = $request->message;
            $comment->save();

            return response()->json($comment, 201);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o comentário!'
            ], 400);
        }
    }


    public function participate($event, $user)
    {
        try {
            $eventUser = new EventUser();
            $eventUser->event_id = $event->id;
            $eventUser->user_id = $user->id;
            $eventUser->save();

            return response()->json($event, 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível participar do evento!'
            ], 400);
        }
    }
}
