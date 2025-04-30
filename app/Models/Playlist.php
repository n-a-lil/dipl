<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_tracks', 'playlist_id', 'track_id');
    }

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'is_favorites' 
    ];
}

?>