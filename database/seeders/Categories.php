<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Технологии'
        ]);
        Category::create([
            'name' => 'Кино и сериалы'
        ]);
        Category::create([
            'name' => 'Игры'
        ]);
        Category::create([
            'name' => 'Еда'
        ]);
        Category::create([
            'name' => 'Путешествия'
        ]);
        Category::create([
            'name' => 'Спорт'
        ]);
        Category::create([
            'name' => 'Мода'
        ]);
        Category::create([
            'name' => 'Музыка'
        ]);
        Category::create([
            'name' => 'Наука'
        ]);
        Category::create([
            'name' => 'Авто'
        ]);
        Category::create([
            'name' => 'Здоровье'
        ]);
        Category::create([
            'name' => 'Образование'
        ]);
        Category::create([
            'name' => 'Юмор'
        ]);
        Category::create([
            'name' => 'Другое'
        ]);
    }
}
