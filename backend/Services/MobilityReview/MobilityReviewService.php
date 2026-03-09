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

    public function getAllMobilityReviews(bool $onlyReviewed): array
    {
        $reviews = [];
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("SELECT * FROM `mobilityreview` WHERE `reviewed` > ? ORDER BY reviewed");
        $stmt->bindValue(1, $onlyReviewed ? 0 : -1, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_NAMED);
        foreach ($results as $result) {
            $reviews[] = MobilityReviewModel::fromDatabaseRecord($result);
        }
        return $reviews;
    }

    public function submitMobilityReview(MobilityReviewModel $model): void
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare(
            "INSERT INTO `mobilityreview` (reviewed, firstname, lastname, sector, mobilityyear, allowcontact, 
                              email, linkedin, countrycode, city, hostorganization, ismobilityprofessional, 
                              contractstatuswhilemobility, contractstatusdetailswhilemobility, mobilityperiod, 
                              hadbreaks, breaksbefore, breakswhile, breaksafter, neededvisa, visadetails, 
                              visadelaysforasking, visatips, visacost, vaccinationdetails, transportationmeans, 
                              transportationdetails, accommodationisuniversity, accommodationisshared, 
                              accommodationisstudio, accommodationissomeone, accommodationisyouthhostel, 
                              accommodationdetails, accomodationcost, livingcost, financialaid, neededtoopenbankaccount, 
                              spokenlanguage, languagelevel, integration, prosandconsofthecountry, tipsforthecountry, 
                              whatwouldyouchange, adviceforfuturemobilitystudents)
                    VALUES(0, :firstname, :lastname, :sector, :mobilityyear, :allowcontact, :email, :linkedin, 
                           :countrycode, :city, :hostorganization, :ismobilityprofessional, 
                           :contractstatuswhilemobility, :contractstatusdetailswhilemobility, :mobilityperiod, 
                           :hadbreaks, :breaksbefore, :breakswhile, :breaksafter, :neededvisa, :visadetails, 
                           :visadelaysforasking, :visatips, :visacost, :vaccinationdetails, :transportationmeans, 
                           :transportationdetails, :accommodationisuniversity, :accommodationisshared, 
                           :accommodationisstudio, :accommodationissomeone, :accommodationisyouthhostel, 
                           :accommodationdetails, :accomodationcost, :livingcost, :financialaid, 
                           :neededtoopenbankaccount, :spokenlanguage, :languagelevel, :integration, 
                           :prosandconsofthecountry, :tipsforthecountry, :whatwouldyouchange, 
                           :adviceforfuturemobilitystudents);");
        $stmt->bindValue(':firstname', $model->firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $model->lastname, PDO::PARAM_STR);
        $stmt->bindValue(':sector', $model->sector, PDO::PARAM_STR);
        $stmt->bindValue(':mobilityyear', $model->mobilityYear, PDO::PARAM_STR);
        $stmt->bindValue(':allowcontact', $model->allowContacts, PDO::PARAM_BOOL);
        $stmt->bindValue(':email', $model->email, PDO::PARAM_STR);
        $stmt->bindValue(':linkedin', $model->linkedin, PDO::PARAM_STR);
        $stmt->bindValue(':countrycode', $model->countryCode, PDO::PARAM_STR);
        $stmt->bindValue(':city', $model->city, PDO::PARAM_STR);
        $stmt->bindValue(':hostorganization', $model->hostOrganization, PDO::PARAM_STR);
        $stmt->bindValue(':ismobilityprofessional', $model->isMobilityProfessional, PDO::PARAM_BOOL);
        $stmt->bindValue(':contractstatuswhilemobility', $model->contractStatusWhileMobility, PDO::PARAM_INT);
        $stmt->bindValue(':contractstatusdetailswhilemobility', $model->contractStatusDetailsWhileMobility, PDO::PARAM_STR);
        $stmt->bindValue(':mobilityperiod', $model->mobilityPeriod, PDO::PARAM_STR);
        $stmt->bindValue(':hadbreaks', $model->hadBreaks, PDO::PARAM_BOOL);
        $stmt->bindValue(':breaksbefore', $model->breaksBefore, PDO::PARAM_BOOL);
        $stmt->bindValue(':breakswhile', $model->breaksWhile, PDO::PARAM_BOOL);
        $stmt->bindValue(':breaksafter', $model->breaksAfter, PDO::PARAM_BOOL);
        $stmt->bindValue(':neededvisa', $model->neededVisa, PDO::PARAM_BOOL);
        $stmt->bindValue(':visadetails', $model->visaDetails, PDO::PARAM_STR);
        $stmt->bindValue(':visadelaysforasking', $model->visaDelaysForAsking, PDO::PARAM_STR);
        $stmt->bindValue(':visatips', $model->visaTips, PDO::PARAM_STR);
        $stmt->bindValue(':visacost', $model->visaCost, PDO::PARAM_STR);
        $stmt->bindValue(':vaccinationdetails', $model->vaccinationDetails, PDO::PARAM_STR);
        $stmt->bindValue(':transportationmeans', $model->transportationMeans, PDO::PARAM_STR);
        $stmt->bindValue(':transportationdetails', $model->transportationDetails, PDO::PARAM_STR);
        $stmt->bindValue(':accommodationisuniversity', $model->accommodationIsUniversity, PDO::PARAM_BOOL);
        $stmt->bindValue(':accommodationisshared', $model->accommodationIsShared, PDO::PARAM_BOOL);
        $stmt->bindValue(':accommodationisstudio', $model->accommodationIsStudio, PDO::PARAM_BOOL);
        $stmt->bindValue(':accommodationissomeone', $model->accommodationIsSomeone, PDO::PARAM_BOOL);
        $stmt->bindValue(':accommodationisyouthhostel', $model->accommodationIsYouthHostel, PDO::PARAM_BOOL);
        $stmt->bindValue(':accommodationdetails', $model->accommodationDetails, PDO::PARAM_STR);
        $stmt->bindValue(':accomodationcost', $model->accommodationCost, PDO::PARAM_STR);
        $stmt->bindValue(':livingcost', $model->livingCost, PDO::PARAM_STR);
        $stmt->bindValue(':financialaid', $model->financialAid, PDO::PARAM_STR);
        $stmt->bindValue(':neededtoopenbankaccount', $model->neededToOpenBankAccount, PDO::PARAM_STR);
        $stmt->bindValue(':spokenlanguage', $model->spokenLanguage, PDO::PARAM_STR);
        $stmt->bindValue(':languagelevel', $model->languageLevel, PDO::PARAM_STR);
        $stmt->bindValue(':integration', $model->integration, PDO::PARAM_STR);
        $stmt->bindValue(':prosandconsofthecountry', $model->prosAndConsOfTheCountry, PDO::PARAM_STR);
        $stmt->bindValue(':tipsforthecountry', $model->tipsForTheCountry, PDO::PARAM_STR);
        $stmt->bindValue(':whatwouldyouchange', $model->whatWouldYouChange, PDO::PARAM_STR);
        $stmt->bindValue(':adviceforfuturemobilitystudents', $model->adviceForFutureMobilityStudents, PDO::PARAM_STR);
        $stmt->execute();

        $lastInsertId = DatabaseService::getInstance()->getPDO()->lastInsertId();
        if ($lastInsertId === false)
            throw new \RuntimeException("Failed to retrieve last insert id after user registration");

        $model->id = intval($lastInsertId);
    }

    public function approveMobilityReview(int $reviewId): void
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("UPDATE `mobilityreview` SET `reviewed` = 1 WHERE `mobilityreviewid` = ?");
        $stmt->execute([$reviewId]);
    }

    public function deleteMobilityReview(int $reviewId): void
    {
        $stmt = DatabaseService::getInstance()->getPDO()->prepare("DELETE FROM `mobilityreview` WHERE `mobilityreviewid` = ?");
        $stmt->execute([$reviewId]);
    }
}