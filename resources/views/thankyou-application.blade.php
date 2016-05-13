@extends('template.layout')

@yield('header')

@section('content')


    @include('template.sticky-menu')


    <input type="hidden" id="id_application" value="{{$application['id']}}">

    <div class="container-fluid" style="padding-bottom: 20px;background:white !important;padding-top:50px;height:100%">

        <div class="container padded">

            <div class="row center">
                <div class="col col-md-16 " style="text-align: center;"><p class="red-label"
                                              data-translate="">{{ trans($route.'.title_text_2') }}</p>
                </div>

            </div>

            <div class="row">
                <div class="col col-md-offset-0 col-md-16 center" style="text-align: center;">



                        <h3>{{ trans($route.'.candidatura_completata') }}</h3>



                    <fieldset style="margin-top:50px">

                        <div class="row">
                            <div class="col col-md-8 col-md-offset-4">
                                <a href="/user">

                                    <div class="box-summary-wizard first" id="work-box" style="width: 100%;background:#f04d52;color:white">

                                        <div class="content-summary ">
                                            <h3 class="title" style="color:white !important">{{trans('thankyou-registration.completa_profilo')}}</h3>
                                            <i class="prefix fa fa-user"  style="color:white"></i>
                                            <div class="location"  style="color:white !important">
                                                <span class="title"  style="color:white !important">{{trans('thankyou-registration.completa_profilo_text')}}</span>
                                            </div>

                                        </div>
                                    </div>
                                </a>


                                <!--
                                  <a href="/jobs">

                                    <div class="box-summary-wizard" id="education-box">


                                        <div class="content-summary ">
                                            <h3 class="title">{{trans('thankyou-registration.altre_posizioni')}}</h3>
                                            <i class="prefix fa fa-search"></i>
                                            <div class="location">
                                                <span class="title">{{trans('thankyou-registration.altre_posizioni_text')}}</span>
                                            </div>

                                        </div>
                                    </div>

                                  </a>

                                    <a href="/">

                                        <div class="box-summary-wizard" id="language-box">


                                            <div class="content-summary ">
                                                <h3 class="title">{{trans('thankyou-registration.homepage')}}</h3>
                                                <i class="prefix fa fa-home"></i>
                                                <div class="location">
                                                    <span class="title">{{trans('thankyou-registration.homepage_text')}}</span>
                                                </div>

                                            </div>

                                        </div>
                                    </a>
 -->
                            </div>


                        </div>
                        <div class="row">
                            <div class="col col-md-16 text-center"><br>
                                <p style="padding-top:30px;display: inline;">{{trans('thankyou-registration.oppure')}}, </p><a href="/jobs" style="color:#f04d52;display: inline;">{{trans('thankyou-registration.altre_posizioni')}}</a>

                            </div>
                        </div>

                    </fieldset>

                </div>
            </div>


        </div>

    </div>

    </div>

    <style>
        .thankyou-application{
            background: white !important;
        }
        .footer,.header-menu{
            display:none !important;
        }

        .box-summary-wizard.first{
            margin-left:0px;
        }

        .box-summary-wizard {
            background: white none repeat scroll 0 0;
            border: 1px solid #e3e3e3;
            float: left;
            margin-left: 2%;
            min-height: 225px;
            padding: 10px;
            text-align: center;
            width: 32%;
        }

        .box-summary-wizard i {
            text-align: center;
            font-size: 60px;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .box-summary-wizard .title {
            margin-bottom: 10px;
        }

        .box-summary-wizard .title, .box-summary-wizard p {
            width: 100%;
            text-align: center;
        }

        .box-summary-wizard .location {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .box-summary-wizard .location i {
            display: inline;
            font-size: 16px;
            margin: 0;
        }


        a .box-summary-wizard h3,a .box-summary-wizard span{
            color:#0e001f !important;
        }

        a .box-summary-wizard i{
            color:#F04D52;
        }
        a .box-summary-wizard:hover i,a .box-summary-wizard:hover h3,a .box-summary-wizard:hover span{
            color:white !important;

        }
        a .box-summary-wizard:hover{
            background:#F04D52;
            color:white;
            -webkit-transition: background 100ms;
            -moz-transition: background 100ms;
            -ms-transition: background 100ms;
            -o-transition: background 100ms;
            transition: background 100ms;
        }

        .box-summary-wizard:first-child{
            margin-left:0px;
        }
        .tos .fullpage-wrapper,.privacy .fullpage-wrapper{
            height:20% !important;
        }

    </style>
@endsection



@section('custom-js')

        <!-- Begin INDEED conversion code -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var indeed_conversion_id = '5367084519431629';
        var indeed_conversion_label = '';
        /* ]]> */
    </script>
    <script type="text/javascript" src="//conv.indeed.com/pagead/conversion.js">
    </script>
    <noscript>
        <img height=1 width=1 border=0 src="//conv.indeed.com/pagead/conv/5367084519431629/?script=0">
    </noscript>
    <!-- End INDEED conversion code -->

@endsection



@section('page-css')

<style>
    #mobile-directions{
        font-size: 1.2em!important;
    }
    .title.domainName{
        display: none!important;
    }
</style>

@endsection