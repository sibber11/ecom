<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $review = new Review();
        $review->fill($request->validated());
        $review->user()->associate($request->user());
        $review->save();
        return back()
            ->with('message', 'Review created successfully');
    }
}
