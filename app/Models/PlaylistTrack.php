<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistTrack extends Model
{
    protected $fillable = ['playlist_id', 'track_id'];
}

?>