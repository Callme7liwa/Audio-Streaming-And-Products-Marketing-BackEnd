<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Produit_User_Like;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class MusicController extends Controller
{
    public function index()
    {
        if(Auth::user()->is_admin===1)
            return Music::all();
        return Auth::user()->musics;
    }

    
    public function store(Request $request)
    {
        
        $request->validate([
            'nom'=>'required',
            'photo'=>'required',
            'file_path'=>'required',
        ]);

         $music =  new Music();
         $music->nom=$request->input('nom');
         $music->date_publication= now();
         $music->user_id=Auth::user()->id;
         $music->photo=$request->file('photo')->store('products/musics/photos');
         $music->file_path=$request->file('file_path')->store('products/musics/tracks');
         if($request->description)
         {
           $music->description =  $request->input('description');
         } 
         if($music->save())
         {
             $response = [
                'music'=>$music,
                'message'=>'music has been added sucessefuly'
            ];
            return response($response,201); 
         }
         else{
            $response = [
                'music'=>$music,
                'message'=>'Please make sure about smtg'
            ];
            return response($response,500); 
         }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return music::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    { 
        $request->validate([
            'nom'=>'required',
            'date_publication'=>'required',
            'description' => 'required'
        ]);
        $music = music::find($id);
        $music->nom=$request->nom;
        $music->date_publication=$request->date_publication;
        $music->description=$request->description;
        if($request->file('photo'))
            $music->photo=$request->file('photo')->store('products/musics/photos');

        if($music->save())
         {   
             $response = [
                'music'=>$music,
                'message'=>'music has been updated sucessefuly'
            ];
            return response($response,201);
        }
        return $music;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return   music::destroy($id) ; 
    }

    public function search($name)
    {
       return   music::where('name','like','%d'.$name.'%d')->get(); 
    }

    public function accepte($id)
    {
        $music = music::find($id);
            $music->etat=1 ;
        return $music; 
        // return $music;
    }

    public function myMusic()
    {
        if(Auth::user()->is_admin)
        {
            return Music::all();
        }
        return Auth::user()->musics;
    }

    public function MusicQueue()
    {
        if(Auth::user()->is_admin)
        {
            return Music::all()->where('etat', 0);
        }
        return Auth::user()->musics->where('etat',0);
    }

    public function MusicAccepted()
    {
        if(Auth::user()->is_admin)
        {
            return Music::all()->where('etat', 1);
        }
        return Auth::user()->musics->where('etat',1);
    }

    public function getMusicWithUsers ()
    {
        return  Music::with('user')->where('etat','=',1)->get();
    }

    public function getOne ($id)
    {
            $music= Music::with('user')->withCount('liked')->find($id); 
            return $music;
    }

    public function getMusicOfUsersWichImFollowing()
    {
        $follows = Auth::user()->following->pluck('id');
        $musics = Music::whereIn('user_id',$follows)
                      ->where('etat','=',1)
                      ->with('user')
                      ->latest()
                      ->limit(10)
                      ->orderBy('created_at')
                      ->get();
            

        return $musics;
        
    }
    
    public function numberOfLikes($id) {
        $music =  Music::find($id)->liked->count();
        return $music;
    }

    public function getMusicByUser($id)
    {
        return Music::withCount('liked')->where('user_id',$id)->get();
    }

    public function accepteMusic($id)
    {
        $music=  Music::find($id);
        if($music->etat==0 && Auth::user()->id)
        {
            $response = [
            'music'=>$music,
            'message'=>'music has been accepted sucessefuly'
            ];
            $music->etat=1 ; 
            $music->save();
            return response($response,201);    
        }
        else
        {
            $response = [
                'music'=>$music,
                'message'=>'This music is already accepted'
            ];
            return response($response,412);  
        }
        
    }
    public function deleteMusic($id)
    {
        
        $music = Music::find($id);
        if($music->etat==0 || $music->etat==1)
        {
            $music->etat=-1 ;

            if($music->save()){
                $response = [
                'music'=>$music,
                'message'=>'music has been deleted sucessefuly'
                ];
                return response($response,201);  
            }
            else
                return response($music="Erreur qlq part " , 412);
        }
        else
        {
            $response = [
                'message'=>'This music is already deleted'
            ];
            return response($response,500);  
        } 
    }

    
   
}
