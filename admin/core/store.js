/**
 * React Static Boilerplate
 * https://github.com/koistya/react-static-boilerplate
 *
 * Copyright © 2015-2016 Konstantin Tarkus (@koistya)
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import { createStore } from 'redux';

/**
 * Centralized application state
 * See http://redux.js.org/
 */

const cachedState = JSON.parse(localStorage.getItem('cache'));
let defaultState = {};
if(cachedState!=null){
  defaultState = {...cachedState};
}else{
  defaultState = {
    auth : false,
    auth_error: false,
    auth_msg: "",
    session_id :0,
    api_key:0,
    account_id:0,
    balance:0,
    auth_inprogress: false
  };
}
const ceed = Math.round(100000000 + Math.random() * (999999999 - 100000000));

const store = createStore((state=defaultState, params) => {
  // TODO: Add action handlers (aka "reduces")
  let newState = {};
  switch (params.type) {
    case 'LOGIN_OK':
      newState = { ...state,
        auth: true,
        auth_error: false,
        auth_msg: "",
        session_id:params.result,
        api_key:params.api_key,
        account_id:params.account_id,
        balance:params.balance,
        auth_inprogress: false};
      localStorage.setItem('last',ceed);
      localStorage.setItem('cache',JSON.stringify(newState));
      return newState;
    case 'BALANCE_UPD':
      newState = { ...state,
        balance:params.balance};
      localStorage.setItem('last',ceed);
      localStorage.setItem('cache',JSON.stringify(newState));
      return newState;
    case 'LOGIN_START':
      newState =  { ...state, auth_inprogress: true};
      localStorage.setItem('last',ceed);
      localStorage.setItem('cache',JSON.stringify(newState));
      return newState;
    case 'LOGIN_ERR':
      newState =  { ...state, auth: false,
        auth_error: true,
        auth_msg: params.msg,
        auth_inprogress: false};
      localStorage.setItem('last',ceed);
      localStorage.setItem('cache',JSON.stringify(newState));
      return newState;
    case 'LOGOUT':
      newState = { ...state,
        auth: false,
        auth_error: false,
        auth_msg: "",
        session_id:0,
        api_key:0,
        account_id:0,
        auth_inprogress: false};
      localStorage.setItem('last',ceed);
      localStorage.setItem('cache',JSON.stringify(newState));
      return newState;
    case 'EDITED_OTHER':
      if(localStorage.getItem('last')==ceed)
        return state;
      return {
        auth: params.value.auth,
        auth_error: params.value.auth_error,
        auth_msg: params.value.auth_msg,
        session_id:params.value.session_id,
        api_key:params.value.api_key,
        account_id:params.value.account_id,
        auth_inprogress: params.value.auth_inprogress,
      };
    default:
      return state;
  }
});

export default store;