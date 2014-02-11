<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();

if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {
  include __DIR__ . '/DataMPR.php';
  $_SESSION['LifeTime']  = time();
  //$AjaxResp['OldFormToken'] = $_SESSION['OldFormToken'];
  $AjaxResp['FormToken'] = $_SESSION['FormToken'];
  $AjaxResp['Msg']       = $_SESSION['Msg'];
  //$AjaxResp['CheckVal']  = $_SESSION['CheckVal'];
  $_SESSION['Msg']       = '';
  $AjaxResp['Done']      = count($_POST);
  $AjaxResp['Value']     = $_POST;
  echo json_encode($AjaxResp);
  exit();
}
header("HTTP/1.1 404 Not Found");
?>
