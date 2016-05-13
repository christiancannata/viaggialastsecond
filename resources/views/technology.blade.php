@extends('template.layout')

@yield('header')



@section('content')




    <div class="container-fluid">

        <div class="row">
            <!-- BEGIN LANDING PAGE HEADER !-->


            <div style="margin-top: 80px;" class="col col-md-12 col-md-offset-2">

                <div class="banner-grey">
                    <img src="/img/Technology/technologytop.png" width="100%">
                </div>




            </div>


            <!-- END LANDING PAGE HEADER !-->


            <!-- BEGIN CENTRAL BLOCK !-->

            <div class="col col-md-12 col-md-offset-2">

                <div class="central-block">
                    <div class="search-block-meritocracy-logo  hidden-xs  hidden-sm">
                        <img class="header-menu-meritocracy-logo-image" src="/img/logos/black-logo.png">
                    </div>

                    <div class="row search-block ">

                        <div class="col col-md-offset-1 col-md-15 search-block-header">
                            <div class="row">
                                <div class="col col-md-15">
                                    <h1 class="dark-label" data-translate="">{!!  trans($route.'.h1_title') !!}</h1>


                                    <h3  class="dark-label" data-translate="">{!! trans($route.'.h3_subtitle') !!}</h3>

                                    <div id="sticky-anchor"></div>
                                </div>

                                <div style="" class="col col-md-15 scopri-meritocracy dark-label">

                                    <img   class="hvr-wobble-vertical" alt="" src="/img/freccetta-blu.png" />

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



    <div class="container-fluid technology-container">
        <div class="container">
            <div class="row technology-row">
                <div class="col col-md-5">
                    <div class="image">
                        <img src="/img/Technology/fase1.png" >


                    </div>
                </div>
                <div class="col col-md-11">
                    <div class="row">
                        <div class="col col-md-16">
                            <h2 data-translate="">{{ trans($route.'.box_1_title') }}</h2>
                        </div>
                        <div class="col col-md-16">
                           <p data-translate="">{{ trans($route.'.box_1_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row technology-row">
                <div class="col col-md-5">
                    <div class="image">
                        <img src="/img/Technology/fase2.png" >

                    </div>
                </div>
                <div class="col col-md-11">
                    <div class="row">
                        <div class="col col-md-16">
                            <h2 data-translate="">{{ trans($route.'.box_2_title') }}</h2>
                        </div>
                        <div class="col col-md-16">
                            <p data-translate="">{{ trans($route.'.box_2_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row technology-row">
                <div class="col col-md-5">
                    <div class="image">
                        <img src="/img/Technology/fase3.png" >
                    </div>
                </div>
                <div class="col col-md-11">
                    <div class="row">
                        <div class="col col-md-16">
                            <h2 data-translate="">{{ trans($route.'.box_3_title') }}</h2>
                        </div>
                        <div class="col col-md-16">
                            <p data-translate="">{{ trans($route.'.box_3_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('jolly')
@endsection


@section('page-scripts')
    <script type="text/javascript" src="/js/pages/technology.js"></script>
    <script>Technology.init();</script>
@endsection