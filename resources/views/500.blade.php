@extends('template.layout')

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
<style>
    #main {
        padding-left: 0 !important;
    }

    h3 {
        font-size: 27px;
    }
    @media only screen and (max-device-width: 1023px) {
        #error-page {
            margin-top: 150px;
        }
    }
    @media only screen
    and (min-device-width: 1024px) {
        h3 {
            font-size: 19px;
        }
        #error-page {
            position: fixed;
            top: 50%;
            left: 50%;
            /* bring your own prefixes */
            transform: translate(-50%, -50%);
        }
    }

    #site-layout-example-right {
        height: 315px !important;
    }

    #header{
        display: none;
    }
    .footer {
        display: none;
    }

    h2,p,h3 {
        color: white;
        text-align: center;
    }
    body{
        background-color: #F04D52!important;
        background-image: none!important;
    }
    #header{
        display: none;
    }
    .header-menu-btn-1,.header-menu-btn-2{
        display: none;
    }
    .header-menu ul li a{
        color: white!important;
    }
    .homepage-button {
        margin-left: 20px; border: 1px solid white !important; margin-top: 0px;
    }

</style>
@endsection



@section('content')

    <div class="center">
        <div id="error-page" class="valign">



            <div class="row">
                <div class="col col-md-16 col-xs-16">

                    <h2 style="font-size: 80px;"
                        class="white-text center col s12 fadeInDown animated">{{trans('common.error_title')}}</h2>

                    <h3 class="center white-text col-md-12 col-md-offset-2 col-xs-12 col-xs-offset-2 fadeInDown animated">{!! trans('common.error_desc') !!}</h3>

                    <div  style="margin-top: 20px; text-align: center;" class="col col-md-16 col-xs-16 center">
                        <button  onclick="goBack()"
                                 class="btn dark-button btn-big fadeInDown animated">{!! trans('common.back') !!}</button>
                        <a  href="https://meritocracy.is" class="btn btn-red btn-big homepage-button fadeInDown animated center">Homepage
                        </a>
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
