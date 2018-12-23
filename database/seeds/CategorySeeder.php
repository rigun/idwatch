<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::create(['name' => 'Man',]);
        \App\Category::create(['name' => 'Woman',]);
        \App\Category::create(['name' => 'Couple',]);
        \App\Category::create(['name' => 'Unisex',]);
    }
}
