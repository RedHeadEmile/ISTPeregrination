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
        $review->breaksDetails = verify_text($breaksDetails, 0, 1000000);
        $review->neededVisa = verify_bool($neededVisa);
        $review->visaDetails = verify_text($visaDetails, 0, 1000000, allow_null: true);
        $review->visaDelaysForAsking = verify_text($visaDelaysForAsking, 0, 1000000, allow_null: true);
        $review->visaTips = verify_text($visaTips, 0, 1000000, allow_null: true);
        $review->visaCost = verify_text($visaCost, 0, 1000000, allow_null: true);
        $review->vaccinationDetails = verify_text($vaccinationDetails, 0, 1000000, allow_null: true);
        $review->transportationMeans = verify_text($transportationMeans, 0, 1000000);
        $review->transportationDetails = verify_text($transportationDetails, 0, 1000000, allow_null: true);
        $review->accommodationType = verify_text($accommodationType, 0, 1000000);
        $review->accommodationDetails = verify_text($accommodationDetails, 0, 1000000);
        $review->accommodationCost = verify_text($accommodationCost, 0, 1000000);
        $review->livingCost = verify_text($livingCost, 0, 1000000);
        $review->financialAid = verify_text($financialAid, 0, 1000000);
        $review->neededToOpenBankAccount = verify_bool($neededToOpenBankAccount);
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