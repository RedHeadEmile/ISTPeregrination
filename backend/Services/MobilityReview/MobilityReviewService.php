<?php

namespace ISTPeregrination\Services\MobilityReview;

use ISTPeregrination\Common\SingletonTrait;
use ISTPeregrination\Services\Database\DatabaseService;
use ISTPeregrination\Services\MobilityReview\Models\MobilityReviewModel;
use PDO;

class MobilityReviewService implements IMobilityReviewService
{
    use SingletonTrait;

    public function __construct()
    {
    }

    public function getAllMobilityReviews(): array
    {
        $reviews = [];
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("SELECT * FROM `mobilityreview`");
        $results = $stmt->fetchAll(PDO::FETCH_NAMED);
        foreach ($results as $result) {
            $reviews[] = MobilityReviewModel::fromDatabaseRecord($result);
        }
        return $reviews;
    }

    public function submitMobilityReview(MobilityReviewModel $model): void
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare(
            "INSERT INTO `mobilityreview` (reviewd, firstname, lastname, sector, mobilityyear, allowcontact, 
                              email, linkedin, countrycode, city, hostorganization, ismobilityprofessional, 
                              contractstatuswhilemobility, contractstatusdetailswhilemobility, mobilityperiod, 
                              hadbreaks, breaksdetails, neededvisa, visadetails, visadelaysforasking, visatips, 
                              visacost, vaccinationdetails, transportationmeans, transportationdetails, 
                              accommodationtype, accommodationdetails, accomodationcost, livingcost, financialaid, 
                              neededtoopenbankaccount, spokenlanguage, languagelevel, integration, 
                              prosandconsofthecountry, tipsforthecountry, whatwouldyouchange, 
                              adviceforfuturemobilitystudents)
                    VALUES(0, :firstname, :lastname, :sector, :mobilityyear, :allowcontact, :email, :linkedin, 
                           :countrycode, :city, :hostorganization, :ismobilityprofessional, 
                           :contractstatuswhilemobility, :contractstatusdetailswhilemobility, :mobilityperiod, 
                           :hadbreaks, :breaksdetails, :neededvisa, :visadetails, :visadelaysforasking, :visatips, 
                           :visacost, :vaccinationdetails, :transportationmeans, :transportationdetails, 
                           :accommodationtype, :accommodationdetails, :accomodationcost, :livingcost, :financialaid, 
                           :neededtoopenbankaccount, :spokenlanguage, :languagelevel, :integration, 
                           :prosandconsofthecountry, :tipsforthecountry, :whatwouldyouchange, 
                           :adviceforfuturemobilitystudents);");
        $stmt->execute([
            'firstname' => $model->firstname,
            'lastname' => $model->lastname,
            'sector' => $model->sector,
            'mobilityyear' => $model->mobilityYear,
            'allowcontact' => $model->allowContacts,
            'email' => $model->email,
            'linkedin' => $model->linkedin,
            'countrycode' => $model->countryCode,
            'city' => $model->city,
            'hostorganization' => $model->hostOrganization,
            'ismobilityprofessional' => $model->isMobilityProfessional,
            'contractstatuswhilemobility' => $model->contractStatusWhileMobility,
            'contractstatusdetailswhilemobility' => $model->contractStatusDetailsWhileMobility,
            'mobilityperiod' => $model->mobilityPeriod,
            'hadbreaks' => $model->hadBreaks,
            'breaksdetails' => $model->breaksDetails,
            'neededvisa' => $model->neededVisa,
            'visadetails' => $model->visaDetails,
            'visadelaysforasking' => $model->visaDelaysForAsking,
            'visatips' => $model->visaTips,
            'visacost' => $model->visaCost,
            'vaccinationdetails' => $model->vaccinationDetails,
            'transportationmeans' => $model->transportationMeans,
            'transportationdetails' => $model->transportationDetails,
            'accommodationtype' => $model->accommodationType,
            'accommodationdetails' => $model->accommodationDetails,
            'accomodationcost' => $model->accommodationCost,
            'livingcost' => $model->livingCost,
            'financialaid' => $model->financialAid,
            'neededtoopenbankaccount' => $model->neededToOpenBankAccount,
            'spokenlanguage' => $model->spokenLanguage,
            'languagelevel' => $model->languageLevel,
            'integration' => $model->integration,
            'prosandconsofthecountry' => $model->prosAndConsOfTheCountry,
            'tipsforthecountry' => $model->tipsForTheCountry,
            'whatwouldyouchange' => $model->whatWouldYouChange,
            'adviceforfuturemobilitystudents' => $model->adviceForFutureMobilityStudents
        ]);

        $lastInsertId = DatabaseService::getInstance()->getPDO()->lastInsertId();
        if ($lastInsertId === false)
            throw new \RuntimeException("Failed to retrieve last insert id after user registration");

        $model->id = intval($lastInsertId);
    }

    public function approveMobilityReview(int $reviewId): void
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("UPDATE `mobilityreview` SET `reviewd` = 1 WHERE `idmobilityreviewid` = ?");
        $stmt->execute([$reviewId]);
    }

    public function deleteMobilityReview(int $reviewId): void
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("DELETE FROM `mobilityreview` WHERE `idmobilityreviewid` = ?");
        $stmt->execute([$reviewId]);
    }
}