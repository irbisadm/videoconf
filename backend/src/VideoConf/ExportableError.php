<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 24/08/16
 * Time: 11:53
 */

namespace Voximplant\VideoConf;

class ExportableError
{
  static function NoActionFound(){
    return [
      'response'=>"error",
      'code'=>ExportableErrorCode::NO_ACTION_FOUND,
      'message'=>"No one action found for you"
    ];
  }
  static function NoActionSet(){
    return [
      'response'=>"error",
      'code'=>ExportableErrorCode::NO_ACTION_SET,
      'message'=>"You not set action"
    ];
  }
  static function WrongIncomParams(){
    return [
      'response'=>"error",
      'code'=>ExportableErrorCode::WRONG_INCOM_PARAMS,
      'message'=>"Wrong income params count"
    ];
  }
  static function PortalNotFound(){
    return [
      'response'=>"error",
      'code'=>ExportableErrorCode::PORTAL_NOT_FOUND,
      'message'=>"Portal not found"
    ];
  }
  static function ServiceUserNotFound(){
    return [
      'response'=>"error",
      'code'=>ExportableErrorCode::SERVICE_USER_NOT_FOUND,
      'message'=>"Service User not found"
    ];
  }
  static function VoxError($error){
    return [
      'response'=>"error",
      'code'=>$error->code,
      'message'=>$error->msg,
    ];
  }
  static function PasswordNotEqual(){
    return [
      'response'=>"error",
      'code'=>ExportableErrorCode::PASSWORDS_NOT_EQUAL,
      'message'=>"Password not equal"
    ];
  }
}