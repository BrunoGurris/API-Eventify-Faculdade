<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $event = new Event();
        $event->user_id = 1;
        $event->name = 'Encontro de carros importados';
        $event->zip_code = '18074658';
        $event->street = 'Rua Lucio Leme';
        $event->number = '132';
        $event->neighborhood = 'São Guilherme';
        $event->city = 'Sorocaba';
        $event->state = 'SP';
        $event->description = 'Aqui uma breve descrição sobre o evento. By: Seeder';
        $event->save();
    }
}
