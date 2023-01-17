<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\MusicsLikesTableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProduitUserLikeController;
use App\Http\Controllers\SizeController;
use App\Models\Musics_Likes_Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login'])->withoutMiddleware('auth:sanctum');
Route::get('/users', [UserController::class, 'users'])->withoutMiddleware('auth:sanctum');
Route::post('/alami', [UserController::class, 'alami']);

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});

Route::get('/musicWithUsers', [MusicController::class, 'getMusicWithUsers']);
//
Route::get('/categories',[CategoryController::class,'index']);
//
Route::get('/getOne/{id}', [MusicController::class, 'getOne']);
//
Route::get('/musicsByUser/{id}', [MusicController::class, 'getMusicByUser']);
//
Route::get('/products', [ProductsController::class, 'index']);
//
Route::get('/products/categories/sizes', [ProductsController::class, 'getProductWithCategoriesAndSizes']);
//
Route::get('/products/{id}', [ProductsController::class, 'show']);
//
Route::get('/categories/products/{id}', [ProductsController::class, 'ProductsOfTheSameCategory']);
//
Route::get('users/{id}', [UserController::class, 'getUserById']);
// 
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    // 
    Route::post('users/{id}', [UserController::class, 'updateUser']);

    //
    Route::get('/musics', [MusicController::class, 'index']);
    Route::get('/musics/{id}', [MusicController::class, 'show']);
    Route::post('/musics', [MusicController::class, 'store']);
    Route::post('/musics/{id}', [MusicController::class, 'update']);
    Route::put('/accepte/musics/{id}', [MusicController::class, 'accepte']);
    Route::delete('/musics/{id}', [MusicController::class, 'destroy']);
    Route::get('/musics/user/authenticated', [MusicController::class, 'myMusic']);
    Route::get('/musics/user/qeueu', [MusicController::class, 'MusicQueue']);
    Route::get('/musics/user/accepted', [MusicController::class, 'MusicAccepted']);
    Route::post('/delete/music/{id}', [MusicController::class, 'deleteMusic']);
    Route::post('/accepte/music/{id}', [MusicController::class, 'accepteMusic']);
    //
    //produit soit accepter soit non ( partie visualtion par l'admin)
    Route::get('/dataBase/products',[ProductsController::class,'getProductsInDataBase']);
    Route::post('/products', [ProductsController::class, 'store']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::get('/addSizes/products/{id}', [ProductsController::class, 'addSizes']);
    Route::post('/accepte/product/{id}', [ProductsController::class, 'accepte']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy']);
    Route::get('/user/products', [ProductsController::class, 'myProduct']);
    Route::get('/user/products/qeueu', [ProductsController::class, 'ProductQueue']);
    Route::get('/user/products/accepted', [ProductsController::class, 'ProductAccepted']);
    Route::post('delete/product/{id}', [ProductsController::class, 'deleteProduct']);
    Route::get('/products/users/followed', [ProductsController::class, 'getProductsOfUsersWichImFollowing']);
    
    //faire like Product
    Route::post('/like/user/{id}/product/{productId}', [ProductsController::class, 'PostLike']);
    //faire like music 
    Route::post('/like/music/{id}', [MusicsLikesTableController::class, 'PostLike']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user', [UserController::class, 'user']);
    Route::post('accepte/user/{id}', [UserController::class, 'accepte']);
    Route::post('desactive/user/{id}', [UserController::class, 'desactive']);
    Route::post('banne/user/{id}', [UserController::class, 'banne']);
    Route::post('delete/user/{id}', [UserController::class, 'delete']);
    Route::get('usersWithProducts', [UserController::class, 'getUsersWithThemProducts']);
    Route::get('usersWithMusics', [UserController::class, 'getUsersWithThemMusics']);
    // Route::get('musicsByUser/{id}',[UserController::class,'getMusicByUser']);
    //
    Route::post('/commands', [CommandController::class, 'store']);
    Route::get('/commands/{id}', [CommandController::class, 'show']);
    
    //Size
    Route::get('/sizes',[SizeController::class,'allSizes']);

    // get product liked by an user 
    Route::get('/user/products/liked', [UserController::class, 'getProductsLiked']);
    // get Music Liked by the user 
    Route::get('/user/musics/liked', [MusicsLikesTableController::class, 'MusicsLiked']);
    //Unlike Product 
    Route::post('/unlike/product/{id}', [ProduitUserLikeController::class, 'unLike']);
    //Unlike Music
    Route::post('/unlike/music/{id}', [MusicsLikesTableController::class, 'UnlikeMusic']);
    //
    Route::get('getMyFollowers', [UserController::class, 'getMyFollower']);
    //
    Route::get('getMyFriends', [UserController::class, 'getMyFriends']);
    // faire Abonner
    Route::post("follow/user/{id}",[FriendsController::class, 'follow']);
    // Abonner Simple
    Route::post("followSimple/user/{id}",[FriendsController::class,'followSimple']);
    // desabonner ; 
    Route::delete("unfollow/user/{id}",[FriendsController::class,'unfollow']);
    //
    Route::get('/musics/users/followed', [MusicController::class, 'getMusicOfUsersWichImFollowing']);
    //
    Route::get('/getUnfollowPerson', [UserController::class, 'getUnfollowPerson']);
    //
    Route::get('/numberOfLikes/{id}', [MusicController::class, 'numberOfLikes']);
});
//
Route::get('getFriends/{id}', [UserController::class, 'getFriends']);
//
Route::get('getFollowers/{id}', [UserController::class, 'getFollowers']);
//
Route::get('/getProducts', [ProductsController::class, 'getProducts']);
