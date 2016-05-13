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
                <h5 class="breadcrumbs-title">Statistics</h5>
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

        <div data-count="" data-other="" id="statistics-modal">
            <div class="col s12 m12 l12">
                <div style="margin-top: 50px; margin-bottom: 50px;"
                     class="col s12 m12 l12 center form-loader ">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-red-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>

                    </div>
                    <p>Sto caricando le statistiche, l'operazione puo' richiedere anche 30 secondi...</p>
                </div>
                <div class="row " id="detailForm" style="display: none">
                    <div class="input-field col s6 hide" style="width:30%;margin-left:30px">
                        <select id="comparaCompany" name="company"
                        >
                            <option value="" disabled selected>Scegli l'azienda</option>
                            @foreach($companies as $c)
                                <option data-id="{{$c['id']}}" data-name="{{$c['name']}}"
                                        data-permalink="{{$c['permalink']}}"
                                        value="{{$c['id']}}">{{$c['name']}}</option>
                            @endforeach
                        </select>
                        <label for="vacancyAddJobFunction" lang="en">Confronta con:</label>

                    </div>
                    <form method="POST" class="range-date-form">
                        <div class="input-field col s3 m3 l3" style="width:30%;margin-left:30px">
                            <input type="text" class="datepicker" id="periodoDal" name="periodoDal">
                            <label for="periodoDal" lang="en">Periodo dal:</label>

                        </div>
                        <div class="input-field col s3 m3 l3" style="width:30%;margin-left:30px">
                            <input type="text" id="periodoAl" class="datepicker" name="periodoAl">
                            <label for="periodoAl" lang="en">Periodo Al:</label>

                        </div>
                        <div class="input-field col s3 m3 l3">
                            <button type="submit" value="" class="btn btn-red">Carica statistiche</button>
                        </div>
                    </form>


                </div>
                <div class="content-main-ajax">

                </div>

                <div class="content-second-ajax">

                </div>

            </div>


        </div>


        <?php
        $dal = new \DateTime();
        $al = new \DateTime();
        $dal->sub(new \DateInterval("P13D"));
        $al->sub(new \DateInterval("P1D"));
        ?>

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


            <!-- sparkline -->
            <script type="text/javascript" src="/admin/js/plugins/sparkline/jquery.sparkline.min.js"></script>

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
                    $('#data-table-simple').DataTable({
                        "paging": true,
                        "ordering": true,
                        "info": true
                    });

                    $("#comparaCompany").change(function (e) {


                        e.preventDefault();

                        var permalink = $(this).find("option:selected").attr("data-permalink");
                        var id = $(this).find("option:selected").attr("data-id");
                        var name = $(this).find("option:selected").attr("data-name");
                        $("#statistics-modal .content-second-ajax").empty();

                        $.ajax({
                                    type: "GET",
                                    dataType: 'html',
                                    url: "/company/" + id + "/analytics?permalink={{$company['permalink']}}&metrics=ga:pageviews&filters=ga:pagePath=@/company/" + permalink + "&dimensions=ga:date&from=P13D&to=yesterday&companyName=" + name, // This is the URL to the API
                                })
                                .done(function (data) {
                                    // When the response to the AJAX request comes back render the chart with new data
                                    $("#statistics-modal .content-second-ajax").html(data);


                                    $('#statistics-modal .content-second-ajax .sparklines').sparkline('html', {
                                        type: 'line',
                                        width: '100%',
                                        height: '50',
                                        lineWidth: 2,
                                        lineColor: '#ffcc80',
                                        fillColor: 'rgba(255, 152, 0, 0.5)',
                                        highlightSpotColor: '#ffcc80',
                                        highlightLineColor: '#ffcc80',
                                        minSpotColor: '#f44336',
                                        maxSpotColor: '#4caf50',
                                        spotColor: '#ffcc80',
                                        spotRadius: 4,
                                    });

                                    window.VisiteReferral = new Chart($("#statistics-modal .content-second-ajax .pageView-Referral")[0].getContext("2d")).Pie(jQuery.parseJSON($("#statistics-modal .content-main-ajax .pageView-Referral").attr("data")), {
                                        responsive: true,
                                        segmentShowStroke: false,
                                        tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                    });


                                    var chart = [];
                                    $("#statistics-modal .content-second-ajax .torta").each(function (i, val) {
                                        chart[i] = new Chart($(this)[0].getContext("2d")).Pie(jQuery.parseJSON($(this).attr("data")), {
                                            responsive: true,
                                            segmentShowStroke: false,
                                            tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                        });
                                    });
                                    $.ajax({
                                                type: "GET",
                                                dataType: 'json',
                                                url: "/company/" + id + "/referral", // This is the URL to the API
                                            })
                                            .done(function (data) {
                                                // When the response to the AJAX request comes back render the chart with new data
                                                window.DoughnutChartSample = new Chart($("#statistics-modal .content-second-ajax .doughnut-chart-sample")[0].getContext("2d")).Pie(data, {
                                                    responsive: true,
                                                    segmentShowStroke: false,
                                                    tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                                });


                                            })
                                            .fail(function () {
                                                // If there is no communication between the server, show an error
                                                //  alert("error occured");
                                            });


                                })
                                .fail(function () {
                                    // If there is no communication between the server, show an error
                                    // alert("error occured");
                                });


                    });

                    $(document).ready(function (e) {

                        var permalink = "{{$company['permalink']}}";
                        var id = "{{$company['id']}}";
                        var name = "{{$company['name']}}";


                        $(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});

                        $(".range-date-form").submit(function (e) {
                            e.preventDefault();
                            $("#statistics-modal .content-main-ajax").hide();

                            $("#statistics-modal .form-loader").show();

                            $.ajax({
                                        type: "GET",
                                        dataType: 'html',
                                        url: "/company/" + id + "/analytics?permalink={{$company['permalink']}}&metrics=ga:pageviews&filters=ga:pagePath=@/company/" + permalink + "&dimensions=ga:date&from=" + $("#periodoDal").val() + "&to=" + $("#periodoAl").val() + "&disabledCache=true&companyName=" + name, // This is the URL to the API
                                    })
                                    .done(function (data) {
                                        $("#statistics-modal .form-loader").hide();
                                        // When the response to the AJAX request comes back render the chart with new data
                                        $("#statistics-modal .content-main-ajax").html(data);
                                        $("#statistics-modal .content-main-ajax").show();

                                        $('#statistics-modal .content-main-ajax .sparklines').sparkline('html', {
                                            type: 'line',
                                            width: '100%',
                                            height: '50',
                                            lineWidth: 2,
                                            lineColor: '#ffcc80',
                                            fillColor: 'rgba(255, 152, 0, 0.5)',
                                            highlightSpotColor: '#ffcc80',
                                            highlightLineColor: '#ffcc80',
                                            minSpotColor: '#f44336',
                                            maxSpotColor: '#4caf50',
                                            spotColor: '#ffcc80',
                                            spotRadius: 4,
                                        });

                                        var sorgentiVisite = [];
                                        $("#statistics-modal .content-main-ajax .pageView-Referral").each(function (i, val) {
                                            sorgentiVisite[i] = new Chart($(this)[0].getContext("2d")).Pie(jQuery.parseJSON($(this).attr("data")), {
                                                responsive: true,
                                                segmentShowStroke: false,
                                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                            });
                                        });

                                        var chart = [];
                                        $("#statistics-modal .content-main-ajax .torta").each(function (i, val) {
                                            chart[i] = new Chart($(this)[0].getContext("2d")).Pie(jQuery.parseJSON($(this).attr("data")), {
                                                responsive: true,
                                                segmentShowStroke: false,
                                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                            });
                                        });


                                        $.ajax({
                                                    type: "GET",
                                                    dataType: 'json',
                                                    url: "/company/" + id + "/referral", // This is the URL to the API
                                                })
                                                .done(function (data) {
                                                    // When the response to the AJAX request comes back render the chart with new data
                                                    window.DoughnutChartSample = new Chart($("#statistics-modal .content-main-ajax .doughnut-chart-sample")[0].getContext("2d")).Pie(data, {
                                                        responsive: true,
                                                        segmentShowStroke: false,
                                                        tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                                    });

                                                })
                                                .fail(function () {
                                                    // If there is no communication between the server, show an error
                                                    //  alert("error occured");
                                                });

                                    })
                                    .fail(function () {
                                        // If there is no communication between the server, show an error
                                        // alert("error occured");
                                    });


                        });


                        $.ajax({
                                    type: "GET",
                                    dataType: 'html',
                                    url: "/company/" + id + "/analytics?permalink={{$company['permalink']}}&metrics=ga:pageviews&filters=ga:pagePath=@/company/" + permalink + "&dimensions=ga:date&from={{$dal->format("d-m-Y")}}&to={{$al->format("d-m-Y")}}&general=true&companyName=" + name, // This is the URL to the API
                                })
                                .done(function (data) {
                                    $("#statistics-modal .form-loader").hide();
                                    // When the response to the AJAX request comes back render the chart with new data
                                    $("#statistics-modal .content-main-ajax").html(data);

                                    $('#statistics-modal .content-main-ajax .sparklines').sparkline('html', {
                                        type: 'line',
                                        width: '100%',
                                        height: '50',
                                        lineWidth: 2,
                                        lineColor: '#ffcc80',
                                        fillColor: 'rgba(255, 152, 0, 0.5)',
                                        highlightSpotColor: '#ffcc80',
                                        highlightLineColor: '#ffcc80',
                                        minSpotColor: '#f44336',
                                        maxSpotColor: '#4caf50',
                                        spotColor: '#ffcc80',
                                        spotRadius: 4,
                                    });

                                    var sorgentiVisite = [];
                                    $("#statistics-modal .content-main-ajax .pageView-Referral").each(function (i, val) {
                                        sorgentiVisite[i] = new Chart($(this)[0].getContext("2d")).Pie(jQuery.parseJSON($(this).attr("data")), {
                                            responsive: true,
                                            segmentShowStroke: false,
                                            tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                        });
                                    });

                                    var chart = [];
                                    $("#statistics-modal .content-main-ajax .torta").each(function (i, val) {
                                        chart[i] = new Chart($(this)[0].getContext("2d")).Pie(jQuery.parseJSON($(this).attr("data")), {
                                            responsive: true,
                                            segmentShowStroke: false,
                                            tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                        });
                                    });


                                    $.ajax({
                                                type: "GET",
                                                dataType: 'json',
                                                url: "/company/" + id + "/referral", // This is the URL to the API
                                            })
                                            .done(function (data) {
                                                // When the response to the AJAX request comes back render the chart with new data
                                                window.DoughnutChartSample = new Chart($("#statistics-modal .content-main-ajax .doughnut-chart-sample")[0].getContext("2d")).Pie(data, {
                                                    responsive: true,
                                                    segmentShowStroke: false,
                                                    tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                                                });

                                                $("#detailForm").show();

                                            })
                                            .fail(function () {
                                                // If there is no communication between the server, show an error
                                                //  alert("error occured");
                                            });

                                })
                                .fail(function () {
                                    // If there is no communication between the server, show an error
                                    // alert("error occured");
                                });


                    });

                });


            </script>
@endsection