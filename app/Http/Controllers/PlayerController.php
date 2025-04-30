<?namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function show($id)
    {
        $track = Track::with('artist')->findOrFail($id);
        $tracks = Track::with('artist')->inRandomOrder()->limit(20)->get(); 

        return view('player', [
            'track' => $track,
            'tracks' => $tracks
        ]);
    }
}
?>