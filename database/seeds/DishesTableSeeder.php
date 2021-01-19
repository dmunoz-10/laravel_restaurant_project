<?php

use Illuminate\Database\Seeder;

class DishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Dish::class, 50)->create()->each(function ($dish) {
          $dish->ingredients()->save(factory(App\Post::class)->make());
        });;
    }
}
