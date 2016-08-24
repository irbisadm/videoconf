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
}