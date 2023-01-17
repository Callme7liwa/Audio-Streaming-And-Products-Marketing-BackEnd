<?php

namespace Database\Seeders;

use App\Models\ProductsCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prdocutCategory = new ProductsCategories();
        $prdocutCategory->product_id=1 ; 
        $prdocutCategory->category_id=1 ; 
        $prdocutCategory->save();
        $prdocutCategory = new ProductsCategories();
        $prdocutCategory->product_id=1 ; 
        $prdocutCategory->category_id=2 ; 
        $prdocutCategory->save();
        $prdocutCategory = new ProductsCategories();
        $prdocutCategory->product_id=1 ; 
        $prdocutCategory->category_id=3 ; 
        $prdocutCategory->save();

    }
}
