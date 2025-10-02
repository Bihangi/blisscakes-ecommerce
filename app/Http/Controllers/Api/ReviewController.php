<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index($cakeId)
{
    \Log::info('Review API called', ['cake_id' => $cakeId, 'type' => gettype($cakeId)]);
    
    $reviews = Review::where('cake_id', (int)$cakeId)
        ->orderBy('created_at', 'desc')
        ->get();

    \Log::info('Reviews found', ['count' => $reviews->count()]);

    return response()->json([
        'reviews' => $reviews,
        'average_rating' => Review::getAverageRating($cakeId),
        'total_reviews' => Review::getTotalReviews($cakeId),
    ]);
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cake_id' => 'required|exists:cakes,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user has purchased this cake
        $hasPurchased = Order::where('user_id', $request->user()->id)
            ->whereHas('orderItems', function($query) use ($request) {
                $query->where('cake_id', $request->cake_id);
            })
            ->where('status', 'delivered')
            ->exists();

        $review = Review::create([
            'cake_id' => $request->cake_id,
            'user_id' => $request->user()->id,
            'user_name' => $request->user()->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified_purchase' => $hasPurchased,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully',
            'data' => $review
        ], 201);
    }

    public function destroy($id, Request $request)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id != $request->user()->id && $request->user()->user_type !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }
}