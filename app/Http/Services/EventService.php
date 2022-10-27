<?php

namespace App\Http\Services;

use App\Http\Repositories\EventRepository;
use Exception;

class EventService
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }


    public function create($request, $user)
    {
        try {
            /* Verifica o nome do evento */
            if(strlen($request->name) < 5) {
                return response()->json([
                    'message' => 'O nome do evento deve ter no minino 5 digitos!'
                ], 400);
            }
            /* */

            return $this->eventRepository->create($request, $user);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o evento!'
            ], 400);
        }
    }

}
