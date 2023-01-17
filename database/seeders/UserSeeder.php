<?php

namespace Database\Seeders;

use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $user=new User();
        $user->username="7ari";
        $user->email="7ari@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/7ari.jpg";
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="7liwa";
        $user->email="7liwa@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/7liwa.jpg";
        
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="Tflow";
        $user->email="tflow@gmail.com";
        $user->photo="products/users/tflow.jpg";
        $user->password=bcrypt("1234");
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="7enchaoui";
        $user->email="7enchaoui@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/7enchaoui.jpg";
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="Ljasos";
        $user->email="Ljasos@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/jasos.jpg";
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="boqal";
        $user->email="boqal@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/boqal.jpg";
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="gjma";
        $user->email="gjma@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/gjma.jpg";
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="Yous45";
        $user->email="Youss45@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/Youus45.jpg";
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
        
        $user=new User();
        $user->username="xxxrays";
        $user->email="xxxrays@gmail.com";
        $user->password=bcrypt("1234");
        $user->photo="products/users/xxxrays.jpg";
        $user->city="fes";
        $user->country="casablanca"; 
        $user->birthday="2020-11-01";
        $user->save();
    }
}
