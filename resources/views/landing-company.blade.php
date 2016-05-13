@extends('template.landing')

<style>
    html, body {
        height: 100%;
    }

    .circle-banner .circle {
        background: white none repeat scroll 0 0;
        border-radius: 50%;
        height: 250px !important;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
        width: 250px !important;
    }

    .circle-banner .circle img{
        width:100% !important;

    }
</style>

@section('content')


    <div class=" vertical-center">
        <div class="container-fluid">


            <div class="block-violet-opaque">
                <div class="container">
                    <div class="row">
                        <div class="col col-md-16">
                            <div class="logo" style="margin-top:80px">
                                <a href="/{{App::getLocale()}}/"><img style="margin-bottom:30px" src="/img/logos/logo-red.png"></a>
                            </div>

                        </div>
                        <div class="col col-md-8 col-md-offset-4">
                            <h1 style="margin-top:0px;">
                                {{trans($route.'.title')}}
                            </h1>
                        </div>

                        <div class="col col-md-16 ">

                            <form action="/contact/company" method="POST" id="landing-request-info-form"
                                  class="form-landing hide">

                                <div class="row ">
                                    <div class="col col-md-16">
                                        <input type="text" name="name" placeholder="{{trans($route.'.name')}}" required>
                                        <input type="text" name="company" placeholder="{{trans($route.'.company')}}"
                                               required>
                                        <input type="text" name="phone" placeholder="{{trans($route.'.recapito')}}"
                                               required>
                                        <input type="hidden" name="promotional" value="1">
                                        <button class="btn btn-red" type="submit">{{trans($route.'.contattaci')}}</button>
                                    </div>
                                </div>

                            </form>
                            <div style="color: white;" id="success-request-info" class="hide">
                                <h2>{{trans($route.'.success_contact_message')}}</h2>
                            </div>
                        </div>

                        <div style="margin-top: 10px; margin-bottom: 20px;" class="col col-md-16">
                            <div class="row">
                                <div class="col col-md-4 col-md-offset-1 circle-banner">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <div class="circle">
                                                <img src="/img/Employer Brand/B2B-LEFT.png" >

                                            </div>
                                        </div>
                                        <div class="col col-md-16">
                                            <h2>{{trans($route.'.box_1_title')}}</h2>
                                        </div>
                                        <div class="col col-md-16">
                                            <h3>{{trans($route.'.box_1_subtitle')}}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-4 col-md-offset-1 circle-banner">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <div class="circle">
                                                <img src="/img/Employer Brand/B2B-CENTER.png" >
                                            </div>
                                        </div>
                                        <div class="col col-md-16">
                                            <h2>{{trans($route.'.box_2_title')}}</h2>
                                        </div>
                                        <div class="col col-md-16">
                                            <h3>{{trans($route.'.box_2_subtitle')}}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-4 col-md-offset-1 circle-banner">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <div class="circle">
                                                <img src="/img/Employer Brand/B2B-RIGHT.png" >

                                            </div>
                                        </div>
                                        <div class="col col-md-16">
                                            <h2>{{trans($route.'.box_3_title')}}</h2>
                                        </div>
                                        <div class="col col-md-16">
                                            <h3>{{trans($route.'.box_3_subtitle')}}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-16">

                                    <a href="https://meritocracy.is/register/company" style="font-size: 28px; " ><button class="btn btn-red" type="submit" style="width: 358px; height: 66px;">
                                            <?php if(App::getLocale()!="it"){ ?>
                                            Free Sign Up
                                            <?php }else{  ?>
                                            Registrati gratuitamente
                                            <?php } ?>
                                        </button></a>

                                </div>


                            </div>
                        </div>


                    </div>

                </div>


                <div class="col col-md-16 background-red">
                    <div class="container">
                        <div class="sponsor-company">
                            <div class="row">
                                <div class="col col-md-16">
                                    <p class="landing-partner"
                                       data-translate="partner_title">{{ trans($route.'.partner_title') }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-md-2 col-xs-5 col-sm-4 col-md-offset-1 ">
                                    <img src="/img/loghi_aziende/aon-blu.png">
                                </div>
                                <div class="col col-md-2 col-xs-5 col-sm-4">
                                    <img src="/img/loghi_aziende/cloetta-blu.png">
                                </div>
                                <div class="col col-md-2 col-xs-5 col-sm-4">
                                    <img src="/img/loghi_aziende/decha-blu.png">
                                </div>
                                <div class="col col-md-2 col-xs-5 col-sm-4">
                                    <img src="/img/loghi_aziende/groupm-blu.png">
                                </div>
                                <div class="col col-md-2 col-xs-5 col-sm-4">
                                    <img src="/img/loghi_aziende/samsung-blu.png">
                                </div>
                                <div class="col col-md-2 col-xs-5 col-sm-4">
                                    <img src="/img/loghi_aziende/tesla-blu.png">
                                </div>
                                <div class="col col-md-2 col-xs-5 col-sm-4">
                                    <img src="/img/loghi_aziende/tetra-blu.png">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>




    @endsection


    @section('page-scripts')


            <!-- Google Code per il tag di remarketing -->
    <!--------------------------------------------------
    I tag di remarketing possono non essere associati a informazioni di identificazione personale o inseriti in pagine relative a categorie sensibili. Ulteriori informazioni e istruzioni su come impostare il tag sono disponibili alla pagina: http://google.com/ads/remarketingsetup
    --------------------------------------------------->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 934867588;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/934867588/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>

    <script>
        fbq.push(['track', '6029407180249', {'value': '0.01', 'currency': 'EUR'}]);
    </script>
    <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>


@endsection