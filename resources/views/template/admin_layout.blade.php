<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->

<head>
    <meta name="env" content="{{getenv('APP_ENV')}}"/>

    <meta name="route" content="{{Route::getCurrentRoute()->getPath()}}"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="{{$description or ""}}">
     <title>{{$title or ""}} | Meritocracy</title>

    <link href="/css/tapatar.min.css" type="text/css" rel="stylesheet">

    <!-- CORE CSS-->
    <link href="/admin/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{auto_version("/admin/css/style.css")}}" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="{{auto_version("/admin/css/custom/custom-style.css")}}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/admin/js/plugins/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet"
          media="screen,projection">


    <link href="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="/admin/js/plugins/jvectormap/jquery-jvectormap.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="/admin/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png?v=lkkzJr42O3">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png?v=lkkzJr42O3">
    <link rel="icon" type="image/png" href="/favicon-32x32.png?v=lkkzJr42O3" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-194x194.png?v=lkkzJr42O3" sizes="194x194">
    <link rel="icon" type="image/png" href="/favicon-96x96.png?v=lkkzJr42O3" sizes="96x96">
    <link rel="icon" type="image/png" href="/android-chrome-192x192.png?v=lkkzJr42O3" sizes="192x192">
    <link rel="icon" type="image/png" href="/favicon-16x16.png?v=lkkzJr42O3" sizes="16x16">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=lkkzJr42O3" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=lkkzJr42O3">
    <meta name="apple-mobile-web-app-title" content="Meritocracy">
    <meta name="application-name" content="Meritocracy">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png?v=lkkzJr42O3">
    <link href='https://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
    <meta name="theme-color" content="#F04D52">

    <link rel="manifest" href="/manifest.json">

    <link href="/admin/js/plugins/animate-css/animate.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" >
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css"
          rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="/css/jquery-te-1.4.0.css" rel="stylesheet">

    <link rel="stylesheet" href="/vendors/bootstrap-fileinput/css/fileinput.min.css">

    <link href="/css/summernote.css" rel="stylesheet">
    <link href="/admin/css/plugins/tipped.css" rel="stylesheet">

    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.theme.min.css" rel="stylesheet">
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>



    @yield('page-css')

</head>

<body>


<!-- //////////////////////////////////////////////////////////////////////////// -->

@include("template.".strtolower(isset(Auth::user()->type) ? Auth::user()->type : "user")  ."_header")


        <!-- //////////////////////////////////////////////////////////////////////////// -->

<!-- START MAIN -->
<div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">


        <!-- START LEFT SIDEBAR NAV-->


        @include("template.".strtolower(isset(Auth::user()->type) ? Auth::user()->type : "user")."_left_sidebar")

                <!-- END LEFT SIDEBAR NAV-->

        <!-- //////////////////////////////////////////////////////////////////////////// -->

        <!-- START CONTENT -->
        <section id="content">

            <!--start container-->
            <div class="container">

                @yield('breadcrumbs')
                @yield('content')


            </div>
            <!--end container-->
        </section>
        <!-- END CONTENT -->

        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START RIGHT SIDEBAR NAV-->

        @include("template.".strtolower(isset(Auth::user()->type) ? Auth::user()->type : "user")."_right_sidebar")


                <!-- LEFT RIGHT SIDEBAR NAV-->

    </div>
    <!-- END WRAPPER -->

</div>
<!-- END MAIN -->


@include("template.".strtolower(isset(Auth::user()->type) ? Auth::user()->type : "user")."_footer")
        <!-- include summernote css/js-->
<script src="/js/trumbowyg.js"></script>
</body>


</html>