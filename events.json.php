<?php
  try {
  require_once 'config.php';

  $oConnection = new PDO("mysql:host=$strDbHost;dbname=$strDbName", $strDbUsername, $strDbPassword);

  $strAction = ((isset($_REQUEST['action']) && !empty($_REQUEST['action'])) ? $_REQUEST['action'] : null);

  switch ($strAction) {
    case 'savePreference': 
      $iEventId = ((isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? (int) $_REQUEST['id'] : null);
      $iState = ((isset($_REQUEST['id']) && !empty($_REQUEST['status'])) ? (int) $_REQUEST['status'] : 0);
      if (!empty($iEventId)) {
        $sql = sprintf("UPDATE $strTablename SET status = %d WHERE id = %d",
          $iState, $iEventId);

        $bResult = false;
        if ($oConnection->query($sql)) {
          $bResult = true;
        }

        echo json_encode(array('success' => (($bResult == true) ? true : false)));
        exit;
      }
      break;
    default: 
      $start = $_REQUEST['from'] / 1000;
      $end   = $_REQUEST['to'] / 1000;

      $sql   = sprintf("SELECT * FROM $strTablename WHERE DATE_FORMAT(started_at, '%s') BETWEEN %s and %s",
        "%Y-%m-%d", $oConnection->quote(date('Y-m-d', $start)), $oConnection->quote(date('Y-m-d', $end)));

        $out = array();
        foreach($oConnection->query($sql) as $row) {
          $out[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'title' => $row['title'],
            'abstract' => $row['abstract'],
            'status' => $row['status'],
            'url' => null,
            'start' => strtotime($row['started_at']) . '000', 
            'end' => strtotime($row['finish_at']) . '000', 
            'start_hour_custom' => date("H:i", strtotime($row['started_at'])), 
            'end_hour_custom' => date("H:i", strtotime($row['finish_at'])), 
            'month_date' => date("Y-m-d", strtotime($row['started_at'])), 
          );
        }

        echo json_encode(array('success' => 1, 'result' => $out));
        exit;
      break;
  }
} catch (Exception $ex) {

}
