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


class LoginPage extends React.Component {

  static propTypes = {};

  componentDidMount() {}

  componentWillUnmount(){}

  render() {
    return (
        <Layout className={s.content}>
          <div className={s.fullpage+" mdl-grid"}>
            <div className="mdl-cell mdl-cell--4-col mdl-cell--1-col-phone"></div>
            <div className={s.hflex+" mdl-cell mdl-cell--4-col mdl-cell--10-col-phone"}>
              <LoginForm/>
            </div>
            <div className="mdl-cell mdl-cell--4-col mdl-cell--1-col-phone"></div>
          </div>
        </Layout>
    );
  }

}

export default LoginPage;
