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

    <meta property="og:site_name" content="Meritocracy.is">
    <meta property="og:title" content="{{$title or 'Meritocracy'}}">
    <meta property="og:description" content="{{$description or 'Meritocracy helps jobseekers to find their dream jobs and companies to improve their employer branding strategy and select the best candidates'}}">
    <meta property="og:image" content="{{$image or 'http://meritocracy.is/img/logo_black.png'}}">
    <meta property="og:url" content="{{$url or 'https://meritocracy.is'}}">


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Meritocracy_is">
    <meta name="twitter:description" content="{{$description or 'Meritocracy helps jobseekers to find their dream jobs and companies to improve their employer branding strategy and select the best candidates'}}">
    <meta name="twitter:title" content="{{$title or 'Meritocracy'}}">
    <meta name="twitter:image:src" content="{{$image or 'http://meritocracy.is/img/logo_black.png'}}">




    <!-- Styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/jquery.fullpage.min.css" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/hover-min.css" rel="stylesheet">
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/css/social.css" rel="stylesheet">
    <link href="/css/menu.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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
   <!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script> -->
    <link rel="manifest" href="/manifest.json">
    <script>
        var OneSignal = OneSignal || [];

        OneSignal.push(["init", {path: "/", appId: "464434c7-dadc-4edb-8a80-fb73dcb5040d", safari_web_id: "web.onesignal.auto.650c091f-37ea-4fe0-8793-2961481353d2"}]);
    </script>

    <script type="text/javascript">
        window.heap=window.heap||[],heap.load=function(e,t){window.heap.appid=e,window.heap.config=t=t||{};var n=t.forceSSL||"https:"===document.location.protocol,a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=(n?"https:":"http:")+"//cdn.heapanalytics.com/js/heap-"+e+".js";var o=document.getElementsByTagName("script")[0];o.parentNode.insertBefore(a,o);for(var r=function(e){return function(){heap.push([e].concat(Array.prototype.slice.call(arguments,0)))}},p=["clearEventProperties","identify","setEventProperties","track","unsetEventProperty"],c=0;c<p.length;c++)heap[p[c]]=r(p[c])};
        heap.load("3211551371");
    </script>

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '756054691129338',
                xfbml      : true,
                version    : 'v2.5'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script src="//cdn.optimizely.com/js/3835022213.js"></script>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '1118004568212356');
        fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1118004568212356&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body class="{{ $customClass or 'background-image' }} {{ isset($route) ? $route : '' }}">

@yield('content')
</body>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.fullpage.min.js"></script>
<script type="text/javascript" src="/js/social-share.js"></script>
<script type="text/javascript" src="/js/modernizr.js"></script>
<script type="text/javascript" src="/js/jsonGenerator.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script src="https://cdn.ravenjs.com/1.3.0/jquery,native/raven.min.js"></script>
<script type="text/javascript" src="/js/utils/timezone.js"></script>

<script type="text/javascript" src="/js/strength.min.js"></script>

<script type="text/javascript" src="/js/main.js"></script>
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


    /**
     * Facebook SDK for Login & Tracking Pixels
     */


    /**
     * Raven for Javascript Exception Handlers
     */


    Raven.config('https://3c874071c7ca47bbb5767984f485cb7c@app.getsentry.com/43384', {
        release: '3.1.2',
        fetchContext: true,
        includePaths: [/https?:\/\/meritocracy\.is/, /http?:\/\/beta\.meritocracy\.is/]

    }).install();

    /**
     * Additional configurations
     */

    try {
        var tz = jstz.determine();
        document.cookie = "timezone=" + tz.name();
    } catch (ee) {
    }

</script>

<noscript>
    <img height="1" width="1" style="display:none;" alt=""
         src="https://analytics.twitter.com/i/adsct?txn_id=ntwyc&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
    <img height="1" width="1" style="display:none;" alt=""
         src="//t.co/i/adsct?txn_id=ntwyc&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
</noscript>
<noscript><img height="1" width="1" alt="" style="display:none"
               src="https://www.facebook.com/tr?ev=6029407180249&amp;cd[value]=0.01&amp;cd[currency]=EUR&amp;noscript=1"/>
</noscript>
@yield('page-scripts')

</html>
