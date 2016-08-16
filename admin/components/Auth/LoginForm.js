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
        window.componentHandler.upgradeElements(this.refs.root);
    }

    componentWillUnmount(){
        window.componentHandler.downgradeElements(this.refs.root);
    }

    render() {
        if(this.props.auth){
            return(<div className="js_auth_ok"></div>);
        }
        return (
            <div ref="root">
                <div className={this.props.auth_error?s.errorline:s.hiddenline}>
                    {this.props.auth_msg}
                </div>
                <div className={s.inputline}>
                    <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input className="mdl-textfield__input" type="text" id="loginEmail" value={this.state.login}
                               onChange={(e) => {
                                   this.setState({login: e.target.value});
                               }}/>
                        <label className="mdl-textfield__label" htmlFor="loginEmail">Email</label>
                    </div>
                </div>
                <div className={s.inputline}>
                    <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
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
            dispatch({type:'LOGIN_START'});
            //We can't do this inside Redux! Redux MUST always be sync!
            fetch('https://api.voximplant.com/platform_api/Logon?account_email='+user+'&account_password='+password)
                .then((response)=>{
                    if (response.status!=200){
                        throw Error("Server error. Please, try again later.");
                    }
                    return response.json();
                })
                .then((data)=>{
                    console.log(data);
                    if(typeof(data.error)!="undefined"){
                        dispatch({type:'LOGIN_ERR',msg:data.error.msg});
                        return;
                    }
                    dispatch({type:'LOGIN_OK',result:data.result,account_id:data.account_id,balance:data.balance});

                })
                .catch((err)=>{
                    dispatch({type:'LOGIN_ERR',msg:err.getMessage()})
                });
        }
    }
};

export default connect(mapStateToProps,mapDispatchToProps)(LoginForm);

