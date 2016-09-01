<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 24/08/16
 * Time: 12:19
 */

namespace Voximplant\VideoConf;


class ActionType
{
  const ADMIN_PORTAL_LOGIN        = 'admin_portal_login';
  const ADMIN_PORTAL_GET_CLIENTS  = 'admin_portal_get_clients';
  const ADMIN_PORTAL_REGISTER_CLIENT='admin_portal_register_client';
  const ADMIN_PORTAL_TOGGLE_CLIENT= 'admin_portal_toggle_client';
  const ADMIN_PORTAL_PAY_USER     = 'admin_portal_pay_user';
  const ADMIN_PORTAL_CREATE_USER  = 'admin_portal_create_user';

  const PANEL_LOGIN         = 'panel_login';
  const CHECK_SCRIPTS       = 'check_scripts';
}