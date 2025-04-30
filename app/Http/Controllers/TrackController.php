<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Genre;
use App\Models\Artist;
use App\Models\ListeningHistory;
use App\Models\User;
use App\Models\Album;
use App\Models\Rating;
use App\Models\Review;

class TrackController extends Controller
{
    public function tracksContent()
    {
        $genres = Genre::with(['tracks.artist'])->get();
        return view('tracks', compact('genres'));
    }

    public function showHistory()
    {
        $username = session('username');
        
        if (!$username) {
            return 'unauthorized'; 
        }
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return 'user_not_found'; 
        }
        
        $userId = $user->id;
        
        $listeningHistory = ListeningHistory::with(['track' => function($query) {
            $query->with('artist');
        }])
        ->where('user_id', $userId)
        ->orderBy('updated_at', 'desc') 
        ->get();
        
        $historyTracks = [];
        foreach ($listeningHistory as $history) {
            if ($history->track) { 
                $historyTracks[] = $history->track; 
            }
        }
        
        return view('history-tracks', compact('historyTracks'));
    }

    public function addToHistory(Request $request)
    {
        $username = session('username');
    
        if (!$username) {
            return 'unauthorized'; 
        }
    
        $trackId = $request->query('track_id');
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return 'user_not_found'; 
        }
    
        $userId = $user->id;
        $existingRecord = ListeningHistory::where('user_id', $userId)
            ->where('track_id', $trackId)
            ->first();
    
        Track::where('id', $trackId)->increment('listen_count');
    
        if ($existingRecord) {
            $existingRecord->updated_at = now();
            $existingRecord->save();
            return 'updated';
        }
    
        ListeningHistory::create([
            'user_id' => $userId,
            'track_id' => $trackId,
            'updated_at' => now(), 
        ]);
    
        return 'success';
    }

    public function showUploadForm()
    {
        $genres = Genre::all();
        return view('upload-track', ['genres' => $genres]);
    }

    public function showUploadFormAlbum()
    {
        $genres = Genre::all();
        return view('upload-album', ['genres' => $genres]);
    }

    public function uploadTrack(Request $request)
    {
        $username = session('username');
        
        if (!$username) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $artist = Artist::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->username]
        );
        
        $audioFile = $request->file('audio_file');
        $audioFileName = time() . '_' . $audioFile->getClientOriginalName();
        $audioFilePath = $audioFile->storeAs('tracks', $audioFileName, 'public');
        
        $imageFile = $request->file('image');
        $imageFileName = time() . '_' . $imageFile->getClientOriginalName();
        $imageFilePath = $imageFile->storeAs('images', $imageFileName, 'public');
        
        Track::create([
            'title' => $request->input('title'),
            'artist_id' => $artist->id, 
            'genre_id' => $request->input('genre_id'),
            'file_path' => 'storage/' . $audioFilePath,
            'image' => 'storage/' . $imageFilePath, // или 'image_path' в зависимости от структуры БД
            'duration' => 0,
            'album_id' => null
        ]);
        
        return response()->json(['success' => 'Track uploaded successfully']);
    }

    public function showMyTracks()
    {
        $username = session('username');
        
        if (!$username) {
            return 'Вы должны быть авторизованы для просмотра своих треков.';
        }
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }
        
        $artist = Artist::where('user_id', $user->id)->first();
        
        if (!$artist) {
            return view('my-tracks', ['tracks' => []]);
        }
        
        $tracks = Track::where('artist_id', $artist->id)->get();
        
        return view('my-tracks', ['tracks' => $tracks]);
    }

    public function deleteTrack($trackId)
    {
        $username = session('username');
        
        if (!$username) {
            return response()->json(['message' => 'unauthorized'], 401);
        }
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return response()->json(['message' => 'user_not_found'], 404);
        }
        
        // Находим трек по ID
        $track = Track::find($trackId);
        
        if (!$track) {
            return response()->json(['message' => 'track_not_found'], 404);
        }
        
        // Проверяем, что трек принадлежит текущему пользователю
        $artist = Artist::where('user_id', $user->id)->first();
        
        if (!$artist || $track->artist_id !== $artist->id) {
            return response()->json(['message' => 'forbidden'], 403);
        }
        
        // Удаляем трек из истории прослушиваний
        ListeningHistory::where('track_id', $trackId)->delete();
        
        // Удаляем трек из базы данных
        $track->delete();
        
        return response()->json(['message' => 'Трек успешно удален.'], 200);
    }


    public function albums()
    {
        $albums = Album::with(['artist', 'genre', 'tracks'])->get();
        return view('albums', compact('albums'));
    }

    public function all()
    {
        return view('all');
    }

    public function showAlbumTracks($albumId)
    {
        $album = Album::with(['tracks.artist'])->findOrFail($albumId);
        
        return view('album-tracks', [
            'album' => $album,
            'tracks' => $album->tracks,
            'isMyAlbum' => false
        ]);
    }
    
    // Для моих альбомов
    public function showMyAlbumTracks($albumId)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
        $artist = Artist::where('user_id', $user->id)->first();
        
        $album = Album::with(['tracks.artist'])
            ->where('artist_id', $artist->id)
            ->findOrFail($albumId);
        
        return view('my-album-tracks', [
            'album' => $album,
            'tracks' => $album->tracks,
            'isMyAlbum' => true
        ]);
    }

    public function upload()
    {
        return view('upload');
    }
    
    public function uploadAlbum(Request $request)
    {
        $username = session('username');
        
        if (!$username) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        if (!$request->hasFile('tracks') || count($request->file('tracks')) < 2) {
            return response()->json(['error' => 'At least 2 tracks required'], 400);
        }
        
        $artist = Artist::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->username]
        );
        
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('images', $imageName, 'public');
        
        $album = Album::create([
            'title' => $request->input('album_title'),
            'artist_id' => $artist->id,
            'genre_id' => $request->input('genre_id'),
            'cover_image' => 'storage/' . $imagePath,
            'release_date' => now(),
        ]);
        
        foreach ($request->file('tracks') as $trackFile) {
            $trackFileName = time() . '_' . $trackFile->getClientOriginalName();
            $trackPath = $trackFile->storeAs('tracks', $trackFileName, 'public');
            
            Track::create([
                'title' => pathinfo($trackFile->getClientOriginalName(), PATHINFO_FILENAME),
                'artist_id' => $artist->id,
                'album_id' => $album->id,
                'genre_id' => $request->input('genre_id'),
                'file_path' => 'storage/' . $trackPath,
                'image' => 'storage/' . $imagePath, // или 'image_path'
                'duration' => 0
            ]);
        }
        
        return response()->json(['success' => 'Album uploaded successfully']);
    }

    public function my()
    {
        return view('my');
    }
    public function showMyAlbums()
    {
        $username = session('username');
        
        if (!$username) {
            return 'Вы должны быть авторизованы для просмотра своих альбомов.';
        }
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }
        
        $artist = Artist::where('user_id', $user->id)->first();
        
        if (!$artist) {
            return view('my-albums', ['albums' => []]);
        }
        
        $albums = Album::with(['tracks', 'genre'])
            ->where('artist_id', $artist->id)
            ->get();
        
        return view('my-albums', ['albums' => $albums]);
    }
    
    public function showMyRatedTracks()
    {
        $username = session('username');
        
        if (!$username) {
            return 'Вы должны быть авторизованы для просмотра оцененных треков.';
        }
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }
        
        $ratedTracks = Track::whereHas('ratings', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['artist', 'ratings' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();
        
        return view('my-rating-tracks', ['tracks' => $ratedTracks]);
    }

    public function showCard(Track $track)
    {
        $username = session('username');
        $userRating = null;
        
        if ($username) {
            $user = User::where('username', $username)->first();
            $userRating = Rating::where('user_id', $user->id)
                              ->where('track_id', $track->id)
                              ->first();
        }
    
        $reviews = Review::with(['user', 'likes'])
                       ->where('track_id', $track->id)
                       ->orderByDesc('created_at')
                       ->get();
    
        return view('track-card', [
            'track' => $track->load('artist', 'ratings'),
            'userRating' => $userRating,
            'reviews' => $reviews,
            'averageRating' => $track->ratings()->avg('rating')
        ]);
    }

}
