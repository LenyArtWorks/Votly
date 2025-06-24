<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poll;

class Polls extends Seeder
{

    public function run()
    {
        Poll::create([
            'title' => 'Какая игра достойна звания “Игра года”?',
            'user_id' => 1,
            'status' => 'Активен',
            'category_id' => '3'
        ]);
        Poll::create([
            'title' => 'Какой фильм заслуживает оскара?',
            'user_id' => 2,
            'status' => 'Активен',
            'category_id' => '2'
        ]);
        Poll::create([
            'title' => 'Какой фастфуд вы выбираете?',
            'user_id' => 3,
            'status' => 'Активен',
            'category_id' => '4'
        ]);
        Poll::create([
            'title' => 'Куда бы вы поехали, если бы деньги не имели значения?',
            'user_id' => 4,
            'status' => 'Завершён',
            'category_id' => '5'
        ]);
        Poll::create([
            'title' => 'Кто выйграет чемпионат европы 2025?',
            'user_id' => 5,
            'status' => 'Активен',
            'category_id' => '6'
        ]);
        Poll::create([
            'title' => 'Какой тренд вам больше нравится?',
            'user_id' => 6,
            'status' => 'Завершён',
            'category_id' => '7'
        ]);
    }
}
