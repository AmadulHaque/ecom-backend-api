<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchProductReview;
use App\Actions\ReviewStore;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, ReviewStore $reviewStore)
    {
        $res = $reviewStore->handle($request);

        return success('Review created successfully', $res);
    }

    public function ProductReviews(Request $request, $slug)
    {
        return (new FetchProductReview)->execute($request, $slug);
    }

    public function myReviews(Request $request)
    {
        return ReviewService::getReviews($request);
    }

    public function toReviews(Request $request)
    {
        return ReviewService::getToReviews($request);
    }
}
