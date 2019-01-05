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
        \App\Category::create(['name' => 'Jam Tangan Pria']);
        \App\Category::create(['name' => 'Jam Tangan Wanita']);
        \App\Category::create(['name' => 'Jam Tangan Pasangan']);
    }
}
