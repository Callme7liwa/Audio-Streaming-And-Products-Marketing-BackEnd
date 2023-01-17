<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'photo',
        'etat',
        'file_path',
        'nombre_signal',
        
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function liked ()
    {
        return $this->BelongsToMany('App\Models\User','Musics__Likes__Tables',  'music_id','user_id');
    }
    public function numberLiked ()
    {
        return $this->BelongsToMany('App\Models\User','Musics__Likes__Tables',  'music_id','user_id')->get()->count();
    }
}
