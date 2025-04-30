<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'artist_id', 
        'genre_id', 
        'album_id',
        'duration', 
        'file_path', 
        'image',
        'listen_count' // Добавляем новое поле
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'track_id'); 
    }

    public function users()
    {
    return $this->belongsToMany(User::class, 'library_user', 'track_id', 'user_id');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_tracks', 'track_id', 'playlist_id');
    }
}
?>