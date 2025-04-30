<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\User;

class ReviewController extends Controller
{
    public function likeReview($reviewId)
    {
        $username = session('username');

        if (!$username) {
            return 'unauthorized';
        }
        $review = Review::find($reviewId);
        if (!$review) {
            return 'review_not_found';
        }
        $user = User::where('username', $username)->first();

        $existingLike = $review->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();

            $review->loadCount('likes');

            return $review->likes_count;
        }

        $review->likes()->create(['user_id' => $user->id]);

        $review->loadCount('likes');

        return $review->likes_count;
    }

    public function showReviewForm($trackId) {
        $username = session('username');
        $user = User::where('username', $username)->first();
        $review = null;
    
        if ($user) {
            $review = Review::where('user_id', $user->id)
                ->where('track_id', $trackId)
                ->first();
        }
    
        return view('review-form', [
            'trackId' => $trackId,
            'review' => $review
        ]);
    }
    
    public function submitReview(Request $request) {
        $username = session('username');
        
        if (!$username) {
            return redirect('/login')->with('error', 'Требуется авторизация');
        }
    
        $trackId = $request->input('trackId');
        $reviewText = $request->input('reviewText');
        $user = User::where('username', $username)->first();
    
        $existingReview = Review::where('user_id', $user->id)
            ->where('track_id', $trackId)
            ->first();
    
        if ($existingReview) {
            $existingReview->text = $reviewText;
            $existingReview->save();
            $message = 'Рецензия обновлена';
        } else {
            Review::create([
                'user_id' => $user->id,
                'track_id' => $trackId,
                'text' => $reviewText
            ]);
            $message = 'Рецензия сохранена';
        }
    
        return view('selected-track')->with('success', $message);
    }
}

