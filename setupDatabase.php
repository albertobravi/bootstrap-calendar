<?php
require_once 'config.php';

/**
 * params for setup db
 */
$strStartDate = '2014-11-01';
$strEndDate = '2015-04-30';

$strStartHour = '09:00:00';
$strEndHour = '18:00:00';

// set "true" for enable
// set "false" for disable
$bWeekDaysCheck = false;

// 1 (for Monday)
// 2 (for Tuesday)
// 3 (for Wednesday)
// 4 (for Thursday)
// 5 (for Friday)
// 6 (for Saturday) 
// 7 (for Sunday)
$aWeekDaysToExclude = array(6, 7);

$iDefaultStatus = 0;



$oConnection = new PDO("mysql:host=$strDbHost;dbname=$strDbName", $strDbUsername, $strDbPassword);

$oTruncateStatement = $oConnection->prepare("TRUNCATE TABLE $strTablename;");
$oTruncateStatement->execute();



$oDayBegin = new DateTime($strStartDate);
$oDayEnd = new DateTime($strEndDate);
$oDayEnd->modify("+1 day");

$oDayInterval = new DateInterval('P1D');
$oDataRange = new DatePeriod($oDayBegin, $oDayInterval, $oDayEnd);

$i = 1;
foreach ($oDataRange as $oDayDate) {
  if ($bWeekDaysCheck == true && in_array($oDayDate->format("N"), $aWeekDaysToExclude)) {
    continue;
  }

  $oHourBegin = new DateTime($oDayDate->format("Y-m-d") . ' ' . $strStartHour);
  $oHourEnd = new DateTime($oDayDate->format("Y-m-d") . ' ' . $strEndHour);

  $oHourInterval = new DateInterval('PT1H');
  $oHourRange = new DatePeriod($oHourBegin, $oHourInterval, $oHourEnd);

  foreach ($oHourRange as $oHourDate) {
    $oStatement = $oConnection->prepare("
      INSERT INTO $strTablename (name, title, abstract, status, started_at, finish_at, created_at) VALUES 
      (:name, :title, :abstract, :status, :started_at, :finish_at, :created_at);");
    $oStatement->bindParam(':name', $name);
    $oStatement->bindParam(':title', $title);
    $oStatement->bindParam(':abstract', $abstract);
    $oStatement->bindParam(':status', $iStatus);
    $oStatement->bindParam(':started_at', $startedAt);
    $oStatement->bindParam(':finish_at', $finishAt);
    $oStatement->bindParam(':created_at', $createdAt);

    $name = $oHourDate->format("Y_m_d_H_i");
    $title = "Evento $i";
    $abstract = "Lorem ipsum dolor sit amet, consectetur adipisicing elit";
    $iStatus = $iDefaultStatus;
    $startedAt = $oHourDate->format("Y-m-d H:i:s");
    $finishAt = $oHourDate->modify("+1 hour")->format("Y-m-d H:i:s");
    $createdAt = time();

    $oStatement->execute();

    $i++;
  }
}



echo "Database initialized.";
