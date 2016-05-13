<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>

    <meta name="route" content="{{$route}}" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{$title}} | Meritocracy</title>

    <meta name="description" content="{{$description}}">
    <meta content="Meritocracy" name="author">




    <!-- Styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    @yield('page-css')

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
    <link rel="manifest" href="/manifest.json?v=lkkzJr42O3">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=lkkzJr42O3" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=lkkzJr42O3">
    <meta name="apple-mobile-web-app-title" content="Meritocracy">
    <meta name="application-name" content="Meritocracy">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png?v=lkkzJr42O3">
    <meta name="theme-color" content="#F04D52">
    <link rel="manifest" href="/manifest.json">
</head>

<body>

@yield('content')


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/modernizr.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script>

    /**
     * Google analytics
     */

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-48257611-1', 'auto');
    ga('send', 'pageview');


</script>

@yield('page-scripts')
</body>
</html>
