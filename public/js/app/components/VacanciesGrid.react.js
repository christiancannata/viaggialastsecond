/**
 * Copyright (c) 2014-2015, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */

var React = require('react');
var Vacancies = require('./Vacancies.react');

var VacanciesGrid = React.createClass({

  render: function () {
    var vacanciesNodes = this.props.data.map(function (obj) {

        if(obj.is_visible == true){
            return (
                <Vacancies isNew={obj.is_new} permalink={obj.permalink} company={obj.company.name} company_page={obj.company.permalink} key={obj.id} img={obj.company.logo_small} city={obj.city_plain_text}
                           name={obj.name} description={obj.description}>
                </Vacancies>
            );
        }

    });

    return (
          <div className="row vacancy-block vacancy-hold">
            {vacanciesNodes}
          </div>
    );
  }
});

module.exports = VacanciesGrid;
