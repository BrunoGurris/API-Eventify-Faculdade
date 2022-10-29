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

            /* Verifica a descrição */
            if(!$request->description) {
                return response()->json([
                    'message' => 'Informe a descrição do evento!'
                ], 400);
            }
            /* */

            /* Verifica a data do dia do evento */
            if(!$request->date) {
                return response()->json([
                    'message' => 'Informe o dia e horario do evento!'
                ], 400);
            }
            /* */

            /* Verifica o CEP */
            if(strlen($request->zip_code) != 9) {
                return response()->json([
                    'message' => 'Informe o CEP corretamente!',
                ], 400);
            }
            /* */

            /* Verifica a rua */
            if(!$request->street) {
                return response()->json([
                    'message' => 'Informe a rua do evento!',
                ], 400);
            }
            /* */

            /* Verifica o numero */
            if(!$request->number) {
                return response()->json([
                    'message' => 'Informe o numero do evento!',
                ], 400);
            }
            /* */

            /* Verifica a cidade */
            if(!$request->city) {
                return response()->json([
                    'message' => 'Informe a cidade do evento!',
                ], 400);
            }
            /* */

            /* Verifica o estado */
            if(!$request->state || strlen($request->state) != 2) {
                return response()->json([
                    'message' => 'Informe o estado do evento!',
                ], 400);
            }
            /* */

            /* Verifica a imagem */
            $upload = null;
            if($request->hasFile('image')) {

                /* Verifica o tamanho da imagem */
                if(intval($request->file('image')->getSize() / 1024) > 10000) {
                    return response()->json([
                        'message' => 'Selecione uma imagem com até 10MB!',
                    ], 400);
                }
                /* */

                /* Verifica a extensão da imagem */
                if($request->image->extension() != 'jpeg' && $request->image->extension() != 'jpg' && $request->image->extension() != 'png') {
                    return response()->json([
                        'message' => 'O formato da imagem é inválido. Use apenas: JPEG, JPG, ou PNG!',
                    ], 400);
                }
                /* */

                /* Faz o upload e verifica se o uplaod foi feito */
                $upload = $request->file('image')->store('events');
                if(!$upload) {
                    return response()->json([
                        'message' => 'Falha ao fazer upload da imagem!',
                    ], 400);
                }
            }
            else
            {
                return response()->json([
                    'message' => 'Faça o upload de uma imagem para o evento!',
                ], 400);
            }
            /* */

            return $this->eventRepository->create($request, $user, $upload);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível criar o evento!'
            ], 400);
        }
    }

}
