/**
 * Created by irbisadm on 15/08/16.
 */
import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import s from './UserList.css';
import UserRow from './UserRow';
import Link from '../Link';


class UserList extends React.Component {

  constructor(props,context,updater){
    super(props,context,updater);
    this.state= {
      page: 0,
      maxpage: 0,
      hasError: false,
      errorMessage: '',
      data: []
    }
  }
  componentDidMount() {
    if(this.props.auth)
      this.getChildAccounts(0);
    window.componentHandler.upgradeElements(this.refs.root_user_list);
  }

  componentWillUnmount(){
    window.componentHandler.downgradeElements(this.refs.root_user_list);
  }
  getChildAccounts(newPage){
    let count = 100;
    let offset = this.state.page*count;
    this.props.fetchStart();
    this.setState({hasError:false,errorMessage:'',page:newPage});
    fetch('http://confbackend.l.jsgrow.ru/?action=admin_portal_get_clients' +
      '&account_id='+this.props.account_id+
      '&session_id='+this.props.session_id+
      '&count='+count+
      '&offset='+offset)
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
          else
            this.setState({hasError:true,errorMessage:data.error.msg});
        }
        this.setState({maxpage:(Math.round(data.total_count/count)),data:data.result});
        window.componentHandler.upgradeElements(this.refs.root_user_list);
      })
      .catch((e)=>{
        console.error(e);
        this.setState({hasError:false,errorMessage:e.getMessage()});
        this.props.fetchEnd();
      })
  }
  render() {
    if(!this.props.auth){
      return(<div className="js_auth_none" ref="root_user_list"></div>);
    }
    let content='';
    if(this.state.hasError){
      content = <div className="mdl-grid">
        <div className={s.errormsg+" mdl-cell mdl-cell--12-col"}>
          :( {this.state.errorMessage}
        </div>
      </div>;
    }else{
      content =
        <table className="mdl-data-table mdl-js-data-table" style={{width:'100%',margin:"20px 0"}}>
          <thead>
          <tr>
            <th className="mdl-data-table__cell--non-numeric">Active</th>
            <th className="mdl-data-table__cell--non-numeric">User ID</th>
            <th>User name</th>
            <th>User email</th>
            <th>Balance</th>
            <th>Payment</th>
          </tr>
          </thead>
          <tbody>
          {(()=>{return this.state.data.map((item)=>{
            return <UserRow key={item.account_id} item={item} refreshCallback={()=>{this.getChildAccounts(this.state.page)}}/>;
          })})()}
          </tbody>
        </table>
    }
    return (
      <div className={s.fullpage} ref="root_user_list">
        {content}
        <Link className={s.fab+" mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"} to="/user/">
          <i className="material-icons">add</i>
        </Link>
      </div>
    );
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

export default connect(mapStateToProps,mapDispatchToProps)(UserList);

