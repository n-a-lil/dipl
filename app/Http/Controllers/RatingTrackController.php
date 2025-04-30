<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\User;

class RatingTrackController extends Controller
{
    public function ratingTrack()
    {   
        $username = session('username');

        if (!$username) {
            return 'unauthorized';
        } else {
            return view('rating-track');
        }
    }

    public function ratingForm($trackId)
    {   
        return view('rating-form', ['trackId' => $trackId]);
    }

    public function submitRating(Request $request)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'Пользователь не найден.');
        }
    
        $userId = $user->id;
    
        $trackId = $request->query('trackId');
        $text = $request->query('text');
        $structure = $request->query('structure');
        $style = $request->query('style');
        $individuality = $request->query('individuality');
        $vibe = $request->query('vibe');
    
        $averageRating = ($text + $structure + $style + $individuality + $vibe) / 5;
    
        $existingRating = Rating::where('track_id', $trackId)
                                ->where('user_id', $userId)
                                ->first();
    
        if ($existingRating) {
            $existingRating->rating = $averageRating;
            $existingRating->save();
        } else {
            $rating = new Rating();
            $rating->user_id = $userId; 
            $rating->track_id = $trackId;
            $rating->rating = $averageRating;
            $rating->save();
        }
    
        return redirect()->back()->with('success', 'Оценка успешно отправлена!');
    }    

    public function ratingAlbum()
    {   
        $username = session('username');

        if (!$username) {
            return 'unauthorized';
        } else {
            return view('rating-album');
        }
    }

    public function ratingAlbumForm($albumId)
    {   
        return view('rating-album-form', ['albumId' => $albumId]);
    }

    public function submitAlbumRating(Request $request)
    {
        $username = session('username');
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'Пользователь не найден.');
        }
    
        $userId = $user->id;
    
        $albumId = $request->query('albumId');
        $text = $request->query('text');
        $structure = $request->query('structure');
        $style = $request->query('style');
        $individuality = $request->query('individuality');
        $vibe = $request->query('vibe');
    
        $averageRating = ($text + $structure + $style + $individuality + $vibe) / 5;
    
        $existingRating = Rating::where('album_id', $albumId)
                                ->where('user_id', $userId)
                                ->first();
    
        if ($existingRating) {
            $existingRating->rating = $averageRating;
            $existingRating->save();
        } else {
            $rating = new Rating();
            $rating->user_id = $userId; 
            $rating->album_id = $albumId;
            $rating->rating = $averageRating;
            $rating->save();
        }
    
        return redirect()->back()->with('success', 'Оценка успешно отправлена!');
    }   
}
