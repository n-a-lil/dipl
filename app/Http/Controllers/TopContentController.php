<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Album;
use App\Models\Review;
use Illuminate\Http\Request;

class TopContentController extends Controller
{
    public function index()
    {
        $topTracks = Track::with('artist')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->limit(10)
            ->get();

        $topAlbums = Album::with(['artist', 'tracks'])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->limit(10)
            ->get();

        $topReviews = Review::with('user', 'track')
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->limit(10)
            ->get();

        return view('home-content', compact('topTracks', 'topReviews','topAlbums'));
    }
}
?>
