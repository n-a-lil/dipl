<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;
use App\Models\User;
use App\Models\Rating;

class ArtistController extends Controller
{
    public function show($id)
    {
        $artist = Artist::findOrFail($id);
        return view('artist', ['artist' => $artist]);
    }

    public function tracks($id)
    {
        $artist = Artist::findOrFail($id);
        $tracks = $artist->tracks()->with('genre')->get();
        return view('artist-tracks', ['tracks' => $tracks]);
    }

    public function albums($artistId)
    {
        $artist = Artist::with(['albums' => function($query) {
            $query->withCount('tracks');
        }])->findOrFail($artistId);

        return view('artist-albums', [
            'albums' => $artist->albums,
            'artist' => $artist
        ]);
    }

    public function albumTracks($artistId, $albumId)
    {
        $album = Album::with(['tracks.artist', 'artist'])->findOrFail($albumId);
        
        return view('album-tracks', [
            'album' => $album,
            'tracks' => $album->tracks,
            'isMyAlbum' => false,
            'artistId' => $artistId 
        ]);
    }

    public function artistRatings($artistId)
    {
        $artist = Artist::findOrFail($artistId);
    
        // Получаем все оценки треков артиста
        $trackRatings = Rating::with(['track'])
            ->whereHas('track', function($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->get();
    
        // Получаем все оценки альбомов артиста
        $albumRatings = Rating::with(['album'])
            ->whereHas('album', function($query) use ($artistId) {
                $query->where('artist_id', $artistId);
            })
            ->get();
    
        // Объединяем все оценки
        $allRatings = $trackRatings->merge($albumRatings);
    
        // Рассчитываем средний рейтинг
        $averageRating = $allRatings->avg('rating') ?? 0;
    
        return view('artist-rating-card', [
            'artist' => $artist,
            'trackRatings' => $trackRatings,
            'albumRatings' => $albumRatings,
            'averageRating' => round($averageRating, 1),
            'totalRatings' => $allRatings->count()
        ]);
    }
}
