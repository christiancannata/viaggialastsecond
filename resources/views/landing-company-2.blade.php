@extends('template.landing')


@section('content')

<style>
    .col.col-md-16.block-violet-opaque {
        padding-bottom: 20px;
    }
</style>

    <div class="container-fluid" style="padding:40px;padding-top:25px;">


        <div class="row">
            <div class="col col-md-16 block-violet-opaque">
                <div class="container">
                    <div class="row">
                        <div class="col col-md-16">
                            <div class="logo">
                                <a href="/{{App::getLocale()}}/"><img src="/img/logos/logo-red.png"></a>
                            </div>

                        </div>
                        <div class="col col-md-8 col-md-offset-4">
                            <h1>
                               {{trans($route.'.title')}}
                            </h1>
                        </div>



                        <div class="col col-md-16">

                            <form action="/contact/company" method="POST" id="landing-request-info-form" class="form-landing" style="margin-bottom:0px">

                                <div class="row">
                                    <div class="col col-md-16">
                                        <input type="text" name="name" placeholder="{{trans($route.'.name')}}" required>
                                        <input type="text" name="company" placeholder="{{trans($route.'.company')}}" required>
                                        <input type="text" name="phone" placeholder="{{trans($route.'.recapito')}}" required>
                                        <button class="btn btn-red" type="submit">{{trans($route.'.contattaci')}}</button>
                                    </div>
                                </div>

                            </form>

                            <div style="color: white;" id="success-request-info" class="hide">
                                <h1>{{trans('common.success_contact_message')}}</h1>
                            </div>


                        </div>
                        <div class="col col-md-16">
                            <div class="divider">

                            </div>
                        </div>

                        <div class="col col-md-16">
                            <div class="row">
                                <div class="col col-md-4 col-md-offset-2 circle-banner">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <div class="cirle">
                                                <img src="/img/Employer Brand/DEB_LEFT.png"/>
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
                                <div class="col col-md-4 circle-banner">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <div class="cirle">
                                                <img src="/img/Employer Brand/DEB_CENTER.png"/>
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
                                <div class="col col-md-4 circle-banner">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <div class="cirle">
                                                <img src="/img/Employer Brand/DEB_RIGHT.png"/>
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
                                <p class="landing-partner" data-translate="partner_title">{{ trans($route.'.partner_title') }}</p>
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




@endsection


@section('page-scripts')
    <script type="text/javascript" src="/js/pages/are-you-company.js"></script>

    <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
    <noscript>
        <img height="1" width="1" style="display:none;" alt=""
             src="https://analytics.twitter.com/i/adsct?txn_id=nu1b3&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
        <img height="1" width="1" style="display:none;" alt=""
             src="//t.co/i/adsct?txn_id=nu1b3&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0"/>
    </noscript>
    <script>
        fbq.push(['track', '6028725383449', {'value': '0.01', 'currency': 'EUR'}]);
    </script>

@endsection