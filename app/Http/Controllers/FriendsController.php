<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendsController extends Controller
{
    public function getFollowingPeople()
    {
        return Auth::user()->followers;
    }

    public function follow($id)
    {
        $row = new Friends();
        $row->follower_profile_id=Auth::user()->id;
        $row->followed_profile_id=$id;
        if($row->save())
            return Response(Auth::user()->followers,201);
        else   
            return Response("Erreur Qlq par ",201);
    }

    public function followSimple($id)
    {
        $row = new Friends();
        $row->follower_profile_id=Auth::user()->id;
        $row->followed_profile_id=$id;
        if($row->save())
            return Response('FollowedSuccsfuly',201);
        else   
            return Response("Erreur Qlq par ",500);
    }




 
    public function unfollow ($id)
    {

        $result = Friends::where([
            'follower_profile_id' => Auth::user()->id,
            'followed_profile_id' => $id,
        ])->get();

        $result = DB::delete('delete  from  friends where follower_profile_id=? and followed_profile_id=?',[Auth::user()->id,$id ]);
            
        if($result)
            return Response("Unfollowed Succesfuly",201);
        else    
            return Response("Please Try again  ",500);
    } 

}
