import React, {PropTypes} from 'react';
import {connect} from 'react-redux';

class UserCreate extends React.Component {


  constructor(props,context,updater) {
    super(props,context,updater);
    this.state = {
      first_name:'',
      last_name:'',
      acc_email:'',
      acc_pass:'',
      acc_pass_c:'',
      acc_mobile:'',
      start_balance:0,
      hasError:false,
      errorMessage:'',
    }
  }

  storeAcc(){
    this.setState({hasError:false,errorMessage:''});
    this.props.fetchStart();
    fetch('http://confbackend.l.jsgrow.ru/?action=admin_portal_create_user' +
      '&account_id='+this.props.account_id+
      '&session_id='+this.props.session_id+
      '&first_name='+this.state.first_name+
      '&last_name='+this.state.last_name+
      '&acc_email='+this.state.acc_email+
      '&acc_pass='+this.state.acc_pass+
      '&acc_pass_c='+this.state.acc_pass_c+
      '&acc_mobile='+this.state.acc_mobile+
      '&start_balance='+this.state.start_balance)
      .then((response)=>{
        if (response.status!=200){
          this.props.fetchEnd();
          throw Error("Server error. Please, try again later.");
        }
        return response.json();
      })
      .then((data)=>{
        this.props.fetchEnd();
        if( data.response == "error"){
          if(data.code==100)
            this.props.sessionExpired();
          else{
            console.error(data);
            this.setState({hasError:true,errorMessage:data.error.msg});
          }

        }

      })
      .catch((e)=>{
        console.error(e);
        this.setState({hasError:false,errorMessage:e.getMessage()});
        this.props.fetchEnd();
      })
  }

  componentDidMount() {
    window.componentHandler.upgradeElements(this.refs.root_user);
  }

  componentWillUnmount(){
    window.componentHandler.downgradeElements(this.refs.root_user);
  }

  render(){
    return(<div className="mdl-grid" ref="root_user">
      <div className="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet mdl-cell--12-col-phone mdl-cell--3-offset-desktop mdl-cell--2-offset-tablet mdl-cell--0-offset-phone">
        <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input className="mdl-textfield__input" type="text" id="first_name"
                 value={this.state.first_name}
                 onChange={(e)=>{this.setState({first_name: e.target.value})}}/>
            <label className="mdl-textfield__label" htmlFor="first_name">First name*</label>
        </div>
        <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input className="mdl-textfield__input" type="text" id="last_name"
                 value={this.state.last_name}
                 onChange={(e)=>{this.setState({last_name: e.target.value})}}/>
          <label className="mdl-textfield__label" htmlFor="last_name">Last name*</label>
        </div>
        <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input className="mdl-textfield__input" type="text" id="acc_email"
                 value={this.state.acc_email}
                 onChange={(e)=>{this.setState({acc_email: e.target.value})}}/>
          <label className="mdl-textfield__label" htmlFor="acc_email">Account email*</label>
        </div>
        <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input className="mdl-textfield__input" type="text" id="acc_password"
                 value={this.state.acc_pass}
                 onChange={(e)=>{this.setState({acc_pass: e.target.value})}}/>
          <label className="mdl-textfield__label" htmlFor="acc_password">Account password*</label>
        </div>
        <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input className="mdl-textfield__input" type="text" id="acc_password_c"
                 value={this.state.acc_pass_c}
                 onChange={(e)=>{this.setState({acc_pass_c: e.target.value})}}/>
          <label className="mdl-textfield__label" htmlFor="acc_password_c">Account password confirmation*</label>
        </div>
        <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input className="mdl-textfield__input" type="text" id="acc_mobile"
                 value={this.state.acc_mobile}
                 onChange={(e)=>{this.setState({acc_mobile: e.target.value})}}/>
          <label className="mdl-textfield__label" htmlFor="acc_mobile">Account mobile phone*</label>
        </div>
        <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          <input className="mdl-textfield__input" type="text" id="acc_email"
                 value={this.state.start_balance}
                 onChange={(e)=>{this.setState({start_balancee: e.target.value})}}/>
          <label className="mdl-textfield__label" htmlFor="acc_email">Start balance</label>
        </div>
        <div>
          <button onClick={()=>{this.storeAcc()}} className="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
            Create user
          </button>
        </div>
      </div>
    </div>)
  }
}

function mapStateToProps(state, ownProps) {
  return {
    auth:state.auth,
    session_id :state.session_id,
    account_id:state.account_id,
  };
}

const mapDispatchToProps = (dispatch, ownProps) => {
  return {
    // Voximplant user logon
    sessionExpired: ()=> {
      dispatch({type: 'LOGOUT'});
    },
    fetchStart:()=>{
      dispatch({type: 'FETCH_START'});
    },
    fetchEnd:()=>{
      dispatch({type: 'FETCH_END'});
    },
  }
};

export default connect(mapStateToProps,mapDispatchToProps)(UserCreate);