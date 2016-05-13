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

var Vacancies = React.createClass({


    render: function () {
        var current = this;
        var permalink_azienda = "/" + $("html").attr("lang") + "/"+ this.props.company_page ;

        var permalink = "/" + $("html").attr("lang") + "/"+ this.props.company_page +"/"+ this.props.permalink;

        var description = this.props.description.replace(/(<([^>]+)>)/ig,"");

        function vacancyName(){
            var ret = current.props.name;
            if(current.props.isNew === true) {
                ret+= '&nbsp;<span class="badge badge-new-vacancy">NEW</span>';
            }
            return {__html: ret};
        }

        description = description.replace(/&nbsp;/gi,' ').replace(/&amp;/g, '&');

        if(this.props.company_page!="meritocracy-test"){
            return (
                <div className="col-md-16 jobs-stat animated fadeIn">
                    <div className="row">
                        <div className="col-md-4 col-xs-7 col-sm-4">
                            <div className="">
                                <p className="vacancy-location-value company-name" >{this.props.company}</p>

                                <img className="portfolio-image img-responsive"
                                     src={this.props.img}
                                     alt=""/>

                                <div className="vacancy-info hidden-xs">
                                    <span className="vacancy-location text-uppercase">Location</span>

                                    <p className="vacancy-location-value">{this.props.city}</p>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-8 col-xs-9 col-sm-12">
                            <h4 className="vacancy-name" dangerouslySetInnerHTML={vacancyName()}></h4>

                            <span className="vacancy-purpose hidden-xs">{trans('job_purpose')}</span>

                            <p className="vacancy-description hidden-xs" >{description.substring(0, 300)}...</p>

                            <div className="vacancy-info hidden-md hidden-lg">
                                <p className="vacancy-location-value">{this.props.city}</p>
                            </div>
                        </div>
                        <div className="col col-xs-16 hidden-md hidden-lg">
                            <p className="vacancy-description">{this.props.description}</p>
                        </div>
                        <div className="col-md-4 col-xs-16">
                            <a href={permalink}>
                                <button className="btn btn-red btn-block">{trans('apply_now_button')}</button>
                            </a>

                            <a href={permalink_azienda}>
                                <button className="btn dark-button btn-block">{trans('esplora_azienda')}</button>
                            </a>


                            <p className="vacancy-share-job text-center text-uppercase red ">
                                {trans('share_job')}</p>

                            <ul className="soc text-center soc-violet"
                                data-share-title={this.props.name}
                                data-share-link={permalink}
                            >
                                <li><a className="soc-linkedin" href="#"></a></li>
                                <li><a className="soc-facebook" href="#"></a></li>
                                <li><a className="soc-twitter" href="#"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            );
        }
        return (null);

    }
});

module.exports = Vacancies;

