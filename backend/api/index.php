<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__.'/../config/bootstrap.php';
use \Voximplant\VideoConf\ExportableError;
use \Voximplant\VideoConf\ActionType;
use \Voximplant\VideoConf\Actions;

foreach ($_POST as $key=>$value){
  $_GET[$value]= $key;
}
$response = $_GET;
$actions = new Actions($entityManager);
if(!empty($response['action'])){
  switch ($response['action']){
    case(ActionType::ADMIN_PORTAL_LOGIN):
      die(json_encode($actions->doAdminPortalLogin($response)));
      break;
    case(ActionType::ADMIN_PORTAL_GET_CLIENTS):
      die(json_encode($actions->doGetClients($response)));
      break;
    case(ActionType::ADMIN_PORTAL_REGISTER_CLIENT):
      die(json_encode($actions->doEditClient($response)));
      break;
    case(ActionType::ADMIN_PORTAL_TOGGLE_CLIENT):
      die(json_encode($actions->doToggleClientActive($response)));
      break;
    case(ActionType::ADMIN_PORTAL_PAY_USER):
      die(json_encode($actions->doPayUser($response)));
      break;
    case(ActionType::CHECK_SCRIPTS):
      break;
    default:
      die(json_encode(ExportableError::NoActionFound()));
  }
}
die(json_encode(ExportableError::NoActionSet()));