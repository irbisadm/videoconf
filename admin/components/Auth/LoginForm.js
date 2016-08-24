/**
 * Created by irbisadm on 15/08/16.
 */
import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import s from './LoginForm.css';


class LoginForm extends React.Component {

  constructor(props,context,updater){
    super(props,context,updater);
    this.state = {
      login:'',
      pass:''
    };
  }
  componentDidMount() {
    if(typeof this.refs.login != "undefined") {
      window.componentHandler.upgradeElement(this.refs.login);
      window.componentHandler.upgradeElement(this.refs.email);
    }
  }

  componentWillUnmount(){
    if(typeof this.refs.login != "undefined"){
      window.componentHandler.downgradeElements(this.refs.login);
      window.componentHandler.downgradeElements(this.refs.email);
    }
  }

  render() {
    if(this.props.auth){
      return(<div className="js_auth_ok"></div>);
    }
    return (
      <div className={s.fullpage+" mdl-grid"}>
        <div className="mdl-cell mdl-cell--4-col mdl-cell--1-col-phone"></div>
        <div className={s.hflex+" mdl-cell mdl-cell--4-col mdl-cell--10-col-phone"}>
          <div className={this.props.auth_error?s.errorline:s.hiddenline}>
            {this.props.auth_msg}
          </div>
          <div className={s.inputline}>
            <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ref="login">
              <input className="mdl-textfield__input" type="text" id="loginEmail" value={this.state.login}
                     onChange={(e) => {
                       this.setState({login: e.target.value});
                     }}/>
              <label className="mdl-textfield__label" htmlFor="loginEmail">Email</label>
            </div>
          </div>
          <div className={s.inputline}>
            <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ref="email">
              <input className="mdl-textfield__input" type="password" id="loginPassword" value={this.state.pass}
                     onChange={(e) => {
                       this.setState({pass: e.target.value});
                     }}/>
              <label className="mdl-textfield__label" htmlFor="loginPassword">Password</label>
            </div>
          </div>
          <div className={s.inputline} onClick={()=> {
            this.props.login(this.state.login, this.state.pass)
          }}>
            <button className="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
              Login
            </button>
          </div>
        </div>
        <div className="mdl-cell mdl-cell--4-col mdl-cell--1-col-phone"></div>
      </div>
    );
  }
}


function mapStateToProps(state, ownProps) {
  return {
    auth:state.auth,
    auth_error: state.auth_error,
    auth_msg: state.auth_msg,
    async_inprogress: state.async_inprogress
  };
}

const mapDispatchToProps = (dispatch, ownProps) => {
  return {
    // Voximplant user logon
    login:(user,password)=>{
      dispatch({type:'FETCH_START'});
      //We can't do this inside Redux! Redux MUST always be sync!
      fetch('https://api.voximplant.com/platform_api/Logon?account_email='+user+'&account_password='+password)
        .then((response)=>{
          if (response.status!=200){
            throw Error("Server error. Please, try again later.");
          }
          return response.json();
        })
        .then((data)=>{
          if(typeof(data.error)!="undefined")
            throw Error(data.error.msg);
          return data;
        })
        .then((data)=> {
          return fetch('http://confbackend.l.jsgrow.ru/?action=admin_portal_login' +
            '&account_id='+data.account_id+
            '&balance='+data.balance+
            '&result='+data.result);
        })
        .then((response)=>{
            if (response.status!=200){
              throw Error("Inner Server error. Please, try again later.");
            }
            return response.json();
        })
        .then((responseData)=>{
          if(responseData.response!='ok'){
            throw Error(responseData.message);
          }
          var data = responseData.result;
          dispatch({type:'LOGIN_OK',
            result:data.result,
            account_id:data.account_id,
            balance:data.balance,
            is_new:data.is_new
          });
        })
        .catch((err)=>{
          console.error(err);
          dispatch({type:'LOGIN_ERR',msg:err.getMessage()})
        });
    }
  }
};

export default connect(mapStateToProps,mapDispatchToProps)(LoginForm);

