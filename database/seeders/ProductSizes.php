<?php

namespace Database\Seeders;

use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSizes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $productSize = new ProductSize();
         $productSize->product_id=1 ; 
         $productSize->size_id=2;
         $productSize->save();
        //  $productSize = new ProductSizes();
        //  $productSize->product_id=1 ; 
        //  $productSize->size_id=2;
        //  $productSize->save();
        //  $productSize = new ProductSizes();
        //  $productSize->product_id=3 ; 
        //  $productSize->size_id=1;
        //  $productSize->save();
    }
}
