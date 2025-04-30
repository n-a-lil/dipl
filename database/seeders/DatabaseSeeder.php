<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Добавление данных в таблицу users
        DB::table('users')->insert([
            ['username' => 'user1', 'email' => 'user1@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'user2', 'email' => 'user2@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'user3', 'email' => 'user3@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'user4', 'email' => 'user4@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'user5', 'email' => 'user5@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу artists
        DB::table('artists')->insert([
            ['name' => 'Artist 1', 'bio' => 'Bio of artist 1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Artist 2', 'bio' => 'Bio of artist 2', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Artist 3', 'bio' => 'Bio of artist 3', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Artist 4', 'bio' => 'Bio of artist 4', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Artist 5', 'bio' => 'Bio of artist 5', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу genres
        DB::table('genres')->insert([
            ['name' => 'Pop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rock', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jazz', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Classical', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hip-Hop', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу tracks
        DB::table('tracks')->insert([
            ['title' => 'Track 1', 'artist_id' => 1, 'genre_id' => 1, 'duration' => 180, 'file_path' => 'path/to/track1.mp3', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Track 2', 'artist_id' => 2, 'genre_id' => 2, 'duration' => 210, 'file_path' => 'path/to/track2.mp3', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Track 3', 'artist_id' => 3, 'genre_id' => 3, 'duration' => 240, 'file_path' => 'path/to/track3.mp3', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Track 4', 'artist_id' => 4, 'genre_id' => 4, 'duration' => 300, 'file_path' => 'path/to/track4.mp3', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Track 5', 'artist_id' => 5, 'genre_id' => 5, 'duration' => 270, 'file_path' => 'path/to/track5.mp3', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу ratings
        DB::table('ratings')->insert([
            ['user_id' => 1, 'track_id' => 1, 'rating' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'track_id' => 2, 'rating' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'track_id' => 3, 'rating' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'track_id' => 4, 'rating' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'track_id' => 5, 'rating' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу reviews
        DB::table('reviews')->insert([
            ['user_id' => 1, 'track_id' => 1, 'text' => 'Great track!', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'track_id' => 2, 'text' => 'Nice vibe.', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'track_id' => 3, 'text' => 'Pretty good.', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'track_id' => 4, 'text' => 'Not my style.', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'track_id' => 5, 'text' => 'Love it!', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу comments
        DB::table('comments')->insert([
            ['user_id' => 1, 'review_id' => 1, 'text' => 'I agree!', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'review_id' => 2, 'text' => 'Nice review!', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'review_id' => 3, 'text' => 'I like this track too.', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'review_id' => 4, 'text' => 'It’s okay.', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'review_id' => 5, 'text' => 'This track is amazing!', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу likes
        DB::table('likes')->insert([
            ['user_id' => 1, 'review_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'review_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'review_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'review_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'review_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу playlists
        DB::table('playlists')->insert([
            ['user_id' => 1, 'name' => 'My Playlist 1', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'name' => 'My Playlist 2', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'name' => 'My Playlist 3', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'name' => 'My Playlist 4', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'name' => 'My Playlist 5', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу playlist_tracks
        DB::table('playlist_tracks')->insert([
            ['playlist_id' => 1, 'track_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['playlist_id' => 2, 'track_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['playlist_id' => 3, 'track_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['playlist_id' => 4, 'track_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['playlist_id' => 5, 'track_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу listening_history
        DB::table('listening_history')->insert([
            ['user_id' => 1, 'track_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'track_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'track_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'track_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'track_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу achievements
        DB::table('achievements')->insert([
            ['name' => 'First Track Played', 'description' => 'Played your first track.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'First Review Written', 'description' => 'Written your first review.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Five Tracks Played', 'description' => 'Played five tracks.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Five Reviews Written', 'description' => 'Written five reviews.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Track Liked', 'description' => 'Liked your first track.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу user_achievements
        DB::table('user_achievements')->insert([
            ['user_id' => 1, 'achievement_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'achievement_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'achievement_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'achievement_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'achievement_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Добавление данных в таблицу admins
        DB::table('admins')->insert([
            ['user_id' => 1, 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'role' => 'moderator', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'role' => 'moderator', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'role' => 'moderator', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
