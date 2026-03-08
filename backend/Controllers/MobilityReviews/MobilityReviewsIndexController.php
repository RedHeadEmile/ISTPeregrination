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
        $mobilityReviews = MobilityReviewService::getInstance()->getAllMobilityReviews();

        if ($this->getCurrentUser() === null) {
            foreach ($mobilityReviews as $review) {
                if (!$review->allowContacts) {
                    $review->email = null;
                    $review->linkedin = null;
                }
            }
        }

        $this->jsonResponse($mobilityReviews);
    }

    public function post(): void
    {
        list($sector, $mobilityYear, $allowContacts, $countryCode, $city, $hostOrganization, $isMobilityProfessional,
            $mobilityPeriod, $hadBreaks, $neededVisa, $transportationMeans, $accommodationCost, $livingCost,
            $financialAid, $neededToOpenBankAccount, $spokenLanguage, $languageLevel, $integration,
            $prosAndConsOfTheCountry, $tipsForTheCountry, $whatWouldYouChange, $adviceForFutureMobilityStudents,
            $firstname, $lastname, $email, $linkedin, $contractStatusWhileMobility, $contractStatusDetailsWhileMobility,
            $breaksBefore, $breaksWhile, $breaksAfter, $visaDetails, $visaDelaysForAsking, $visaTips, $visaCost,
            $vaccinationDetails, $transportationDetails, $accommodationIsUniversity, $accommodationIsShared,
            $accommodationIsStudio, $accommodationIsSomeone, $accommodationIsYouthHostel, $accommodationDetails) =
            json_body(['sector', 'mobilityYear', 'allowContacts', 'countryCode', 'city', 'hostOrganization',
                'isMobilityProfessional', 'mobilityPeriod', 'hadBreaks', 'neededVisa', 'transportationMeans',
                'accommodationCost', 'livingCost', 'financialAid', 'neededToOpenBankAccount', 'spokenLanguage',
                'languageLevel', 'integration', 'prosAndConsOfTheCountry', 'tipsForTheCountry', 'whatWouldYouChange',
                'adviceForFutureMobilityStudents'], ['firstname', 'lastname', 'email', 'linkedin',
                'contractStatusWhileMobility', 'contractStatusDetailsWhileMobility', 'breaksBefore', 'breaksWhile',
                'breaksAfter', 'visaDetails', 'visaDelaysForAsking', 'visaTips', 'visaCost', 'vaccinationDetails',
                'transportationDetails', 'accommodationIsUniversity', 'accommodationIsShared', 'accommodationIsStudio',
                'accommodationIsSomeone', 'accommodationIsYouthHostel', 'accommodationDetails']);

        $review = new MobilityReviewModel();
        $review->firstname = verify_text($firstname, 0, 255, allow_null: true);
        $review->lastname = verify_text($lastname, 0, 255, allow_null: true);
        $review->sector = verify_text($sector, 0, 1000000);
        $review->mobilityYear = verify_text($mobilityYear, 0, 1000000);
        $review->allowContacts = verify_bool($allowContacts);
        $review->email = verify_text($email, 0, 255, allow_null: true);
        $review->linkedin = verify_text($linkedin, 0, 255, allow_null: true);
        $review->countryCode = verify_text($countryCode, 0, 45);
        $review->city = verify_text($city, 0, 255);
        $review->hostOrganization = verify_text($hostOrganization, 0, 1000000);
        $review->isMobilityProfessional = verify_bool($isMobilityProfessional);
        $review->contractStatusWhileMobility = verify_number($contractStatusWhileMobility, allow_zero: true, min_value: 0, max_value: 3);
        $review->contractStatusDetailsWhileMobility = verify_text($contractStatusDetailsWhileMobility, 0, 1000000, allow_null: true);
        $review->mobilityPeriod = verify_text($mobilityPeriod, 0, 1000000);
        $review->hadBreaks = verify_bool($hadBreaks);
        $review->breaksBefore = verify_bool($breaksBefore, true);
        $review->breaksWhile = verify_bool($breaksWhile, true);
        $review->breaksAfter = verify_bool($breaksAfter, true);
        $review->neededVisa = verify_bool($neededVisa);
        $review->visaDetails = verify_text($visaDetails, 0, 1000000, allow_null: true);
        $review->visaDelaysForAsking = verify_text($visaDelaysForAsking, 0, 1000000, allow_null: true);
        $review->visaTips = verify_text($visaTips, 0, 1000000, allow_null: true);
        $review->visaCost = verify_text($visaCost, 0, 1000000, allow_null: true);
        $review->vaccinationDetails = verify_text($vaccinationDetails, 0, 1000000, allow_null: true);
        $review->transportationMeans = verify_text($transportationMeans, 0, 1000000);
        $review->transportationDetails = verify_text($transportationDetails, 0, 1000000, allow_null: true);
        $review->accommodationIsUniversity = verify_bool($accommodationIsUniversity, true);
        $review->accommodationIsShared = verify_bool($accommodationIsShared, true);
        $review->accommodationIsStudio = verify_bool($accommodationIsStudio, true);
        $review->accommodationIsSomeone = verify_bool($accommodationIsSomeone, true);
        $review->accommodationIsYouthHostel = verify_bool($accommodationIsYouthHostel, true);
        $review->accommodationDetails = verify_text($accommodationDetails, 0, 1000000, allow_null: true);
        $review->accommodationCost = verify_text($accommodationCost, 0, 1000000);
        $review->livingCost = verify_text($livingCost, 0, 1000000);
        $review->financialAid = verify_text($financialAid, 0, 1000000);
        $review->neededToOpenBankAccount = verify_text($neededToOpenBankAccount, 0, 1000000);
        $review->spokenLanguage = verify_text($spokenLanguage, 0, 1000000);
        $review->languageLevel = verify_text($languageLevel, 0, 1000000);
        $review->integration = verify_text($integration, 0, 1000000);
        $review->prosAndConsOfTheCountry = verify_text($prosAndConsOfTheCountry, 0, 1000000);
        $review->tipsForTheCountry = verify_text($tipsForTheCountry, 0, 1000000);
        $review->whatWouldYouChange = verify_text($whatWouldYouChange, 0, 1000000);
        $review->adviceForFutureMobilityStudents = verify_text($adviceForFutureMobilityStudents, 0, 1000000);

        if (!array_key_exists($review->countryCode, getCountryNameByCode())) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid country code']);
            return;
        }

        MobilityReviewService::getInstance()->submitMobilityReview($review);
        http_response_code(201);
    }
}