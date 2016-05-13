var React = require('react');
var ReactDOM = require('react-dom');

var JobsApp = require('./components/JobsApp.react');

var limit = $("#companies").attr("data-limit");
var onlyPremium = $("#companies").attr("data-only-premium");

if(limit==0){
    limit=200;
}

var url = "/get-home-companies/all";

if(onlyPremium=="true"){
    url = "/get-home-companies/premium";
}

ReactDOM.render(
    <JobsApp url={url} limit={limit} pollInterval={6000000}/>,
    document.getElementById('companies')
);
