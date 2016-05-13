<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description"
          content="{{$description}}">

    <title>{{$title}} | Meritocracy</title>

    <!-- Favicons-->
    <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.theme.min.css" rel="stylesheet">

    <!-- CORE CSS-->

    <link href="/admin/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/admin/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="/admin/css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/admin/css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://platform.linkedin.com/in.js">
        api_key: 77y03jogf7nzph
        authorize: true
    </script>
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

        @if(isset($trackPageView))
         ga('send', 'pageview', '{{$trackPageView}}');
        @else
           ga('send', 'pageview');
        @endif
    </script>
</head>

<body class="cyan">

<div class="input-field col s12 center">
    <a href="/{{App::getLocale()}}/">
        <img src="/img/logos/white-full-logo.png" class=" responsive-img "></a>
</div>

<div style="margin-top: 30px;" id="login-page" class="row">

    <div class="col s12 z-depth-2 card-panel" style="padding-bottom:20px">
        @yield("content")

    </div>
</div>


<!-- ================================================
  Scripts
  ================================================ -->

<!-- jQuery Library -->
<script type="text/javascript" src="/admin/js/plugins/jquery-1.11.2.min.js"></script>
<!-- jQuery Library -->
<!--materialize js-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


<!--materialize js-->
<script type="text/javascript" src="/admin/js/materialize.js"></script>
<!--prism-->
<script type="text/javascript" src="/admin/js/plugins/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="/admin/js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="/admin/js/custom-script.js"></script>
<script type="text/javascript" src="/js/strength.min.js"></script>

<script type="text/javascript" src="/js/main.js"></script>
<script src="https://cdn.ravenjs.com/3.0.3/console/raven.min.js"></script>
<script>
    /*** Raven for Javascript Exception Handlers ***/
    Raven.config('https://3c874071c7ca47bbb5767984f485cb7c@app.getsentry.com/43384', {
        release: '3.2.1',
        fetchContext: true,
        includePaths: [/https?:\/\/meritocracy\.is/, /http?:\/\/beta\.meritocracy\.is/]

    }).install();

    Raven.setUserContext({
        email: '{{Auth::check() && Auth::user()->email or "" }}',
        id: '{{Auth::check() && Auth::user()->id or "" }}'
    });

</script>
@yield("page-scripts")
</body>

</html>