<?php
require_once __DIR__.'/../config/bootstrap.php';
use \Voximplant\VideoConf\ExportableError;
use \Voximplant\VideoConf\ActionType;

foreach ($_POST as $key=>$value){
  $_GET[$value]= $key;
}
$response = $_GET;
if(!empty($response['action'])){
  switch ($response['action']){
    case(ActionType::ADMIN_PORTAL_LOGIN):

      break;
    case(ActionType::PANEL_LOGIN):
      break;
    case(ActionType::CHECK_SCRIPTS):
      break;
    default:
      die(json_encode(ExportableError::NoActionFound()));
  }
}
die(json_encode(ExportableError::NoActionSet()));