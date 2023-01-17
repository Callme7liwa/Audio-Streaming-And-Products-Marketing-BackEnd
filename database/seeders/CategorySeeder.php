<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $category = new Category();
        $category->name="rap";
        $category->save();
        $category = new Category();
        $category->name="mixte";
        $category->save();
        $category = new Category();
        $category->name="t-shirt";
        $category->save();
    }
}
