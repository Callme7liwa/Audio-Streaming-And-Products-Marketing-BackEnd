<?php

namespace App\Http\Controllers;

use App\Models\Musics_Likes_Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MusicsLikesTableController extends Controller
{
    public function UnlikeMusic ($id)
    {
        $result = DB::delete('delete  from  musics__likes__tables where music_id=? and user_id=?',[$id, Auth::user()->id]);
        
        if($result)
            return Response("Music Unliked  succesfuly",201);
        else    
            return Response("Error Please try a gain ",400);
    } 

    public function MusicsLiked()
    {
        return Auth::user()->Musicsliked;
    }

    public function PostLike($id)
    {  
        $music_user = new  Musics_Likes_Table();
        $music_user->user_id=Auth::user()->id;
        $music_user->music_id=$id;
        try {
                $music_user->save();
                
                return Response([
                  'message' =>  "Music Liked Succefuly",
                    // 'musicsLiked' => Auth::user()->Musicsliked
            ],201);
        } catch (\Throwable $th) {
                return Response("Error Please Try A gain",400);
        }
    }
}
