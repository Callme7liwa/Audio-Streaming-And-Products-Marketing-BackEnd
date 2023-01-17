<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'city',
        'photo',
        'country',
        'email',
        'birthday',
        'password'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function musics() {
        return $this->hasMany('App\Models\Music');
    }

    public function Products() {
        return $this->hasMany('App\Models\Product');
    }

    public function liked ()
    {
        return $this->BelongsToMany('App\Models\Product','Produit__user__likes', 'user_id', 'product_id');
    }

    public function Musicsliked ()
    {
        return $this->BelongsToMany('App\Models\Music','Musics__Likes__Tables', 'user_id', 'music_id');
    }

    public function following () {
        return $this->belongsToMany(User::class, 'friends', 'follower_profile_id', 'followed_profile_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'friends', 'followed_profile_id', 'follower_profile_id');
    }
    
}
