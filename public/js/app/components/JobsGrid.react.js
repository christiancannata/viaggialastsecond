/**
 * Copyright (c) 2014-2015, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */

var React = require('react');
var Job = require('./Job.react');

var JobsGrid = React.createClass({

    render: function () {

        var jobsNodes = this.props.data.map(function (job) {
            if (job.sliders[0] != null && job.sliders[0].link != null) {
                String.prototype.replaceAll = function (search, replacement) {
                    var target = this;
                    return target.replace(new RegExp(search, 'g'), replacement);
                };


                var link = "";

                $.each(job.sliders, function (index, value) {
                    if (value.visible == true) {
                        link = value.link.replaceAll(" ", "%20");
                        return false;
                    }
                });


                return (
                    <Job isNew={job.is_new} key={job.id} company={job.name} city={job.city_plain_text} link={job.permalink}
                         image={link} is_premium={job.is_premium}>
                    </Job>
                );
            }

        });

        return (
            <div>
                <div className="jobsGeneralGrid jobsBox row jobs-row">
                    {jobsNodes}
                </div>

            </div>

        );
    }
});

module.exports = JobsGrid;
