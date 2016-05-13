@extends('template.admin_layout')

@yield('header')

@section('page-css')
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
<style>


</style>
@endsection


@section('breadcrumbs')

        <!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <!-- Search for small screen -->

    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Administrator</h5>
                <ol class="breadcrumbs">
                    <li><a href="/tags">Tags</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection
@section('content')


    <div class="section">


        <div class="col s12">
            <div id="tag-container" style="height: 700px"></div>
            <div id="drag"></div>
            <div id="drop"></div>

        </div>
    </div>



@endsection

@section('page-scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://rawgithub.com/highslide-software/draggable-points/master/draggable-points.js?1"></script>
    <script type="text/javascript" src="//code.highcharts.com/stock/highstock.js"></script>
    <script type="text/javascript" src="//code.highcharts.com/modules/heatmap.js"></script>
    <script src="/js/pages/tag-manager.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            TagManager.init();
        });

    </script>

@endsection
