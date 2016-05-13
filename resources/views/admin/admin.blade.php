@extends('template.admin_layout')

@yield('header')

@section('page-css')
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">


<link href="/admin/js/plugins/xcharts/xcharts.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<link href="/admin/js/plugins/jsgrid/css/jsgrid.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/jsgrid/css/jsgrid-theme.min.css" type="text/css" rel="stylesheet"
      media="screen,projection">
<link href="/admin/js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"
      media="screen,projection">

@endsection

@section('breadcrumbs')

        <!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <!-- Search for small screen -->
    <div class="header-search-wrapper grey hide">
        <i class="mdi-action-search active"></i>
        <input type="text" name="Search" class="header-search-input z-depth-2"
               placeholder="Search for candidates">
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Administrator Dashboard</h5>
                <ol class="breadcrumbs">
                    <li><a href="/admin/dashboard">Dashboard</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')


    <div class="section">
        <!--card stats start-->
        <div id="card-stats ">
            <div class="row">
                <div class="col s12 m6 l6">

                    <div id="morris-line-chart" class="section">
                        <h4 class="header">Last Month visitors</h4>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="row">
                                    <div class="col s2 m3 l3">
                                        <input name="visit_type" value="P8D" type="radio" id="test1" checked/>
                                        <label style="padding-left: 24px;" for="test1">Last Week</label>
                                    </div>
                                    <div class="col s2 m3 l3">
                                        <input name="visit_type" value="P15D" type="radio" id="2_weeks"/>
                                        <label style="padding-left: 24px;" for="2_weeks">Last 2 Weeks</label>
                                    </div>
                                    <div class="col s2 m3 l3">
                                        <input name="visit_type" value="P31D" type="radio" id="month"/>
                                        <label style="padding-left: 24px;" for="month">Last Month</label>
                                    </div>
                                    <div class="col s2 m3 l3">
                                        <input name="visit_type" value="P91D" type="radio" id="3_month"/>
                                        <label style="padding-left: 24px;" for="3_month">Last 3 Months</label>
                                    </div>
                                    <div class="col s4 m4 l4">
                                        <select name="group" id="group">
                                            <option value="day">Day</option>
                                            <option value="week">Week</option>
                                            <option value="month">Month</option>
                                        </select>
                                        <label style="padding-left: 24px;" for="group">Group Data By</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col s12 m12 l12">
                                <div class="sample-chart-wrapper">
                                    <div id="morris-line" class="graph"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col s6 m6 l6">

                    <div id="morris-line-chart" class="section">
                        <h4 class="header">TOP Referral Applications</h4>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <canvas id="doughnut-chart-sample"></canvas>
                            </div>
                            <div class="col s4 m4 l4">
                                <div id="doughnut-chart-sample-legend"></div>
                            </div>
                        </div>
                    </div>
                    <div id="morris-bar-chart" class="section">
                        <h4 class="header">TOP Quality Referral</h4>
                        <div class="row">
                            <div class="col s12 m8 l9">
                                <div class="sample-chart-wrapper">
                                    <div id="jsGrid-basic"></div>

                                </div>
                            </div>
                        </div>
                    </div>




                </div>


                <div class="col s12 m6 l3">
                    <div class="card component-statistic disabled" data-type="application" data-type-group="company"
                         data-id="">
                        <div class="card-content red white-text text-center">
                            <p class="card-stats-title  center"><i class="mdi-social-group-add"></i> Applications
                            </p>
                            <h4 class="card-stats-number value-a text-center center"></h4>

                        </div>
                        <div class="card-action red darken-2">
                            <div id="sales-compositebar" class="center-align white-text"><i
                                        class="mdi-hardware-keyboard-arrow-up"></i> <span class="difference"></span>
                                <span class="purple-text text-lighten-5 white-text">last month</span></div>
                        </div>
                    </div>
                </div>


                    <div id="morris-line-chart" class="col s4 m4 l4">
                        <h4 class="header">Referral Candidature LIKE</h4>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <canvas id="doughnut-chart-sample-starred"></canvas>
                            </div>

                        </div>
                    </div>

                <div id="morris-line-chart" class="col s4 m4 l4">
                    <h4 class="header">Referral Candidature DISLIKE</h4>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <canvas id="doughnut-chart-sample-rejected"></canvas>
                            </div>

                        </div>
                    </div>


            </div>
        </div>
    </div>






    <div class="section">


        <div data-count="" data-other="" id="vacancies">
            <div class="col s12 m12 l12">
                <?php
                $applicationTotali = 0;
                ?>

                        <!--DataTables example-->
                <div id="table-datatables">
                    <div class="row">
                        <style>
                            #table-datatables a{
                                padding-left: 10px;
                                padding-right: 10px;
                            }
                        </style>
                        <div class="col s12 m12 l12">
                            <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Attiva</th>
                                    <th>Completa</th>
                                    <th>Ats</th>
                                    <th>Vacancies</th>
                                    <th>Data Registrazione</th>
                                    <th>Data Pubblicazione</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($companies as $company)
                                    <tr>
                                        <td>{{$company['name']}}</td>
                                        <td>@if($company['is_visible']) <i class="mdi-action-done green-text"></i> @else
                                                <i class="mdi-content-clear red-text"></i> @endif</td>
                                        <td>@if($company['is_complete']) <i
                                                    class="mdi-action-done green-text"></i> @else <i
                                                    class="mdi-content-clear red-text"></i> @endif</td>
                                        <td>@if($company['has_ats']) <i class="mdi-action-done green-text"></i> @else <i
                                                    class="mdi-content-clear red-text"></i> @endif</td>
                                        <td>{{$company['count_vacancies']}}</td>

                                        <td>
                                            <?php
                                            $data = new \DateTime($company['created_at']);
                                            echo $data->format("d-m-Y H:i")
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if(isset($company['publish_date']) && $company['publish_date']){
                                                $data = new \DateTime($company['publish_date']);
                                                echo $data->format("d-m-Y H:i");
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            @if(!$company['is_visible'] && !$company['is_complete'] && $company['count_vacancies']==0)
                                                <a href="/admin/{{$company['permalink']}}"
                                                   class="btn btn-red">Dettagli</a>
                                                <a href="/admin/{{$company['permalink']}}/statistics"
                                                   class="btn btn-red">Stats</a>
                                                <a title="Elimina azienda"
                                                   data-href="/elimina/company/{{$company['id']}}"
                                                   data-method="GET" href="#"
                                                   class="action-button btn btn-red hide"><i
                                                            class="mdi-action-delete "></i></a>
                                            @else
                                                <a href="/admin/{{$company['permalink']}}"
                                                   class="btn btn-red">Dettagli</a>
                                                <a href="/admin/{{$company['permalink']}}/statistics"
                                                   class="btn btn-red">Stats</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>


@endsection

@section('page-scripts')

    <script type="text/javascript" src="/admin/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript"
            src="{{auto_version("/admin/js/hr.js")}}"></script>
    <script type="text/javascript" src="/admin/js/plugins/formatter/jquery.formatter.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/db.js"></script> <!--data-->
    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/jsgrid.min.js"></script>


    <script type="text/javascript" src="/admin/js/plugins/d3/d3.min.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/xcharts/xcharts.min.js"></script>
    <!-- morris -->
    <script type="text/javascript" src="/admin/js/plugins/chartist-js/chartist.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/chartjs/chart.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/raphael/raphael-min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/morris-chart/morris.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/morris-chart/morris-script.js"></script>
    <?php
    $dal = new \DateTime();
    $al = new \DateTime();
    $dal->sub(new \DateInterval("P8D"));
    $al->sub(new \DateInterval("P1D"));
    ?>

    <style>
        #doughnut-chart-sample-legend li span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
        }
    </style>
    <script type="text/javascript">



        $(document).ready(function () {
            HR.init();

            if ($("#morris-line").length) {


                $("#jsGrid-basic").jsGrid({
                    height: "auto",
                    width: "100%",
                    sorting: false,
                    paging: true,
                    pageSize: 4,
                    autoload: true,
                    controller: {
                        loadData: function () {
                            var d = $.Deferred();
                            $.ajax({
                                url: "/company/all/topScoreReferral",
                                dataType: "json"
                            }).done(function (response) {
                                d.resolve(response);
                            });

                            return d.promise();
                        }
                    },
                    fields: [
                        {name: "Referral", type: "text"},
                        {name: "Count", type: "number"},
                        {name: "Score", type: "number"}
                    ]
                });


                $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: "/company/all/referral", // This is the URL to the API
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data
                            window.DoughnutChartSample = new Chart(document.getElementById("doughnut-chart-sample").getContext("2d")).Pie(data, {
                                responsive: true,
                                segmentShowStroke: false,
                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                            });

                            document.getElementById('doughnut-chart-sample-legend').innerHTML = window.DoughnutChartSample.generateLegend();


                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            //  alert("error occured");
                        });


                $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: "/company/all/referral?filter[status]=STARRED", // This is the URL to the API
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data
                            window.DoughnutChartSampleStarred = new Chart(document.getElementById("doughnut-chart-sample-starred").getContext("2d")).Pie(data, {
                                responsive: true,
                                segmentShowStroke: false,
                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                            });



                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            //  alert("error occured");
                        });


                $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: "/company/all/referral?filter[status]=REJECTED", // This is the URL to the API
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data
                            window.DoughnutChartSampleRejected = new Chart(document.getElementById("doughnut-chart-sample-rejected").getContext("2d")).Pie(data, {
                                responsive: true,
                                segmentShowStroke: false,
                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                            });



                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            //  alert("error occured");
                        });


                var visitsArray = [];
                // Fire off an AJAX request to load the data
                $.ajax({
                            type: "GET",
                            dataType: 'json',

                            url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/&dimensions=ga:date&from=P7D&to=yesterday", // This is the URL to the API
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data

                            visitsArray = data;

                            $.ajax({
                                        type: "GET",
                                        dataType: 'json',
                                        url: "/company/all/applications?from={{$dal->format("d-m-Y")}}&to={{$al->format("d-m-Y")}}", // This is the URL to the API
                                    })
                                    .done(function (data) {
                                        // When the response to the AJAX request comes back render the chart with new data
                                        var applicationsArray = data;

                                        var arrayStatistic = [];


                                        $(visitsArray).each(function (i, value) {
                                            var appo = [];
                                            appo["date"] = value["dimensions"];
                                            appo["pageView"] = parseInt(value["pageView"]);

                                            var applicationsDay = 0;
                                            for (var j = 0; j < applicationsArray.length; j++) {
                                                if (applicationsArray[j]["date"] == value["dimensions"]) {
                                                    applicationsDay = applicationsArray[j]["applications"];
                                                }
                                            }

                                            appo["applications"] = applicationsDay;


                                            arrayStatistic.push(appo);
                                        });


                                        // Line Chart
                                        var chart = Morris.Line({
                                            element: 'morris-line',
                                            xkey: 'date',
                                            ykeys: ['pageView', 'applications'],
                                            xLabels: "daily",
                                            labels: ["Visits", "Applications"],
                                            resize: true,
                                            xLabelAngle: 0
                                        });


                                        chart.setData(arrayStatistic);


                                    })
                                    .fail(function () {
                                        // If there is no communication between the server, show an error
                                        // alert("error occured");
                                    });


                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            // alert("error occured");
                        });


                $(".component-statistic").each(function (i, ctr) {
                    var ctr = $(this);
                    $.ajax({
                                type: "GET",
                                dataType: 'json',
                                url: "/analytics/" + ctr.attr("data-type") + "/compare?typeGroup=" + ctr.attr("data-type-group"), // This is the URL to the API
                            })
                            .done(function (data) {
                                // When the response to the AJAX request comes back render the chart with new data
                                var percentage = (data.period_1["total"] - data.period_2["total"]) / data.period_2["total"] * 100;
                                ctr.find(".difference").text(percentage.toFixed(1) + "%");
                                ctr.find(".value-a").text(data.period_1["total"]);
                                ctr.removeClass("disabled");
                            })
                            .fail(function () {
                                // If there is no communication between the server, show an error
                                //  alert("error occured");
                            });
                });


                $("input[name=visit_type]").click(function (e) {

                    $("#morris-line").toggleClass("disabled");
                    // Fire off an AJAX request to load the data
                    var from = $(this).val();
                    $.ajax({
                                type: "GET",
                                dataType: 'json',
                                url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/&dimensions=ga:date&from=" + from + "&to=yesterday", // This is the URL to the API
                            })
                            .done(function (data) {
                                // When the response to the AJAX request comes back render the chart with new data

                                visitsArray = data;

                                $.ajax({
                                            type: "GET",
                                            dataType: 'json',
                                            url: "/company/all/applications?from=" + from + "&to=yesterday&dateGroup=" + $("select[name=group]").val(), // This is the URL to the API
                                        })
                                        .done(function (data) {
                                            // When the response to the AJAX request comes back render the chart with new data
                                            var applicationsArray = data;

                                            var arrayStatistic = [];

                                            $(visitsArray).each(function (i, value) {
                                                var appo = [];
                                                appo["date"] = value["dimensions"];
                                                appo["pageView"] = parseInt(value["pageView"]);


                                                var applicationsDay = 0;
                                                for (var j = 0; j < applicationsArray.length; j++) {
                                                    if (applicationsArray[j]["date"] == value["dimensions"]) {
                                                        applicationsDay = applicationsArray[j]["applications"];
                                                    }
                                                }

                                                appo["applications"] = applicationsDay;


                                                arrayStatistic.push(appo);
                                            });


                                            $("#morris-line").empty();

                                            // Line Chart
                                            var chart = Morris.Line({
                                                element: 'morris-line',
                                                xkey: 'date',
                                                ykeys: ['pageView', 'applications'],
                                                xLabels: "daily",
                                                labels: ["Visits", "Applications"],
                                                resize: true,
                                                xLabelAngle: 0
                                            });
                                            chart.setData(arrayStatistic);

                                            $("#morris-line").toggleClass("disabled");
                                        })
                                        .fail(function () {
                                            // If there is no communication between the server, show an error
                                            // alert("error occured");
                                        });


                            })
                            .fail(function () {
                                // If there is no communication between the server, show an error
                                // alert("error occured");
                            });


                });


            } else {


            }
                $('#data-table-simple').DataTable({
                    "paging": true,
                    "ordering": true,
                    "info": true
                });


        });


    </script>
@endsection