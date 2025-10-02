<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use App\Models\Cake;
use Illuminate\Support\Facades\Auth;

class CakeReviews extends Component
{
    public $cakeId;
    public $cake;
    public $reviews;
    public $averageRating;
    public $totalReviews;
    
    // Review form fields
    public $rating;
    public $comment;
    public $userName;
    public $postAnonymously = false;
    
    public $showReviewForm = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:10|max:1000',
        'userName' => 'nullable|string|max:100',
    ];

    protected $messages = [
        'rating.required' => 'Please select a rating',
        'rating.min' => 'Rating must be at least 1 star',
        'rating.max' => 'Rating cannot exceed 5 stars',
        'comment.required' => 'Please write a review',
        'comment.min' => 'Review must be at least 10 characters',
        'comment.max' => 'Review cannot exceed 1000 characters',
    ];

    public function mount($cakeId)
    {
        $this->cakeId = $cakeId;
        $this->cake = Cake::findOrFail($cakeId);
        $this->loadReviews();
        
        // Pre-fill user name if authenticated
        if (Auth::check()) {
            $this->userName = Auth::user()->name;
        }
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('cake_id', (int)$this->cakeId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $this->averageRating = Review::getAverageRating($this->cakeId);
        $this->totalReviews = Review::getTotalReviews($this->cakeId);
    }

    public function toggleReviewForm()
    {
        $this->showReviewForm = !$this->showReviewForm;
        
        // Reset form when closing
        if (!$this->showReviewForm) {
            $this->reset(['rating', 'comment', 'postAnonymously']);
        }
    }

    public function submitReview()
    {
        $this->validate();

        // Check if user already reviewed this cake
        if (Auth::check()) {
            $existingReview = Review::where('cake_id', (int)$this->cakeId)
                ->where('user_id', Auth::id())
                ->first();
            
            if ($existingReview) {
                session()->flash('error', 'You have already reviewed this product.');
                return;
            }
        }

        // Determine display name
        $displayName = $this->postAnonymously ? 'Anonymous' : ($this->userName ?: 'Anonymous');

        Review::create([
            'cake_id' => (int)$this->cakeId,
            'user_id' => Auth::id(),
            'user_name' => $displayName,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_verified_purchase' => false, 
        ]);

        session()->flash('success', 'Thank you for your review!');
        
        // Reset form
        $this->reset(['rating', 'comment', 'postAnonymously', 'showReviewForm']);
        
        // Reload reviews
        $this->loadReviews();
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function render()
    {
        return view('livewire.cake-reviews');
    }
}