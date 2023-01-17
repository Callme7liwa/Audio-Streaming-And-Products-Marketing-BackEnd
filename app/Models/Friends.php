<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory;

    public function following()
    {
        return $this->belongsToMany(User::class, 'friends', 'follower_profile_id', 'followed_profile_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'friends', 'followed_profile_id', 'follower_profile_id');
    }
}
