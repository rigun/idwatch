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
        \App\Category::create(['name' => 'Laki-Laki',]);
        \App\Category::create(['name' => 'Perempuan',]);
        \App\Category::create(['name' => 'Pasangan',]);
    }
}
