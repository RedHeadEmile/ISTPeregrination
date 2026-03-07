<?php

namespace ISTPeregrination\Controllers\MobilityReviews;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\MobilityReview\MobilityReviewService;

class MobilityReviewsController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function delete(): void
    {
        $this->requireAuth();
        $mobilityId = $this->vars['id'];
        $mobilityId = verify_number($mobilityId);

        MobilityReviewService::getInstance()->deleteMobilityReview($mobilityId);
        http_response_code(204);
    }
}