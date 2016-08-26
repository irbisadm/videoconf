import React, {PropTypes} from 'react';
import {connect} from 'react-redux';

class UserRow extends React.Component {


  constructor(props,context,updater) {
    super(props,context,updater);
    this.state = {
      editMode: false,
      payAmount:0
    };
  }

  static propTypes = {
    item: PropTypes.object.isRequired,
    refreshCallback: PropTypes.func
  };

  registerSubAccount(regAcc){
    this.props.fetchStart();
    fetch('http://confbackend.l.jsgrow.ru/?action=admin_portal_register_client'+
      '&account_id='+this.props.account_id+
      '&session_id='+this.props.session_id+
      '&reg_acc='+regAcc
      )
      .then((response)=>{
        if (response.status!=200)
          throw Error("Server error. Please, try again later.");
        return response.json();
      })
      .then((data)=>{
        this.props.fetchEnd();
        if( data.response == "error") {
          if (data.code == 100)
            this.props.sessionExpired();
          throw Error('session expired')
        }
        this.props.refreshCallback();
      })
      .catch((e)=>{
        console.error(e);
        this.props.fetchEnd();
      })
  }

  changeSubAccountActivity(accId){
    this.props.fetchStart();
    fetch('http://confbackend.l.jsgrow.ru/?action=admin_portal_toggle_client'+
      '&account_id='+this.props.account_id+
      '&session_id='+this.props.session_id+
      '&id='+accId
    )
      .then((response)=>{
        if (response.status!=200)
          throw Error("Server error. Please, try again later.");
        return response.json();
      })
      .then((data)=>{
        this.props.fetchEnd();
        if( data.response == "error") {
          if (data.code == 100)
            this.props.sessionExpired();
          throw Error('session expired')
        }
        this.props.refreshCallback();
      })
      .catch((e)=>{
        console.error(e);
        this.props.fetchEnd();
      })
  }
  setPay(accId){
    this.props.fetchStart(accId);
    fetch('http://confbackend.l.jsgrow.ru/?action=admin_portal_pay_user'+
      '&account_id='+this.props.account_id+
      '&session_id='+this.props.session_id+
      '&id='+accId+
      '&amount='+this.state.payAmount
    )
      .then((response)=>{
        if (response.status!=200)
          throw Error("Server error. Please, try again later.");
        return response.json();
      })
      .then((data)=>{
        this.props.fetchEnd();
        if( data.response == "error") {
          if (data.code == 100)
            this.props.sessionExpired();
          throw Error('session expired')
        }
        this.setState({editMode:false})
        this.props.refreshCallback();
      })
      .catch((e)=>{
        alert(e);
        console.log(e);
        this.props.fetchEnd();
      })
  }
  componentDidMount() {
    window.componentHandler.upgradeElements(this.refs.row);
  }
  componentDidUpdate(){
    window.componentHandler.upgradeElements(this.refs.row);
  }

  componentWillUnmount(){
    window.componentHandler.downgradeElements(this.refs.row);
  }
  componentWillUpdate(){
    window.componentHandler.downgradeElements(this.refs.row);
  }

  render(){
    if(this.props.item.not_in_base){
      return(<tr style={{background:'#BDBDBD',color:'#EEEEEE'}} ref="row">
        <td className="mdl-data-table__cell--non-numeric">
          <button className="mdl-button mdl-js-button mdl-js-ripple-effect" onClick={()=>{this.registerSubAccount(this.props.item.account_id)}}>
            Register
          </button>
        </td>
        <td className="mdl-data-table__cell--non-numeric">{this.props.item.account_id}</td>
        <td>{this.props.item.account_name}</td>
        <td>{this.props.item.account_email}</td>
        <td>{this.props.item.balance} {this.props.item.currency}</td>
        <td></td>
      </tr>);
    }else{
      return(<tr key={this.props.key} ref="row">
        <td className="mdl-data-table__cell--non-numeric">
          <label className="mdl-switch mdl-js-switch mdl-js-ripple-effect" htmlFor={"switch-"+this.props.item.account_id}>
            <input type="checkbox"
                   id={"switch-"+this.props.item.account_id}
                   className="mdl-switch__input"
                   defaultChecked={this.props.item.active}
                   onChange={(e)=>{
                     this.changeSubAccountActivity(this.props.item.id);
                   }}
            />
            <span className="mdl-switch__label"></span>
          </label>
        </td>
        <td className="mdl-data-table__cell--non-numeric">{this.props.item.account_id}</td>
        <td>{this.props.item.account_name}</td>
        <td>{this.props.item.account_email}</td>
        <td>{this.props.item.balance} {this.props.item.currency}</td>
        <td>
          {(()=>{
            if(this.state.editMode){
              return <div>
                <div className="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style={{width:'100px'}}>
                  <input className="mdl-textfield__input" type="text" id={this.props.item.id+"amount"} value={this.state.payAmount} onChange={(e)=>{
                    this.setState({payAmount:e.target.value})
                  }}/>
                    <label className="mdl-textfield__label" htmlFor={this.props.item.id+"amount"}>Pay amount</label>
                </div>
                <button className="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" onClick={()=>{
                  this.setPay(this.props.item.id);
                }}>
                  <i className="material-icons">add</i>
                </button>
              </div>
            }else{
              return <button className="mdl-button mdl-js-button mdl-js-ripple-effect" onClick={()=>{this.setState({editMode:true})}}>
                Add payment
              </button>
            }
          })()}

        </td>
      </tr>);
    }

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

export default connect(mapStateToProps,mapDispatchToProps)(UserRow);