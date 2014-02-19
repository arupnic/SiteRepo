<?php

/**
 * API For Ajax Calls from a valid authenticated session.
 *
 *
 * The JSON Object will Contain Four Top Level Nodes
 * 1. $DataResp['AjaxToken'] => Token for preventing atacks like CSRF and Sesion Hijack
 * 2. $DataResp['Data']
 * 3. $DataResp['Msg']
 * 4. $DataResp['RT'] => Response Time of the Script
 *
 * @example ($_POST=array(
 *              'CallAPI'=>'GetData',
 *              'AjaxToken'=>'$$$$')
 *
 * @return json
 *
 */
require_once ( __DIR__ . '/../lib.inc.php');
if (!isset($_SESSION)) {
  session_start();
}

if (WebLib::GetVal($_POST, 'AjaxToken') ===
    WebLib::GetVal($_SESSION, 'Token')) {
  $_SESSION['LifeTime']  = time();
  $_SESSION['RT']        = microtime(TRUE);
  $_SESSION['CheckAuth'] = 'Valid';
  $DataResp['Data']      = array();
  $DataResp['Msg']       = '';
  switch (WebLib::GetVal($_POST, 'CallAPI')) {

    case 'GetComboData':
      $Query                 = 'Select `DeptID`,`DeptName`'
          . ' FROM `' . MySQL_Pre . 'MPR_Departments`'
          . ' Order by `DeptID`';
      $DataResp['DeptID']    = array();
      doQuery($DataResp['DeptID'], $Query);
      $Query                 = 'Select `SectorID`,`SectorName`'
          . ' FROM `' . MySQL_Pre . 'MPR_Sectors`'
          . ' Order by `SectorName`';
      $DataResp['SectorID']  = array();
      doQuery($DataResp['SectorID'], $Query);
      $Query                 = 'Select `SchemeID`,`SchemeName`,`SectorID`,`DeptID`'
          . ' FROM `' . MySQL_Pre . 'MPR_Schemes`'
          . ' Order by `SchemeName`';
      $DataResp['SchemeID']  = array();
      doQuery($DataResp['SchemeID'], $Query);
      $Query                 = 'Select `ProjectID`,`ProjectName`,`SchemeID`'
          . ' FROM `' . MySQL_Pre . 'MPR_Projects`'
          . ' Order by `ProjectID`';
      $DataResp['ProjectID'] = array();
      doQuery($DataResp['ProjectID'], $Query);

//      $Query                 = 'Select `ProjectID`,`ProjectName`,`SchemeID`'
//          . ' FROM `' . MySQL_Pre . 'MPR_Projects`'
//          . ' Order by `ProjectID`';
//      $DataResp['ProjectID'] = $Data->rawQuery($Query);
      break;

    case 'GetProjectData':
      $Query               = 'Select `SchemeID`,`SchemeName`'
          . ' FROM `' . MySQL_Pre . 'MPR_Schemes`'
          . ' Order by `SchemeName`';
      $DataResp['Schemes'] = array();
      doQuery($DataResp['Schemes'], $Query);

      $Query                = 'Select * FROM `' . MySQL_Pre . 'MPR_Progress`'
          . ' Order by `ReportID` DESC';
      $DataResp['Progress'] = array();
      doQuery($DataResp['Progress'], $Query);
//      $_SESSION['OldPhysicalProgress']  = $DataResp['Progress']['PhysicalProgress'];
//      $_SESSION['OldFinancialProgress'] = $DataResp['Progress']['FinancialProgress'];
      break;

    case 'GetChosenData':

      $Query                = 'Select `DeptID`,`DeptName`'
          . ' FROM `' . MySQL_Pre . 'MPR_Departments`'
          . ' Order by `DeptID`';
      $DataResp['DeptID']   = array();
      doQuery($DataResp['DeptID'], $Query);
      $Query                = 'Select `SectorID`,`SectorName`'
          . ' FROM `' . MySQL_Pre . 'MPR_Sectors`'
          . ' Order by `SectorName`';
      $DataResp['SectorID'] = array();
      doQuery($DataResp['SectorID'], $Query);
      $Query                = 'Select `BlockID`,`BlockName`'
          . ' FROM `' . MySQL_Pre . 'MPR_Blocks`'
          . ' Order by `BlockID`';
      $DataResp['BlockID']  = array();
      doQuery($DataResp['BlockID'], $Query);
      break;
    /*
      ;

     */
    case 'GetReportTable':
      $_SESSION['POST']     = $_POST;
      $Query                = 'SELECT S.SchemeID, S.SchemeName , P.ReportDate,'
          . ' P.PhysicalProgress, P.FinancialProgress,P.Remarks '
          . ' FROM ' . MySQL_Pre . 'MPR_Schemes S'
          . ' INNER JOIN ' . MySQL_Pre . 'MPR_Progress P'
          . ' ON S.SchemeID=P.SchemeID';
      doQuery($DataResp, $Query, array(WebLib::GetVal($_POST, 'ReportID')));
      break;

    default :
      $DataResp['Msg'] = 'Invalid API Call';
      break;
  }

  $_SESSION['LifeTime'] = time();

  $DataResp['RT'] = '<b>Response Time:</b> '
      . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';
  //PHP 5.4+ is required for JSON_PRETTY_PRINT
  //@todo Remove PRETTY_PRINT for Production
  if (strnatcmp(phpversion(), '5.4') >= 0) {
    $AjaxResp = json_encode($DataResp, JSON_PRETTY_PRINT);
  } else {
    $AjaxResp = json_encode($DataResp); //WebLib::prettyPrint(json_encode($DataResp));
  }
  unset($DataResp);

  header('Content-Type: application/json');
  header('Content-Length: ' . strlen($AjaxResp));
  echo $AjaxResp;
  exit();
} else {
  $_SESSION['LifeTime'] = time();
  $DataResp['Msg']      = 'Invalid Ajax Token';
  $DataResp['RT']       = '<b>Response Time:</b> '
      . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';
  //PHP 5.4+ is required for JSON_PRETTY_PRINT
  //@todo Remove PRETTY_PRINT for Production
  if (strnatcmp(phpversion(), '5.4') >= 0) {
    $AjaxResp = json_encode($DataResp, JSON_PRETTY_PRINT);
  } else {
    $AjaxResp = json_encode($DataResp); //WebLib::prettyPrint(json_encode($DataResp));
  }
  unset($DataResp);

  header('Content-Type: application/json');
  header('Content-Length: ' . strlen($AjaxResp));
  echo $AjaxResp;
  exit();
}
header("HTTP/1.1 404 Not Found");
exit();

/**
 * Perfroms Select Query to the database
 *
 * @param ref     $DataResp
 * @param string  $Query
 * @param array   $Params
 * @example GetData(&$DataResp, "Select a,b,c from Table Where c=? Order By b LIMIT ?,?", array('1',30,10))
 */
function doQuery(&$DataResp,
                 $Query,
                 $Params = NULL) {
  $Data             = new MySQLiDBHelper();
  $Result           = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg']  = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}

?>