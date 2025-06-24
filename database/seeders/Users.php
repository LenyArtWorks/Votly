<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'login' => 'User1',
            'password' => Hash::make(111),
            'email' => 'User1@gmail.com',
            'role' => 'user',
        ]);
        User::create([
            'login' => 'User2',
            'password' => Hash::make(222),
            'email' => 'User2@gmail.com',
            'role' => 'user',
        ]);
        User::create([
            'login' => 'User3',
            'password' => Hash::make(333),
            'email' => 'User3@gmail.com',
            'role' => 'user',
        ]);
        User::create([
            'login' => 'User4',
            'password' => Hash::make(444),
            'email' => 'User4@gmail.com',
            'role' => 'user',
        ]);
        User::create([
            'login' => 'User5',
            'password' => Hash::make(555),
            'email' => 'User5@gmail.com',
            'role' => 'user',
        ]);
        User::create([
            'login' => 'User6',
            'password' => Hash::make(666),
            'email' => 'User6@gmail.com',
            'role' => 'user',
        ]);
    }
}
