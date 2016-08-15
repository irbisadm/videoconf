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
        return (
            <div ref="root">
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
                        <input className="mdl-textfield__input" type="passwor" id="loginPassword" value={this.state.pass}
                               onChange={(e) => {
                                   this.setState({login: e.target.pass});
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
        auth:state.auth
    };
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {}
};

export default connect(mapStateToProps,mapDispatchToProps)(LoginForm);

