<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'BRUNO ALEXANDRE';
        $user->email = 'bruno@gmail.com';
        $user->username = 'bruno';
        $user->password = Hash::make('123');
        $user->save();
    }
}
