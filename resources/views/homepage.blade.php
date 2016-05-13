@extends('template.layout')

@yield('header')
<style>
    .header-top-menu ul li a {
        color: white !important;
        font-family: 'Karla-Bold', sans-serif;
        font-weight: 200;

    }

    #fullpage {
        height: 100% !important;
    }
    video#bgvid {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: -100;
        -ms-transform: translateX(-50%) translateY(-50%);
        -moz-transform: translateX(-50%) translateY(-50%);
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        background: url('/video/thumb_video.png') no-repeat;
        background-size: cover;
    }

    @media (max-width: 767px) {
        .background-image {
            background: url('https://storage.meritocracy.is/companies/Uploaded/mcX4tyCBTzKMka3dBThw_Samsung_14.jpg')no-repeat center cente!importantr;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        #bgvid {
            display: none;
        }

    }
    @media (min-width: 768px) {
        .background-image {
            background: url('/video/thumb_video.png') no-repeat !important;
        }

    }


</style>
@section('content')

    @if($route=="homepage")
        <video autoplay loop muted poster="/video/thumb_video.png" id="bgvid">
             <source src="https://storage.meritocracy.is/Video/Meritocracy_Home.webm" type="video/webm"
                    media="all and (min-width:1441)">
            <source src="http://meritocracy-2.0.s3.amazonaws.com/Video/Meritocracy_Home.1280.mp4" type="video/mp4"
                    media="all and (max-width:1280)">
            <source src="https://storage.meritocracy.is/Video/Meritocracy_Home.1440.mp4" type="video/mp4"
                    media="all and (min-width:1281) and (max-width:1440)">
            <source src="https://storage.meritocracy.is/Video/Meritocracy_Home.m4v" type="video/mp4"
                    media="all and (min-width:1441)">
            @if($isFirefox)
            <source src="https://storage.meritocracy.is/Video/Meritocracy_Home.webm" type="video/webm"
                    media="">
            @endif
            Your browser doesn't support HTML5 video in WebM with VP8 or MP4 with H.264.
        </video>
    @endif

    <div class="container video-custom" style="">


        <div class="row">


            <!-- END LANDING PAGE HEADER !-->


            <!-- BEGIN CENTRAL BLOCK !-->
            <div class="col col-md-12 col-md-offset-2">
                <div class="central-block-white">

                    <div class="search-block-split">
                        <div class="search-block-meritocracy-logo  hidden-xs  hidden-sm">
                            <img class="header-menu-meritocracy-logo-image" src="/img/logos/black-logo.png"
                                 alt="Trova l'opportunità dove sviluppare il tuo talento "
                                 title="Trova l'opportunità dove sviluppare il tuo talento ">
                        </div>
                        <form method="GET" action="/search" id="form-search" style="margin-bottom:0px">
                            <input pattern="^.{2,}$" required name="key" class="search-block-input" data-translate=""
                                   placeholder="{{ trans($route.'.placeholder_search') }}"
                                   autocomplete="on" type="search">
                            <button class="btn-search"><i class="fa fa-search" style=""></i></button>
                        </form>

                    </div>
                    <?php
                    if(isset($_COOKIE['search']) && $_COOKIE['search'] != "" ){?>
                    <div class="col col-md-16 text-left"
                         style="background:rgba(255, 255, 255, 0.95) none repeat scroll 0 0;padding-bottom: 20px;">

                        <font style="font-style: italic;color:#7C7287">{{trans('common.ultime_ricerche')}}</font>
                        <?php $arraySearch = json_decode($_COOKIE['search'], true);
                        array_reverse($arraySearch);
                        foreach(array_slice($arraySearch, 0, 5) as $search){ ?>
                        <a style="" class="tag tag-ricerca" href="/search?key={{urlencode($search)}}">{{$search}}</a>
                        <?php }


                        ?>
                    </div>
                    <?php  } ?>
                </div>
            </div>
            <div class="col col-md-12 col-md-offset-2">

                <div class="central-block">

                    <div class="row search-block ">

                        <div class="col col-md-16 search-block-header text-center">
                            <div class="row">

                                <div class="col col-md-offset-1 col-md-14">

                                    <h1 data-translate="">
                                        {!!  trans($route.'.h1_main_title') !!}
                                    </h1>


                                    <h3 data-translate="">
                                        {!! trans($route.'.h3_main_subtitle') !!}
                                    </h3>

                                    <div id="sticky-anchor"></div>
                                </div>

                                <div style="" class="col col-md-16 scopri-meritocracy">

                                    <img class="hvr-wobble-vertical" alt="" src="/img/icon_scroll.png"/>

                                    <div id="scroll-anchor"></div>
                                </div>
                            </div>

                        </div>


                    </div>


                </div>
            </div>

            <!-- END CENTRAL BLOCK !-->


        </div>
    </div>






    @include('template.sticky-menu')




    <div class="container-fluid jobs-container ">

        <div class="container padded">


            <div class="row">
                <div class="col col-md-4">
                    <div id="scroll-anchor"></div>
                    <a href="/jobs" target="_blank" class="red-label"
                       data-translate="">{{ trans($route.'.title_companies_box') }}</a>
                </div>
                <div class="col col-md-offset-2 col-md-6"><p class="grey-label" data-translate="">
                        {{ trans($route.'.subtitle_companies_box') }}
                    </p></div>
            </div>

            <div data-limit="4" id="companies" data-only-premium="true">

            </div>

            <div class="row">
                <div class="col-md-16 text-center margin-top-10">
                    <a href="/jobs" class="btn btn-red bordered-white-button  btn-large large btn-big scopri-tutte"
                       style="text-transform: none;">
                        <span>{{trans('common.browse_all_companies')}}</span>
                    </a>

                </div>
            </div>

            <div class="row">
                <div class="col col-md-16">
                    <div class="sponsor-company">
                        <div class="row">
                            <div class="col col-md-16">
                                <h4 data-translate="partner_title">{{ trans('common.partner_title') }}</h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-md-2 col-xs-5 col-sm-4 col-md-offset-1 ">
                                <a target="_blank" href="/aon">
                                    <img title="Scopri le posizioni lavorative di aon"
                                         alt="Scopri le posizioni lavorative di aon"
                                         src="/img/loghi_aziende/aon-blu.png">
                                </a>
                            </div>
                            <div class="col col-md-2 col-xs-5 col-sm-4">
                                <a target="_blank" href="/cloetta">
                                    <img title="Scopri le posizioni lavorative di cloetta"
                                         alt="Scopri le posizioni lavorative di cloetta"
                                         src="/img/loghi_aziende/cloetta-blu.png">
                                </a>
                            </div>
                            <div class="col col-md-2 col-xs-5 col-sm-4">
                                <a target="_blank" href="/dechatlon">
                                    <img title="Scopri le posizioni lavorative di decathlon"
                                         alt="Scopri le posizioni lavorative di decathlon"
                                         src="/img/loghi_aziende/decha-blu.png">
                                </a>
                            </div>
                            <div class="col col-md-2 col-xs-5 col-sm-4">
                                <a target="_blank" href="/groupm">
                                    <img title="Scopri le posizioni lavorative di groupm"
                                         alt="Scopri le posizioni lavorative di groupm"
                                         src="/img/loghi_aziende/groupm-blu.png">
                                </a>
                            </div>
                            <div class="col col-md-2 col-xs-5 col-sm-4">
                                <a target="_blank" href="/samsung">
                                    <img title="Scopri le posizioni lavorative di samsung"
                                         alt="Scopri le posizioni lavorative di samsung"
                                         src="/img/loghi_aziende/samsung-blu.png">
                                </a>
                            </div>
                            <div class="col col-md-2 col-xs-5 col-sm-4">
                                <a target="_blank" href="/tesla">
                                    <img title="Scopri le posizioni lavorative di tesla"
                                         alt="Scopri le posizioni lavorative di tesla"
                                         src="/img/loghi_aziende/tesla-blu.png">
                                </a>
                            </div>
                            <div class="col col-md-2 col-xs-5 col-sm-4">
                                <a target="_blank" href="/tetrapak">
                                    <img title="Scopri le posizioni lavorative di tetrapak"
                                         alt="Scopri le posizioni lavorative di tetrapak"
                                         src="/img/loghi_aziende/tetra-blu.png">
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="container-fluid how-it-works-container">
        <div class="container">
            <div class="row">
                <div class="col col-md-4"><p class="red-label"
                                             data-translate="">{{ trans($route.'.title_candidati_box') }}</p></div>
                <div class="col col-md-offset-2 col-md-8"><p class="white-label"
                                                             data-translate="">{{ trans($route.'.subtitle_candidati_box') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-16 hidden-xs">


                    <div class="banner">
                        <h4 data-translate="">{{ trans($route.'.box_1_title') }}</h4>
                        <img title="Scopri il tuo talento" alt="Scopri il tuo talento" src="/img/infografica_1.png"
                             class="image">

                        <p data-translate="">{{ trans($route.'.box_1_subtitle') }}
                        </p>
                    </div>

                    <div class="banner center">
                        <h4 data-translate="">{{ trans($route.'.box_2_title') }}</h4>
                        <img title="Acquisisci candidati" alt="Acquisici candidati" src="/img/infografica_3.png"
                             class="image">

                        <p data-translate="">{{ trans($route.'.box_2_subtitle') }}
                        </p>

                    </div>

                    <div class="banner ">
                        <h4 data-translate="">{{ trans($route.'.box_3_title') }}</h4>
                        <img title="Migliora il tuo employer branding" alt="migliora il tuo employer branding"
                             src="/img/infografica_2.png" class="image">

                        <p data-translate="">{{ trans($route.'.box_3_subtitle') }}  </p>
                    </div>
                </div>

                <div class="col col-md-16 hidden-md hidden-lg hidden-sm mobile-banner">
                    <div class="banner">
                        <h4 data-translate="">{{ trans($route.'.box_1_title') }}</h4>
                        <img title="Migliora il tuo employer branding" alt="migliora il tuo employer branding"
                             src="/img/infografica_1.png" class="image">

                        <p data-translate="">{{ trans($route.'.box_1_subtitle') }}
                        </p>
                    </div>

                </div>
                <div class="col col-md-16 hidden-md hidden-lg hidden-sm  mobile-banner">
                    <div class="banner">
                        <h4 data-translate="">{{ trans($route.'.box_2_title') }}</h4>
                        <img title="Acquisisci candidati" alt="Acquisici candidati" src="/img/infografica_3.png"
                             class="image">

                        <p data-translate="">{{ trans($route.'.box_2_subtitle') }}
                        </p>

                    </div>


                </div>
                <div class="col col-md-16 hidden-md hidden-lg hidden-sm mobile-banner">
                    <div class="banner ">
                        <h4 data-translate="">{{ trans($route.'.box_3_title') }}</h4>
                        <img title="Scopri il tuo talento" alt="Scopri il tuo talento" src="/img/infografica_2.png"
                             class="image">

                        <p data-translate="">{{ trans($route.'.box_3_subtitle') }}  </p>
                    </div>

                </div>

            </div>

        </div>
    </div>


    <div class="container-fluid testimonials-container hide">
        <div class="container">
            <div class="row">
                <div class="col col-md-16">
                    <div class="testimonials">
                        <h5>Testimonials</h5>

                        <p class="testimonials-label">How it works per i Candidati</p>

                        <p class="author">Mario Rossi - Manager Director for Samsung</p>
                    </div>
                </div>

            </div>

        </div>
    </div>


    @include('jolly')
@endsection

@section('pre-page-scripts')
    <script>
        $('#fullpage').fullpage({});
    </script>

@endsection
@section('page-scripts')

    <script>
        @if(Auth::check() && Auth::user()->vacancies_applicated)
        $(document).ready(function () {
            setTimeout(function () {
                if ($.cookie('_pushHomeRequest') == null || $.cookie('_pushHomeRequest') != 1) {
                    $.cookie('_pushHomeRequest', 1, {expires: 7});
                    requirePush();
                }
            }, 2000);
        });

        @endif
    </script>
    <script type="text/javascript" src="{{auto_version("/js/pages/homepage.js")}}"></script>

    <script type="text/javascript" src="{{auto_version("/js/app/build/min/companiesReact.min.js")}}"></script>
    <script type="text/javascript" src="/js/inViewPort.js"></script>

    <script>Homepage.init();</script>
    <!--[if lt IE 9]>
    <script>
        document.createElement('video');
    </script>
    <![endif]-->

@endsection
