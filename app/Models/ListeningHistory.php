<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeningHistory extends Model
{
    use HasFactory;

    protected $table = 'listening_history'; 

    protected $fillable = ['user_id', 'track_id'];

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
