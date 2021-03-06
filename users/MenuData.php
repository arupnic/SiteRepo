<?php

/*
 * @ todo Fetch District AC and Parts Combo Data on seperate request via ajax
 * @todo Keep All District, AC, Parts available for parent users
 */

$Data = new MySQLiDBHelper();
$_SESSION['action'] = 0;
$Query = '';
if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
  if (WebLib::GetVal($_POST, 'FormToken') !== WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {
    // Authenticated Inputs
    switch (WebLib::GetVal($_POST, 'CmdMenuAction')) {
      case 'Allow':
        foreach ($_POST['UserMapID'] as $UserMapID) {
          foreach ($_POST['MenuID'] as $MenuID) {
            $DataACL['UserMapID'] = $UserMapID;
            $DataACL['MenuID'] = $MenuID;
            $DataACL['AllowOnly'] = 0;
            $Data->insert(MySQL_Pre . 'MenuACL', $DataACL);
          }
        }
        $_SESSION['Msg'] = 'Allowed Successfully!';
        break;
      case 'Restrict':
        foreach ($_POST['UserMapID'] as $UserMapID) {
          foreach ($_POST['MenuID'] as $MenuID) {
            $DataACL['AllowOnly'] = 1;
            $Data->where('UserMapID', $UserMapID);
            $Data->where('MenuID', $MenuID);
            $Data->update(MySQL_Pre . 'MenuACL', $DataACL);
          }
        }
        $_SESSION['Msg'] = 'Restricted Successfully!';
        break;
      case 'Activate':
        foreach ($_POST['UserMapID'] as $UserMapID) {
          foreach ($_POST['MenuID'] as $MenuID) {
            $DataACL['AllowOnly'] = 1;
            $Data->where('UserMapID', $UserMapID);
            $Data->where('MenuID', $MenuID);
            $Data->update(MySQL_Pre . 'MenuACL', $DataACL);
          }
        }
        $_SESSION['Msg'] = 'Activated Successfully!';
        break;
      case 'Deactivate':
        foreach ($_POST['UserMapID'] as $UserMapID) {
          foreach ($_POST['MenuID'] as $MenuID) {
            $DataACL['AllowOnly'] = 1;
            $Data->where('UserMapID', $UserMapID);
            $Data->where('MenuID', $MenuID);
            $Data->delete(MySQL_Pre . 'MenuACL', $DataACL);
          }
        }
        $_SESSION['Msg'] = 'Deactivated Successfully!';
        break;
    }
    if ($Query !== '') {
      $Inserted = $Data->do_ins_query($Query);
      if ($Inserted > 0) {
        if (WebLib::GetVal($_POST, 'CmdSubmit') === 'Create') {
          $_SESSION['Msg'] = 'User Created Successfully!';
        } else if (WebLib::GetVal($User, 1)) {
          $GmailResp = GMailSMTP($User[1], $User[0], $Subject, $Body);
          $Mail = json_decode($GmailResp);
          if ($Mail->Sent) {
            if (WebLib::GetVal($_SESSION, 'Msg') === '') {
              $_SESSION['Msg'] = 'User ' . WebLib::GetVal($_POST, 'CmdSubmit') . 'd Successfully!';
            }
          } else {
            $_SESSION['Msg'] = 'Action completed Successfully! But Unable to Send eMail!';
          }
        }
      } else {
        $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdSubmit') . '!';
      }
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
unset($Mail);
unset($GmailResp);
unset($Data);
?>
