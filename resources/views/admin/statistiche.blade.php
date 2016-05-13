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


        <div data-count="" data-other="" id="vacancies">
            <div class="col s12 m12 l12">
                <?php
                $applicationTotali = 0;
                ?>

                        <!--DataTables example-->
                <div id="table-datatables">
                    <div class="row">

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
                                        <td><a href="/admin/{{$company['permalink']}}/statistics" data-id="{{$company['id']}}" data-name="{{$company['name']}}"
                                               data-permalink="{{$company['permalink']}}"
                                               class="btn btn-red ">Statistiche</a></td>
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




    <div id="statistics-modal" class="modal std-modal" style="width:90%;min-height: 500px">
        <div class="modal-content">
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
            </div>

            <div class="input-field col s6" style="width:30%;margin-left:30px">
                <select id="comparaCompany" name="company"
                >
                    <option value="" disabled selected>Scegli l'azienda</option>
                    @foreach($companies as $company)
                        <option data-id="{{$company['id']}}" data-name="{{$company['name']}}"
                                data-permalink="{{$company['permalink']}}"
                                value="{{$company['id']}}">{{$company['name']}}</option>
                    @endforeach
                </select>
                <label for="vacancyAddJobFunction" lang="en">Confronta con:</label>

            </div>
            <div class="content-main-ajax">

            </div>

            <div class="content-second-ajax">

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
                $("#statistics-modal .modal-content .content-second-ajax").empty();

                $.ajax({
                            type: "GET",
                            dataType: 'html',
                            url: "/company/" + id + "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/" + permalink + "&dimensions=ga:date&from=P13D&to=yesterday&companyName=" + name, // This is the URL to the API
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data
                            $("#statistics-modal .modal-content .content-second-ajax").html(data);


                            $('#statistics-modal .modal-content .content-second-ajax .sparklines').sparkline('html', {
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

                            window.VisiteReferral = new Chart($("#statistics-modal .modal-content .content-second-ajax .pageView-Referral")[0].getContext("2d")).Pie(jQuery.parseJSON($("#statistics-modal .modal-content .content-main-ajax .pageView-Referral").attr("data")), {
                                responsive: true,
                                segmentShowStroke: false,
                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                            });


                            var chart = [];
                            $("#statistics-modal .modal-content .content-second-ajax .torta").each(function (i,val) {
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
                                        window.DoughnutChartSample = new Chart($("#statistics-modal .modal-content .content-second-ajax .doughnut-chart-sample")[0].getContext("2d")).Pie(data, {
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

            $(document).on('click', '.load-statistics', function (e) {
                e.preventDefault();

                var permalink = $(this).attr("data-permalink");
                var id = $(this).attr("data-id");
                var name = $(this).attr("data-name");
                $("#statistics-modal .modal-content .content-main-ajax").empty();
                $("#statistics-modal .modal-content .content-second-ajax").empty();

                $("#statistics-modal .form-loader").show();
                $("#statistics-modal").openModal();

                $.ajax({
                            type: "GET",
                            dataType: 'html',
                            url: "/company/" + id + "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/" + permalink + "&dimensions=ga:date&from=P13D&to=yesterday&companyName=" + name, // This is the URL to the API
                        })
                        .done(function (data) {
                            $("#statistics-modal .form-loader").hide();
                            // When the response to the AJAX request comes back render the chart with new data
                            $("#statistics-modal .modal-content .content-main-ajax").html(data);


                            $('#statistics-modal .modal-content .content-main-ajax .sparklines').sparkline('html', {
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

                            window.VisiteReferral = new Chart($("#statistics-modal .modal-content .content-main-ajax .pageView-Referral")[0].getContext("2d")).Pie(jQuery.parseJSON($("#statistics-modal .modal-content .content-main-ajax .pageView-Referral").attr("data")), {
                                responsive: true,
                                segmentShowStroke: false,
                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                            });

                            var chart = [];
                            $("#statistics-modal .modal-content .content-main-ajax .torta").each(function (i,val) {
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
                                        window.DoughnutChartSample = new Chart($("#statistics-modal .modal-content .content-main-ajax .doughnut-chart-sample")[0].getContext("2d")).Pie(data, {
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

        });


    </script>
@endsection