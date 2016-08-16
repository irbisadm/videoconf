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
import UserList from '../../components/UserManage/UserList.js';
import s from './styles.css';


class LoginPage extends React.Component {

  static propTypes = {};

  componentDidMount() {}

  componentWillUnmount(){}

  render() {
    return (
        <Layout className={s.content}>
            <UserList/>
            <LoginForm/>

        </Layout>
    );
  }

}

export default LoginPage;
