<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option;

class Options extends Seeder
{

    public function run()
    {
        Option::create(
            [
                'poll_id' => 1,
                'text' => 'Baldur’s Gate 3'
            ]
        );
        Option::create(
            [
                'poll_id' => 1,
                'text' => 'The Legend of Zelda: Tears of the Kingdom'
            ]
        );
        Option::create(
            [
                'poll_id' => 1,
                'text' => 'Starfield'
            ]
        );
        Option::create(
            [
                'poll_id' => 1,
                'text' => 'Hogwarts Legacy'
            ]
        );
        Option::create(
            [
                'poll_id' => 1,
                'text' => 'Cyberpunk 2077: Phantom Liberty'
            ]
        );

        Option::create(
            [
                'poll_id' => 2,
                'text' => 'Оппенгеймер'
            ]
        );
        Option::create(
            [
                'poll_id' => 2,
                'text' => 'Барби'
            ]
        );
        Option::create(
            [
                'poll_id' => 2,
                'text' => 'Киллеры цветочной луны'
            ]
        );
        Option::create(
            [
                'poll_id' => 2,
                'text' => 'Бедные-несчастные'
            ]
        );
        Option::create(
            [
                'poll_id' => 2,
                'text' => 'Мой вариант'
            ]
        );

        Option::create(
            [
                'poll_id' => 3,
                'text' => 'Бургеры'
            ]
        );
        Option::create(
            [
                'poll_id' => 3,
                'text' => 'Пицца'
            ]
        );
        Option::create(
            [
                'poll_id' => 3,
                'text' => 'Тако'
            ]
        );
        Option::create(
            [
                'poll_id' => 3,
                'text' => 'Суши'
            ]
        );
        Option::create(
            [
                'poll_id' => 3,
                'text' => 'Салаты'
            ]
        );

        Option::create(
            [
                'poll_id' => 4,
                'text' => 'Мальдивы'
            ]
        );
        Option::create(
            [
                'poll_id' => 4,
                'text' => 'Япония'
            ]
        );
        Option::create(
            [
                'poll_id' => 4,
                'text' => 'Италия'
            ]
        );
        Option::create(
            [
                'poll_id' => 4,
                'text' => 'Исландия'
            ]
        );
        Option::create(
            [
                'poll_id' => 4,
                'text' => 'Космос'
            ]
        );

        Option::create(
            [
                'poll_id' => 5,
                'text' => 'Франция'
            ]
        );
        Option::create(
            [
                'poll_id' => 5,
                'text' => 'Англия'
            ]
        );
        Option::create(
            [
                'poll_id' => 5,
                'text' => 'Германия'
            ]
        );
        Option::create(
            [
                'poll_id' => 5,
                'text' => 'Испания'
            ]
        );
        Option::create(
            [
                'poll_id' => 5,
                'text' => 'Непонятно'
            ]
        );

        Option::create(
            [
                'poll_id' => 6,
                'text' => 'Косплей-луки'
            ]
        );
        Option::create(
            [
                'poll_id' => 6,
                'text' => 'Винтажные джинсы 90-х'
            ]
        );
        Option::create(
            [
                'poll_id' => 6,
                'text' => 'Неоновые цвета'
            ]
        );
        Option::create(
            [
                'poll_id' => 6,
                'text' => 'Минимализм'
            ]
        );
        Option::create(
            [
                'poll_id' => 6,
                'text' => 'Мой стиль - вне трендов'
            ]
        );
    }
}
