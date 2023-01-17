<?php

namespace App\Http\Controllers;

use App\Models\Produit_User_Like;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProduitUserLikeController extends Controller
{
    public function Unlike ($id)
    {
        $result = DB::delete('delete  from  produit__user__likes where product_id=? and user_id=?',[$id, Auth::user()->id]);
        
        if($result)
            return Response("Row deleted succesfuly",201);
        else    
            return Response("Error Please try a gain ",412);
    } 
}
