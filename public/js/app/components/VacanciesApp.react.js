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


var VacanciesGrid = require('./VacanciesGrid.react');
var React = require('react');
var Paginator = require('../utils/paginator');



var VacanciesApp = React.createClass({

    loadVacanciesFromServer: function (page) {
        var limit = this.props.limit;
        var offset= this.props.limit*(page-1);
        if(limit>0){
            $.ajax({
                url: this.props.url+"&offset="+offset+"&limit="+limit,
                dataType: 'json',
                cache: false,
                type: 'GET',
                success: function (data) {
                    this.setState({data: data});
                    this.setState({loading: false});
                }.bind(this),
                error: function (xhr, status, err) {
                }.bind(this)
            });
            $.ajax({
                url: "/get-visible-vacancies",
                dataType: 'json',
                cache: false,
                type: 'GET',
                success: function (result) {
                    result = result.count;
                    this.setState({pages : Math.round(result / limit)});
                }.bind(this),
                error: function (xhr, status, err) {
                }.bind(this)
            });
        }



    },
    onChangePage: function (page) {
        this.setState({ loading: true});

        this.loadVacanciesFromServer(page);
    },

    getInitialState: function () {

        return {
            data: [],
            loading: true,
            pages : 1
        };
    },
    componentDidMount: function () {
        this.loadVacanciesFromServer(1);
        setInterval(this.loadVacanciesFromServer, this.props.pollInterval);
   },

    render: function () {
        return (
            <div className="vacanciesBox">
                {this.state.loading
                    ? <div className="job-loading"><i className="fa fa-circle-o-notch fa-spin fa-4x fa-fw margin-bottom"></i></div>
                    : <VacanciesGrid data={this.state.data}/>
                }
                <Paginator max={this.state.pages} maxVisible={this.state.pages} onChange={this.onChangePage}/>


            </div>



        );
    }
});

module.exports = VacanciesApp;
