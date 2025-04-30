<?
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function homeContent()
    {
        return view('home-content');
    }


}
?>