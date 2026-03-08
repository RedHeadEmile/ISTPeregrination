<?php

namespace ISTPeregrination\Services\MobilityReview;

use ISTPeregrination\Services\MobilityReview\Models\MobilityReviewModel;

interface IMobilityReviewService
{
    /**
     * Get all mobility reviews.
     * @param bool $onlyReviewed Whether to only return reviewed mobility reviews.
     * @return MobilityReviewModel[] All mobility reviews.
     */
    function getAllMobilityReviews(bool $onlyReviewed): array;

    /**
     * Submit a mobility review.
     * @param MobilityReviewModel $model The mobility review to submit.
     * @return void
     */
    function submitMobilityReview(MobilityReviewModel $model): void;

    /**
     * Approve a mobility review.
     * @param int $reviewId The ID of the mobility review to approve.
     * @return void
     */
    function approveMobilityReview(int $reviewId): void;

    /**
     * Delete a mobility review.
     * @param int $reviewId The ID of the mobility review to delete.
     * @return void
     */
    function deleteMobilityReview(int $reviewId): void;
}