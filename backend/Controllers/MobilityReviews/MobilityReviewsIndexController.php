<?php

namespace ISTPeregrination\Controllers\MobilityReviews;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\MobilityReview\MobilityReviewService;
use ISTPeregrination\Services\MobilityReview\Models\MobilityReviewModel;

class MobilityReviewsIndexController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function get(): void
    {
        $this->jsonResponse(MobilityReviewService::getInstance()->getAllMobilityReviews());
    }

    public function post(): void
    {
        list($firstname, $lastname, $sector, $mobilityYear, $allowContacts, $email, $linkedin, $countryCode, $city,
            $hostOrganization, $isMobilityProfessional, $contractStatusWhileMobility,
            $contractStatusDetailsWhileMobility, $mobilityPeriod, $hadBreaks, $breaksDetails, $neededVisa, $visaDetails,
            $visaDelaysForAsking, $visaTips, $visaCost, $vaccinationDetails, $transportationMeans,
            $transportationDetails, $accommodationType, $accommodationDetails, $accommodationCost, $livingCost,
            $financialAid, $neededToOpenBankAccount, $spokenLanguage, $languageLevel, $integration,
            $prosAndConsOfTheCountry, $tipsForTheCountry, $whatWouldYouChange, $adviceForFutureMobilityStudents) =
            json_body(['firstname', 'lastname', 'sector', 'mobilityYear', 'allowContacts', 'email', 'linkedin',
                'countryCode', 'city', 'hostOrganization', 'isMobilityProfessional', 'contractStatusWhileMobility',
                'contractStatusDetailsWhileMobility', 'mobilityPeriod', 'hadBreaks', 'breaksDetails', 'neededVisa',
                'visaDetails', 'visaDelaysForAsking', 'visaTips', 'visaCost', 'vaccinationDetails',
                'transportationMeans', 'transportationDetails', 'accommodationType', 'accommodationDetails',
                'accommodationCost', 'livingCost', 'financialAid', 'neededToOpenBankAccount', 'spokenLanguage',
                'languageLevel', 'integration', 'prosAndConsOfTheCountry', 'tipsForTheCountry', 'whatWouldYouChange',
                'adviceForFutureMobilityStudents']);
    }
}