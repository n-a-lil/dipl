<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoritesPlaylistSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            Playlist::firstOrCreate(
                ['user_id' => $user->id, 'is_favorites' => true],
                ['name' => 'Любимые', 'image' => null]
            );
        }
    }
}