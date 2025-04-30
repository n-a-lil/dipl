<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\PlaylistTrack;
use App\Models\User;

class PlaylistController extends Controller
{
    public function playlists()
    {
        $username = session('username');
    
        if (!$username) {
            return redirect('/login')->with('error', 'Вы должны быть авторизованы.');
        }
    
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }
    
        $favoritesPlaylist = Playlist::firstOrCreate(
            ['user_id' => $user->id, 'is_favorites' => true],
            ['name' => 'Любимые', 'image' => null]
        );
    
        $playlists = Playlist::where('user_id', $user->id)
                    ->orderBy('is_favorites', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('playlists', compact('playlists'));
    }

    public function getPlaylistTracks($playlistId)
    {
        $playlist = Playlist::with('tracks.artist')->findOrFail($playlistId);
        return view('playlists-tracks', compact('playlist'));
    }

    public function updatePlaylistImage(Request $request, $playlistId)
    {    
        $playlist = Playlist::findOrFail($playlistId);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('playlist_images', 'public');
            $playlist->image = $imagePath;
            $playlist->save();
        }
    
        return back()->with('success', 'Обложка плейлиста обновлена');
    }

    public function create(Request $request)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = 'playlist_' . time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('public/images/playlists', $imageName);
            $imagePath = 'storage/images/playlists/' . $imageName;
        }
    
        Playlist::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'image' => $imagePath
        ]);
    
        return back()->with('success', 'Плейлист создан');
    }
    
    public function removeTrack($playlistId, $trackId)
    {
        PlaylistTrack::where('playlist_id', $playlistId)
                    ->where('track_id', $trackId)
                    ->delete();
    
        return response()->json(['success' => true, 'message' => 'Трек удален из плейлиста']);
    }   
    
    public function showPlaylistSelection($trackId)
    {
        $user = User::where('username', session('username'))->first();
        if (!$user) return response('Unauthorized', 401);
        
        return view('playlist-selection', [
            'playlists' => Playlist::where('user_id', $user->id)->get(),
            'trackId' => $trackId
        ]);
    }
    
    public function addTrackToPlaylist($playlistId, $trackId)
    {
        if (PlaylistTrack::where('playlist_id', $playlistId)
                       ->where('track_id', $trackId)
                       ->exists()) {
            return response('Track exists', 409);
        }
        
        PlaylistTrack::create([
            'playlist_id' => $playlistId,
            'track_id' => $trackId
        ]);
        
        return response('Success', 200);
    }

    public function showCreateForm()
    {
        $username = session('username');
    
        if (!$username) {
            return redirect('/login')->with('error', 'Вы должны быть авторизованы.');
        }
    
        return view('create-playlist');
    }
    
    public function createPlaylist(Request $request)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return response('Unauthorized', 401);
        }
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = 'playlist_' . time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('public/playlist_images', $imageName);
            $imagePath = 'playlist_images/' . $imageName;
        }
    
        Playlist::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'image' => $imagePath
        ]);
    
        return response('Success', 200);
    }

    public function delete($id)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return response('Unauthorized', 401);
        }
        
        $playlist = Playlist::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();
        
        if ($playlist) {
            if ($playlist->is_favorites) {
                return response('Cannot delete favorites playlist', 403);
            }
            $playlist->delete();
            return response('Success', 200);
        }
        
        return response('Playlist not found', 404);
    }

    public function editForm($id)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return response('Unauthorized', 401);
        }
    
        $playlist = Playlist::where('id', $id)
                  ->where('user_id', $user->id)
                  ->firstOrFail();
    
        return view('edit-playlist-form', compact('playlist'));
    }
    
    public function update(Request $request, $id)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return response('Unauthorized', 401);
        }
    
        $playlist = Playlist::where('id', $id)
                  ->where('user_id', $user->id)
                  ->firstOrFail();
    
        $playlist->name = $request->input('name');
    
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = 'playlist_' . time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('public/playlist_images', $imageName);
            $playlist->image = 'playlist_images/' . $imageName;
        }
    
        $playlist->save();
    
        return response('Success', 200);
    }
}
?>