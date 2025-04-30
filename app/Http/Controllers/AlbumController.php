<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\User;
use App\Models\Rating;
use App\Models\Review;

class AlbumController extends Controller
{
    public function getTracksData($id)
    {
        $album = Album::with(['tracks', 'artist'])->findOrFail($id);
        
        $tracks = $album->tracks->map(function($track) use ($album) {
            return [
                'id' => $track->id,
                'title' => $track->title,
                'file_path' => asset($track->file_path),
                'image' => asset($track->image),
                'artist_name' => $album->artist->name,
            ];
        });
    
        return response()->json($tracks);
    }

    public function showAlbumCard(Album $album)
    {
        $username = session('username');
        $userRating = null;
        
        if ($username) {
            $user = User::where('username', $username)->first();
            $userRating = Rating::where('user_id', $user->id)
                              ->where('album_id', $album->id)
                              ->first();
        }
    
        return view('album-card', [
            'album' => $album->load('artist', 'ratings', 'tracks'),
            'userRating' => $userRating,
            'averageRating' => $album->ratings()->avg('rating')
        ]);
    }
    
}