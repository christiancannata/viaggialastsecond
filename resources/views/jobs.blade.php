@extends('template.layout')

@yield('header')



@section('content')
    @include('template.sticky-menu')



    <div class="container-fluid how-it-works-container panels-job-container jobs-container no-bordered-container">


            <div class="container" style="margin-top:80px;">
                <div class="row">
                        <div class="col col-md-16">
                            <div class="search-block-meritocracy-logo  hidden-xs  hidden-sm" style="margin-left: -10px;
    margin-top: 26px;">
                                <img src="/img/logos/black-logo.png" class="header-menu-meritocracy-logo-image">
                            </div>
                            <div id="sticky-anchor"></div>
                            <div class="text-seperated " style="margin-left: 160px;margin-top:-20px">
                            </div>

                        </div>
                </div>
            </div>


        <div class="container">





            <div class="row">

                <div class="panel with-nav-tabs panel-default" style="">
                    <div class="panel-heading" style="">
                        <ul class="nav nav-tabs">
                            @if(!$companyOpenTab)
                                <li class="active"><a  href="#tab1default" data-toggle="tab" data-translate="">
                                        {{ trans($route.'.tab_1_title') }}
                                    </a></li>
                                <li class="" ><a href="#tab2default" data-toggle="tab" data-translate="">
                                        {{ trans($route.'.tab_2_title') }}
                                    </a></li>

                                @else
                                <li class="active" ><a href="#tab2default" data-toggle="tab" data-translate="">
                                        {{ trans($route.'.tab_2_title') }}
                                    </a></li>
                                <li ><a  href="#tab1default" data-toggle="tab" data-translate="">
                                        {{ trans($route.'.tab_1_title') }}
                                    </a></li>
                                @endif
                        </ul>
                    </div>
                    <div class="panel-body jobs-panel">
                        <div class="tab-content">
                            <div class="tab-pane fade in @if(!$companyOpenTab) active @endif  container-banner jobs-full" id="tab1default">


                                <div data-limit="0" id="companies" data-only-premium="false"></div>
                            </div>

                            <div class="tab-pane fade in @if($companyOpenTab) active @endif container-banner jobs-full" id="tab2default">

                                <div class="row">
                                    <div class="col col-md-12 col-md-offset-2 bordered-bottom-search">
                                        <form method="GET" action="/search"> <input name="key" class="search-block-input" data-translate="" placeholder="{{ trans('homepage.placeholder_search') }}"
                                                                                    autocomplete="on" type="text" value="{{Input::get("key")}}" required>
                                            <button class="btn-search"><i class="fa fa-search" style=""></i></button>
                                        </form>



                                    </div>

                                    <div class="col col-md-16 text-left" style="background: rgba(255, 255, 255, 0.95) none repeat scroll 0 0;
    margin-left: 10%;
    margin-top: 20px;
    padding-bottom: 20px;
    padding-left: 30px;
    width: 79%;">
<!--
                                        <font style="font-style: italic;color:#7C7287;float:left">{{trans('common.ultime_ricerche')}}</font> -->
                                        <?php
                                        foreach(array_slice($categories,0,8) as $key=>$category){ ?>
                                        <a style="float:left;min-width:40px;text-align:center" class="tag" href="{{$category['link']}}">{{$category['name']}}</a>
                                        <?php }


                                        ?>
                                        <p class="show-more-label" onclick="$(this).remove(); $('.show-more').removeClass('hide')">More...</p>
                                        <div class="hide show-more">
                                            <?php
                                            foreach(array_slice($categories,7,count($categories)) as $key=>$category){ ?>
                                            <a style="float:left;min-width:40px;text-align:center" class="tag" href="{{$category['link']}}">{{$category['name']}}</a>
                                            <?php }


                                            ?>
                                        </div>
                                    </div>


                                </div>


                                <div data-limit="0" id="vacancies"></div>


                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>



    <div class="container-fluid slideshow-container hide">
        <div class="container">
            <div class="row">
                <div class="col col-md-16">
                    <div class="slideshow">

                        <div id="myCarousel" class="carousel slide" data-ride="carousel">


                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="item ">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="item ">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="item ">
                                    <div class="row">
                                        <div class="col col-md-4 col-md-offset-2">
                                            <h6>scopri meritocracy</h6>

                                            <p class="intro-text">Lorem ipsum dolor
                                                sit amet, consectetur adipiscing elit.
                                                Quisque ornare nibh arcu, ac
                                                scelerisque urna venenatis sed.
                                                Suspendisse dictum dapibus nibh
                                                suscipit aliquam.</p></div>
                                        <div class="col col-md-8 "><h4>Join us or request information</h4>

                                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                Quisque
                                                ornare nibh arcu, ac scelerisque urna venenatis sed. Suspendisse
                                                dictum
                                                dapibus nibh suscipit aliquam. Maecenas fringilla, mi sed egestas
                                                egestas,
                                                nibh nisi iaculis dui, id ultrices lectus elit eget risus. Duis
                                                imperdiet
                                                libero at metus congue vestibulum. Maecenas sollicitudin turpis
                                                dignissim
                                                gravida gravida. Maecenas non magna mi. Fusce rhoncus, augue a
                                                consectetur
                                                aliquet, ante sapien varius turpis, at viverra enim quam eget
                                                turpis.
                                                Maecenas vitae rhoncus est. </p>

                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <button class="btn btn-transparent bordered-white-button">
                                                        <span>Join us</span>
                                                    </button>
                                                    <button class="btn dark-button header-menu-btn-2">
                                                        <span>Subscribe now</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <img src="/img/freccia_sx.png">

                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <img src="/img/freccia_dx.png">
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript" src="{{auto_version("/js/pages/jobs.js")}}"></script>


    <script src="{{auto_version("/js/app/build/min/vacanciesReact.min.js")}}"></script>
    <script src="{{auto_version("/js/app/build/min/companiesReact.min.js")}}"></script>


    <!-- Google Code per il tag di remarketing -->
    <!--------------------------------------------------
    I tag di remarketing possono non essere associati a informazioni di identificazione personale o inseriti in pagine relative a categorie sensibili. Ulteriori informazioni e istruzioni su come impostare il tag sono disponibili alla pagina: http://google.com/ads/remarketingsetup
    --------------------------------------------------->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 939631663;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/939631663/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>


    <script>
        JobsPage.init();
    </script>
@endsection