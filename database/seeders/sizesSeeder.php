<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class sizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size=new Size();
        $size->size='s';
        $size->save();
        
        $size=new Size();
        $size->size='m';
        $size->save();

        $size=new Size();
        $size->size='l';
        $size->save();
       
    }
}
