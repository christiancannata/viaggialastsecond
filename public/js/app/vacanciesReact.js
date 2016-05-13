var React = require('react');
var ReactDOM = require('react-dom');
var VacanciesApp = require('./components/VacanciesApp.react');
var url = "/get-vacancies-active&serializerGroup=react";
ReactDOM.render(

    <VacanciesApp limit={15}  url={url} pollInterval={6000000} />,
    document.getElementById('vacancies')
);




