<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;

class SearchController extends Controller
{
    public function searchTracks(Request $request)
    {
        $query = $request->query('query');
        $tracks = Track::with('artist')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->orderBy('listen_count', 'desc')
            ->get();
    
        return view('track-list', compact('tracks'));
    }

    public function SelectedTrack($id)
    {
        $track = Track::with('artist')->findOrFail($id);
        $artistTracks = Track::where('artist_id', $track->artist_id)
                            ->where('id', '!=', $track->id)
                            ->orderBy('listen_count', 'desc') 
                            ->limit(5)
                            ->get();
        
        return view('selected-track', compact('track', 'artistTracks'));
    }
    
    public function universalSearch(Request $request)
    {
        $query = $request->query('query');
        
        $tracks = Track::with('artist')
            ->where('title', 'LIKE', '%'.$query.'%')
            ->orderBy('listen_count', 'desc') 
            ->limit(5)
            ->get();
        
        $artists = Artist::where('name', 'LIKE', '%'.$query.'%')
            ->limit(5)
            ->get();

        $albums = Album::with('artist')
            ->where('title', 'LIKE', '%'.$query.'%')
            ->limit(5)
            ->get();
        
        return view('universal-search-results', compact('tracks', 'artists', 'albums'));
    }

    public function selectedArtist($id)
    {
        $artist = Artist::with('user')->findOrFail($id);
        $tracks = Track::where('artist_id', $id)
                    ->orderBy('listen_count', 'desc')
                    ->limit(5)
                    ->get();
        
        return view('selected-artist', [
            'artist' => $artist,
            'tracks' => $tracks,
            'artistAvatar' => $artist->user->avatar ?? null
        ]);
    }

    public function homeSelectedTrack($id)
    {
        $track = Track::with('artist')->findOrFail($id);
        $artistTracks = Track::where('artist_id', $track->artist_id)
                            ->where('id', '!=', $track->id)
                            ->orderBy('listen_count', 'desc')
                            ->limit(5)
                            ->get();
        
        return view('home-selected-track', compact('track', 'artistTracks'));
    }
    
    public function selectedAlbum($id)
    {
        $album = Album::with(['artist', 'tracks'])->findOrFail($id);
        $tracks = $album->tracks()
                    ->orderBy('listen_count', 'desc') 
                    ->get();
        
        return view('selected-album', [
            'album' => $album,
            'tracks' => $tracks,
            'albumImage' => $album->cover_image ?? null
        ]);
    }
    public function searchAlbums(Request $request)
    {
        $query = $request->query('query');
        $albums = Album::with('artist')
            ->where('title', 'LIKE', '%'.$query.'%')
            ->orderBy('release_date', 'desc')
            ->get();
    
        return view('album-list', compact('albums'));
    }
}