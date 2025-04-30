<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'bio'];

    // Отношение к трекам (у артиста много треков)
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    // Отношение к альбомам (у артиста много альбомов)
    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    // Отношение к пользователю (артист принадлежит пользователю)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

