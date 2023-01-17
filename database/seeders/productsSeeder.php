<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Product = new Product();
        $Product->name="KIF CASA KIF BARIZ";
        $Product->description="T-shirt relative to the song featured by 7liwa and lartiste";
        $Product->photo="Its my Pic";
        $Product->price=99;
        $Product->save();
        //
        $Product = new Product();
        $Product->name="My Prod 1 ";
        $Product->description="My Prod Products produits store ";
        $Product->photo="Its my Pic";
        $Product->price=99;
        $Product->save();
        //
        $Product = new Product();
        $Product->name="My Prod 2 ";
        $Product->description="My Prod Products produits store ";
        $Product->photo="Its my Pic";
        $Product->price=99;
        $Product->save();
    }
}
