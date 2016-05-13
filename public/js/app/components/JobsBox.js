var limit = $("#jobs").attr("data-limit");

var Job = React.createClass({


    render: function () {
        var divStyle = {
            background: 'url(' + this.props.image + ') no-repeat center center',

        };

        var permalink = "/" + $("html").attr("lang") + "/" + this.props.link;


        return (
            <div className="col col-md-8">
                <div style={divStyle} className="box">
			            <span className="caption full-caption">
				            <div className="main-content">
                                <div className="row hidden-sm hidden-xs">
                                    <div className="col col-md-8 col-sm-6">
                                        <div className="job-description">
                                            <div className="col col-md-13">
                                                <h3>{this.props.company}</h3>

                                                <p className="only-white">{this.props.city}</p>
                                            </div>
                                            <div className="col col-md-13">
                                                <a href={permalink} className="btn btn-red">{trans('company_page_button')}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col col-md-8 col-sm-10">
                                        <div className="tags animated fadeIn">
                                        </div>
                                    </div>
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
                                                <a href={permalink} className="btn btn-red">{trans('apply_now_button')}</a>
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


var JobsGrid = React.createClass({

    render: function () {
        var jobsNodes = this.props.data.map(function (job) {
            return (
                <Job key={job.id} company={job.company} city={job.city} link={job.link} image={job.image}>
                </Job>
            );
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


var JobsBox = React.createClass({


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
    render: function () {
        return (
            <div className="jobsBox">
                <JobsGrid data={this.state.data}/>
            </div>



        );
    }
});
ReactDOM.render(
    <JobsBox  url="/get-vacancies-active" pollInterval={60000}/>,
    document.getElementById('jobs')
);

