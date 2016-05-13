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
<link href="/admin/js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<style>
    #main {
        padding-left: 0!important;
    }
    @media only screen
    and (min-device-width: 1024px){
        #error-page {
            position: fixed;
            top: 50%;
            left: 50%;
            /* bring your own prefixes */
            transform: translate(-50%, -50%);
        }
    }
    #site-layout-example-right{
        height: 315px!important;
    }

</style>
@endsection



@section('content')



    <div class="" id="error-page">

        <div class="row">
            <div class="col s12">
                <div class="browser-window">
                    <div class="top-bar">
                        <div class="circles">
                            <div id="close-circle" class="circle"></div>
                            <div id="minimize-circle" class="circle"></div>
                            <div id="maximize-circle" class="circle"></div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row">
                            <div id="site-layout-example-top" class="col s12">
                                <p class="flat-text-logo center white-text caption-uppercase">{{trans('common.error_header')}}</p>
                            </div>
                            <div id="site-layout-example-right" class="col s12 m12 l12">
                                <div class="row center">
                                    <h2 style="font-size: 50px;" class="white-text text-long-shadow col s12">{{trans('common.error_title')}}</h2>
                                </div>
                                <div class="row center">
                                    <p style="font-size: 20px;" class="center white-text col s12 ">{!! trans('common.error_desc') !!}</p>
                                    <p class="center s12">
                                        <button onclick="goBack()" class="btn waves-effect waves-light red">{!! trans('common.back') !!}</button>
                                        <button style="margin-left: 20px;" href="/" class="btn waves-effect waves-light red">Homepage</button>
                                    <p>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>

@endsection
