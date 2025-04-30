<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['artist_id', 'title', 'release_date', 'cover_image', 'description', 'genre_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'album_id');
    }
}