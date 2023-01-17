<?php

namespace App\Http\Controllers;

use App\Models\User ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Array_;

class UserController extends Controller
{
    public function register(Request $request)
    {
            $fields = $request->validate([
                'username'=>'required|string',
                'email'=>'required|string|unique:users,email',
                'password'=>'required|string|confirmed',
                'birthday'=>'required',
                'city' => 'required|string',
                'country'=>'required|string',
                'fonction' => 'required'
            ]);
                       
            $user = User::create([
                    'username'=>$fields['username'],
                    'email'=>$fields['email'],
                    'birthday'=>$fields['birthday'],
                    'city'=>$fields['city'],
                    'country'=>$fields['country'],
                    'photo' => $request->file('photo')->store('products/users'),
                    'password'=>bcrypt($fields['password']),
                    'is_admin'=>$request['fonction']
            ]);
                
            if(!$user ) {
                return response([
                    'message' => 'Bad  Request '
                ], 401);
            }

            // $user->photo=$request->file('photo')->store('users');
            $token = $user->createToken("myAppToken")->plainTextToken;
            $response = [
                'user'=>$user,
                'token'=>$token,
                'message'=>'bien Authentifie'
            ];
            return response($response,201); 
}

   
    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        if($user->etat==1)
        {
            // Check password
                if(!$user || !Hash::check($fields['password'], $user->password)) {
                    return response([
                        'message' => 'Bad creds'
                    ], 401);
                }

                $token = $user->createToken('myAppToken')->plainTextToken;
                $cookie = cookie('jwt',$token,68*26);

                $response = [
                    'user' => $user,
                    'token'=> $token
                ];

                return response(
                    [
                        $response,
                        201
                ])->withCookie($cookie);
        }
        else {
            $response = [
                'message' => 'error , your account not yet activated',
            ];
            return response($response,206);
        }
    }

    public function logout(Request $request)
    {

        // auth()->user()->tokens()->delete();
        $cookie=Cookie::forget('jwt');
        return response  ([
            'message' => 'Logged Out',
            'HTTP_RESPONSE'=> 402
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }

    public function users()
    {
        return User::All()->where('is_deleted',0);
                  
    }
    
    // Get Product liked by user
    public function getProductsLiked() {
        return Auth::user()->liked;
    }

    // Activer le compte 
    public function accepte($id)
    {
       $user = User::find($id);
       $user->etat=1 ; 
       $user->banned=0 ; 
       if($user->save())
            return Response("Account Activated Succesfult",201);
        return Response("Please Try a gain ",412);
    }

    public function desactive($id)
    {
       $user = User::find($id);
       $user->etat=0 ; 
       if($user->save())
            return Response("Account Desactivated Succesfuly",201);
        return Response("Please Try a gain ",412);  
    }
    
    public function banne($id)
    {
       $user = User::find($id);
       $user->etat=0 ; 
       $user->banned=1 ; 
       if($user->save())
            return Response("Account Banned Succesfuly",201);
        return Response("Please Try a gain ",412);  
    }

    public function delete($id)
    {
       $user = User::find($id);
       if($user->is_deleted)
            return Response("user cannot be found",404);
       else
            {
                $user->is_deleted=1 ; 
                if($user->save())
                     return Response("Account Deleted Succesfuly",201);
                else    
                    return Response("Error please try next time !",412);
            }
    }

    public function getUsersWithThemProducts()
    {
        return  User::With('products')
                    ->where("is_admin",0)
                    ->where("etat",1)
                    ->get();      
    }
       
    public function getUsersWithThemMusics() 
    {
        return  User :: With('musics') 
                        -> where("is_admin",0)->get();
    }

    public function getMusicByUser($id)
    {
        return User::find($id)->musics->withCount('liked');
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function getMyFollowers()
    {
        return Auth::user()->followers;
    }

    public function getMyFriends()
    {
        return Auth::user()->following;
    }
    public function getFollowers($id)
    {
        return User::find($id)->followers;
    }

    public function getFriends($id)
    {
        return  User::find($id)->following;
    }

    public function getUnfollowPerson()
    {
         
        $follows = Auth::user()->following->pluck('id');
        $users = User::whereNotIn('id',$follows)
                      ->where('etat',1)
                      ->limit(10)
                      ->get();
        
        return $users ; 
      
    }
        // return Music::with('user', 
        //     function ($query) {
        //          $query->where('nom', '=', 'trump');
        //     }
        //     )
        // )->where('date_publication','=',now()->toDateString())->get();
       
     
        // return User::with('music')::whereHas(
        //     'musics',
        //     function ($query) {
        //     return $query->where('nom', '=', 'trump');
        //     })->get();

    //    return  User::with(["musics" => function($q){
    //         $q->where('nom', '=', 'trump');
    //     }])->get();

    

        // return User::whereHas('musics', function ($query) {
        //      $query->where('nom', '=', 'trump');
        // })->with('musics')->get();


            
        public function updateUser($id,Request $request)
        {
                $user = User::find($id);

                $user->username = $request->username ; 
                $user->email=$request->email;
        
                if($request->photo)
                $user->photo = $request->file('photo')->store('products/users');
              
                
                $user->birthday=$request->birthday;
                $user->city=$request->city ; 
                $user->country = $request->country ; 
                if($user->save())
                {
                    $response = [
                        'user'=>$user,
                        'message'=>'your profile has been updated successfuly'
                    ];
                    return response($response,201);
                }
                else 
                {
                    return response("erreur qlq part ",500);
                }
        }
        
    
    
}
