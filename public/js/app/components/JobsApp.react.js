/**
 * Copyright (c) 2014-2015, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */

/**
 * This component operates as a "Controller-View".  It listens for changes in
 * the TodoStore and passes the new data to its children.
 */

var JobsGrid = require('./JobsGrid.react');
var React = require('react');


var JobsApp = React.createClass({



  loadJobsFromServer: function () {
    $.ajax({
      url:  this.props.url+"&limit="+this.props.limit,
      dataType: 'json',
      cache: false,
      type: 'GET',
      success: function (data) {
        this.setState({data: data});
      }.bind(this),
      error: function (xhr, status, err) {
      }.bind(this)
    });
  },
  getInitialState: function () {

    return {data: []};
  },
  componentDidMount: function () {
    this.loadJobsFromServer();
    setInterval(this.loadJobsFromServer, this.props.pollInterval);
  },

  /**
   * @return {object}
   */
  render: function () {
    return (
        <div className="jobsBox">
          <JobsGrid data={this.state.data}/>
        </div>


    );
  }
});

module.exports = JobsApp;
