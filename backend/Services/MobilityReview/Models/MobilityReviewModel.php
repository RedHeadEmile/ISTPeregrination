<?php

namespace ISTPeregrination\Services\MobilityReview\Models;

class MobilityReviewModel
{
    public int $id;
    public bool $reviewed;
    public ?string $firstname;
    public ?string $lastname;
    public string $sector;
    public string $mobilityYear;
    public bool $allowContacts;
    public ?string $email;
    public ?string $linkedin;
    public string $countryCode;
    public string $city;
    public string $hostOrganization;
    public bool $isMobilityProfessional;
    public int $contractStatusWhileMobility;
    public ?string $contractStatusDetailsWhileMobility;
    public string $mobilityPeriod;
    public bool $hadBreaks;
    public ?string $breaksDetails;
    public bool $neededVisa;
    public ?string $visaDetails;
    public ?string $visaDelaysForAsking;
    public ?string $visaTips;
    public ?string $visaCost;
    public ?string $vaccinationDetails;
    public string $transportationMeans;
    public ?string $transportationDetails;
    public string $accommodationType;
    public ?string $accommodationDetails;
    public string $accommodationCost;
    public string $livingCost;
    public string $financialAid;
    public bool $neededToOpenBankAccount;
    public string $spokenLanguage;
    public string $languageLevel;
    public string $integration;
    public string $prosAndConsOfTheCountry;
    public string $tipsForTheCountry;
    public string $whatWouldYouChange;
    public string $adviceForFutureMobilityStudents;

    public function __construct()
    {
    }
    public function getAsViewModel(): array {
        return [
            'id' => $this->id,
            'reviewed' => $this->reviewed,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'sector' => $this->sector,
            'mobilityYear' => $this->mobilityYear,
            'allowContacts' => $this->allowContacts,
            'email' => $this->email,
            'linkedin' => $this->linkedin,
            'countryCode' => $this->countryCode,
            'city' => $this->city,
            'hostOrganization' => $this->hostOrganization,
            'isMobilityProfessional' => $this->isMobilityProfessional,
            'contractStatusWhileMobility' => $this->contractStatusWhileMobility,
            'contractStatusDetailsWhileMobility' => $this->contractStatusDetailsWhileMobility,
            'mobilityPeriod' => $this->mobilityPeriod,
            'hadBreaks' => $this->hadBreaks,
            'breaksDetails' => $this->breaksDetails,
            'neededVisa' => $this->neededVisa,
            'visaDetails' => $this->visaDetails,
            'visaDelaysForAsking' => $this->visaDelaysForAsking,
            'visaTips' => $this->visaTips,
            'visaCost' => $this->visaCost,
            'vaccinationDetails' => $this->vaccinationDetails,
            'transportationMeans' => $this->transportationMeans,
            'transportationDetails' => $this->transportationDetails,
            'accommodationType' => $this->accommodationType,
            'accommodationDetails' => $this->accommodationDetails,
            'accommodationCost' => $this->accommodationCost,
            'livingCost' => $this->livingCost,
            'financialAid' => $this->financialAid,
            'neededToOpenBankAccount' => $this->neededToOpenBankAccount,
            'spokenLanguage' => $this->spokenLanguage,
            'languageLevel' => $this->languageLevel,
            'integration' => $this->integration,
            'prosAndConsOfTheCountry' => $this->prosAndConsOfTheCountry,
            'tipsForTheCountry' => $this->tipsForTheCountry,
            'whatWouldYouChange' => $this->whatWouldYouChange,
            'adviceForFutureMobilityStudents' => $this->adviceForFutureMobilityStudents
        ];
    }

    public static function fromDatabaseRecord(mixed $record): MobilityReviewModel {
        $model = new MobilityReviewModel();
        $model->id = $record['id'];
        $model->reviewed = $record['reviewed'];
        $model->firstname = $record['firstname'];
        $model->lastname = $record['lastname'];
        $model->sector = $record['sector'];
        $model->mobilityYear = $record['mobilityyear'];
        $model->allowContacts = $record['allowcontacts'];
        $model->email = $record['email'];
        $model->linkedin = $record['linkedin'];
        $model->countryCode = $record['countrycode'];
        $model->city = $record['city'];
        $model->hostOrganization = $record['hostorganization'];
        $model->isMobilityProfessional = $record['ismobilityprofessional'];
        $model->contractStatusWhileMobility = $record['contractstatuswhilemobility'];
        $model->contractStatusDetailsWhileMobility = $record['contractstatusdetailswhilemobility'];
        $model->mobilityPeriod = $record['mobilityperiod'];
        $model->hadBreaks = $record['hadbreaks'];
        $model->breaksDetails = $record['breaksdetails'];
        $model->neededVisa = $record['neededvisa'];
        $model->visaDetails = $record['visadetails'];
        $model->visaDelaysForAsking = $record['visadelaysForAsking'];
        $model->visaTips = $record['visatips'];
        $model->visaCost = $record['visacost'];
        $model->vaccinationDetails = $record['vaccinationdetails'];
        $model->transportationMeans = $record['transportationmeans'];
        $model->transportationDetails = $record['transportationdetails'];
        $model->accommodationType = $record['accommodationtype'];
        $model->accommodationDetails = $record['accommodationdetails'];
        $model->accommodationCost = $record['accommodationcost'];
        $model->livingCost = $record['livingcost'];
        $model->financialAid = $record['financialaid'];
        $model->neededToOpenBankAccount = $record['neededtoopenbankaccount'];
        $model->spokenLanguage = $record['spokenlanguage'];
        $model->languageLevel = $record['languagelevel'];
        $model->integration = $record['integration'];
        $model->prosAndConsOfTheCountry = $record['prosandconsofthecountry'];
        $model->tipsForTheCountry = $record['tipsforthecountry'];
        $model->whatWouldYouChange = $record['whatwouldyouchange'];
        $model->adviceForFutureMobilityStudents = $record['adviceforfuturemobilitystudents'];
        return $model;
    }


}