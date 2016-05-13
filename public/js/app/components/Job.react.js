/**
 * Copyright (c) 2014, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */

var React = require('react');
var ReactPropTypes = React.PropTypes;

var Job = React.createClass({


    render: function () {
        var current = this;
        var divStyle = {
            background: 'url(' + this.props.image + ') no-repeat center center',

        };
        var permalink = "/" + $("html").attr("lang") + "/"+ this.props.link;

        var premiumClass="premium-banner ";

        if (!this.props.is_premium) {
            premiumClass += " hide";
        }
        function isNew(){
            var ret = "";
            if(current.props.isNew === true) {
                ret+= '<span class="badge badge-new-company">NEW</span>';
            }
            return {__html: ret};
        }


        return (
            <div className="col col-md-8">
                <div style={divStyle} className="box animated fadeIn">
                        <div className="float-left" dangerouslySetInnerHTML={isNew()}></div>
			            <span className="caption full-caption">
				            <div className="main-content">
                                <div className="row hidden-sm hidden-xs">
                                    <div className="col col-md-8 col-sm-6">
                                        <div className="job-description">
                                            <div className="col col-md-13">
                                                <h3>{this.props.company}</h3>

                                                <p>{this.props.city}</p>
                                            </div>
                                            <div className="col col-md-13">
                                                <a href={permalink} className="btn btn-red"
                                                   >{trans('company_page_button')}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col col-md-8 col-sm-10">
                                        <div className="tags animated fadeIn">
                                        </div>
                                    </div>
                                    <img src="/img/premium.png" className={premiumClass}  />
                                </div>

                                <div className="row hidden-lg hidden-md">
                                    <div className="col col-md-16">
                                        <div className="job-description">
                                            <div className="col col-md-16 ">

                                                <h3>{this.props.company}</h3>

                                                <p>{this.props.city}</p>

                                                <div className="tags animated fadeIn">
                                                </div>
                                            </div>
                                            <div className="col col-md-13">
                                                <a href={permalink} className="btn btn-red">{trans('company_page_button')}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </span>
                </div>
            </div>
        );
    }
});

module.exports = Job;

