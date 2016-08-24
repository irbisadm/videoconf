/**
 * React Static Boilerplate
 * https://github.com/kriasoft/react-static-boilerplate
 *
 * Copyright © 2015-present Kriasoft, LLC. All rights reserved.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.txt file in the root directory of this source tree.
 */

import React, { PropTypes } from 'react';
import Layout from '../../components/Layout';
import LoginForm from '../../components/Auth/LoginForm';
import s from './styles.css';

class UserPage extends React.Component {

    constructor(props, context) {
        super(props, context);
        this.state ={
            account_email:'',
            account_password:'',
            active:'',
            account_first_name:'',
            account_last_name:''
        }
    }

    static propTypes = {
  };



  componentDidMount() {
  }

  createAccount(){

  }

  render() {
    return (
        <Layout className={s.content}>

          <LoginForm/>
        </Layout>
    );
  }

}

export default UserPage;
