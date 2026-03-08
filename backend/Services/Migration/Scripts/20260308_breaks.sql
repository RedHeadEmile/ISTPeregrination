ALTER TABLE `mobilityreview`
    DROP COLUMN `breaksdetails`,
    ADD COLUMN `breaksbefore` TINYINT(1) UNSIGNED NULL AFTER `hadbreaks`,
    ADD COLUMN `breakswhile` TINYINT(1) UNSIGNED NULL AFTER `breaksbefore`,
    ADD COLUMN `breaksafter` TINYINT(1) UNSIGNED NULL AFTER `breakswhile`;

ALTER TABLE `mobilityreview`
    DROP COLUMN `accommodationtype`,
    ADD COLUMN `accommodationisuniversity` TINYINT(1) UNSIGNED NULL AFTER `transportationdetails`,
    ADD COLUMN `accommodationisshared` TINYINT(1) UNSIGNED NULL AFTER `accommodationisuniversity`,
    ADD COLUMN `accommodationisstudio` TINYINT(1) UNSIGNED NULL AFTER `accommodationisshared`,
    ADD COLUMN `accommodationissomeone` TINYINT(1) UNSIGNED NULL AFTER `accommodationisstudio`,
    ADD COLUMN `accommodationisyouthhostel` TINYINT(1) UNSIGNED NULL AFTER `accommodationissomeone`;

ALTER TABLE `mobilityreview`
    CHANGE COLUMN `neededtoopenbankaccount` `neededtoopenbankaccount` TEXT NOT NULL;

ALTER TABLE `mobilityreview`
    CHANGE COLUMN `idmobilityreviewid` `mobilityreviewid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ;

ALTER TABLE `mobilityreview`
    CHANGE COLUMN `reviewd` `reviewed` TINYINT UNSIGNED NOT NULL ;
