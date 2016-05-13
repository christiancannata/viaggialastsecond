@extends('template.layout')

@yield('header')



@section('content')



    <div class="container" style="position:absolute;width:100%;bottom:0;">
        <div class="banner-grey"
             style="position:absolute;bottom:0;left:0;width:100%;height:20px;background: #F2F2F4;"></div>
        <div class="row">
            <!-- BEGIN LANDING PAGE HEADER !-->

            <!-- END LANDING PAGE HEADER !-->


            <!-- BEGIN CENTRAL BLOCK !-->

            <div class="col col-md-12 col-md-offset-2">

                <div class="central-block">
                    <div class="search-block-meritocracy-logo  hidden-xs  hidden-sm">
                        <img class="header-menu-meritocracy-logo-image" src="/img/logos/red-logo.png"
                             width="38">
                    </div>

                    <div class="row search-block ">

                        <div class="col col-md-offset-1 col-md-14 search-block-header">
                            <div class="row">
                                <div class="col col-md-16">


                                    <div class="row">
                                        <div class="col col-md-10 col-xs-10">
                                            <h1 data-translate="">
                                                {{ trans($route.'.main_title') }}
                                            </h1>
                                        </div>
                                        <div class="col col-md-6 col-xs-6">
                                            <a href="/register/company" target="_blank"
                                               class="btn dark-button register-button-block-center">{!! trans('are-you-company.registrati_gratuitamente') !!}</a>
                                        </div>
                                        <div class="col col-xs-16 register-button-block-center-mobile">
                                            <a href="/register/company" target="_blank"
                                               class="btn dark-button">{!! trans('are-you-company.registrati_gratuitamente') !!}</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col col-md-16">

                                            <h3 style="padding-top: 10px;" data-translate="">
                                                {{ trans($route.'.main_subtitle') }}
                                            </h3>

                                        </div>
                                    </div>


                                    <div id="sticky-anchor"></div>
                                </div>

                                <div style="" class="col col-md-15 scopri-meritocracy">

                                    <img class="hvr-wobble-vertical" alt="" src="/img/icon_scroll.png"/>
                                    </span>
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
        <div class="container no-padded-top">
            <div class="row">
                <div class="col col-md-16">

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid jobs-container ">


        <div class="container padded" style="padding-bottom: 20px;">


            <div class="row">
                <div class="col col-md-4"><p class="red-label" data="">{{ trans($route.'.title_text_2') }}</p></div>
                <div class="col col-md-offset-2 col-md-6"><p class="grey-label"
                                                             data="">{{ trans($route.'.subtitle_text_2') }}</p></div>
            </div>


        </div>
    </div>




    <div class="container-fluid how-it-works-container no-bordered-container" id="price-tables" style="background:
    /* top, transparent red, faked with gradient */
    linear-gradient(
      rgba(17, 3, 41, 0.90),
      rgba(17, 3, 41, 0.90)
    ),
    /* bottom, image */
    url(/img/landing_page/landing_page_5.jpg);">

        <div class="container" id="how-it-works">


            <div class="row">
                <div class="col col-md-16">
                    <div class="sponsor-company" style="margin-bottom: 0px;">
                        <div class="row">
                            <div class="col col-md-16">
                                <h4 style="color:white;padding-top:0px;margin-top:0px">{{ trans($route.'.nostri_prodotti') }}</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col col-md-16">
                    <div class="banner" style="padding-bottom: 0px !important;margin-left:5%">
                        <div class="circle-banner">
                            <div class="circle">
                                1
                            </div>
                        </div>

                        <h4 data-translate="">{!! trans($route.'.box_1_title_tab_2')  !!}</h4>
                        <img src="/img/Employer Brand/B2B-LEFT.png" class="image">

                        <p data-translate="">{!! trans($route.'.banner_1_tab_2')   !!}</p>
                    </div>

                    <div class="banner" style="padding-bottom: 0px !important;background: white !important;">


                        <div class="triangle hidden-xs">

                        </div>
                        <div class="circle-banner">
                            <div class="circle">
                                2
                            </div>
                        </div>


                        <h4 data-translate="">{!! trans($route.'.box_2_title_tab_2')   !!}</h4>
                        <img src="/img/Employer Brand/B2B-CENTER.png" class="image">

                        <p data-translate="">{!! trans($route.'.banner_2_tab_2')   !!}
                        </p>

                    </div>

                    <div class="banner " style="padding-bottom: 0px !important;">
                        <div class="triangle white hidden-xs">

                        </div>

                        <div class="circle-banner">
                            <div class="circle">
                                3
                            </div>
                        </div>


                        <h4 data-translate="">{!! trans($route.'.box_3_title_tab_2') !!}</h4>
                        <img src="/img/Employer Brand/B2B-RIGHT.png" class="image">

                        <p data-translate="">{!! trans($route.'.banner_3_tab_2') !!}
                        </p>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col col-md-8 col-md-offset-4">
                    <a href="https://meritocracy.is/register/company" target="_blank"
                       class="btn btn-red contact registration-button"
                       style="width:97%;margin-top:30px;margin-bottom:30px">{{ trans('are-you-company.registrati_gratuitamente') }}</a>
                </div>
            </div>


        </div>
    </div>



    <div class="container-fluid testimonials-container data-price digital-head-hunting-price hide">
        <div class="container">


            <div class="row price-container">
                <div class="col col-md-16">


                    <div class="row">
                        <div class="col col-md-16">
                            <div class="row price-banner">
                                <div class="col col-md-4 text-center text-uppercase vertical-center">
                                    <div class="row">

                                        <div class="col col-md-16">
                                            <div class="col col-md-16">
                                                <p class="red-label detail-price">{!! trans($route.'.intro_text_branding_page') !!}</p>
                                            </div>
                                            <h3 class="price"
                                                style="text-transform: none">{!! trans($route.'.title_pricing_box_digital_head_hunting') !!}</h3>

                                            <a style="margin-top: 30px;" target="_blank" href="/register/company"
                                               class="btn btn-red btn-big  margin-top-20"
                                               data-translate="try_now_button">{!! trans($route.'.registrati_gratuitamente') !!}</a>
                                        </div>


                                    </div>

                                </div>
                                <div class="col col-md-offset-2 col-md-9">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <p class="title" data-translate="">
                                                {!! trans($route.'.feature') !!}
                                            </p>

                                            <p data-translate="">
                                                {!! trans($route.'.pricing_description_head_hunting') !!}
                                            </p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row price-container">
                <div class="col col-md-16">
                    <div class="row">
                        <div class="col col-md-16">
                            <h3 data-translate="">{{ trans($route.'.pricing_title') }}</h3>
                        </div>
                    </div>

                    <div class="row hide">
                        <div class="col col-md-16">
                            <div class="row price-banner">
                                <div class="col col-md-4 text-center text-uppercase">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <p class="red-label detail-price">{!! trans($route.'.intro_text') !!}</p>
                                        </div>
                                        <div class="col col-md-16">

                                            <h3 class="price ">{!! trans($route.'.valuta') . trans($route.'.title_pricing_box') !!}</h3>
                                            <h4 style="text-transform: none; color: white; ">{{ trans($route. '.hiring_campaign') }}</h4>
                                        </div>
                                        <div class="col col-md-16">
                                            <p class="price-description"
                                               style="text-transform:none !important; margin-top: 10px; font-size: 12px;">{!! trans($route.'.detail_price') !!}</p>
                                        </div>
                                        <div class="col col-md-16">
                                            <button class="btn btn-red btn-big contact-us-company"
                                                    data-translate="try_now_button">{!! trans('buttons.contact_us') !!}</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col col-md-offset-2 col-md-9">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <p class="title" data-translate="">
                                                {!! trans($route.'.feature') !!}
                                            </p>

                                            <p data-translate="">
                                                {!! trans($route.'.pricing_description') !!}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row price-container">
                <div class="col col-md-16">

                    <div class="row">
                        <div class="col col-md-16">
                            <div class="row price-banner">
                                <div class="col col-md-offset-2 col-md-12 vertical-center">
                                    <div class="row">
                                        <div class="text-center">
                                            <p class="title" data-translate="">
                                                Add-Ons
                                            </p>

                                            <p data-translate="">
                                                {!! trans($route.'.addons_description') !!}
                                            </p>

                                            <button style="width: 35%!important;"
                                                    class="btn btn-red btn-big contact-us-company"
                                                    data-translate="try_now_button">{!! trans('buttons.contact_us') !!}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>





    <div class="container-fluid" id="kpi">
        <div class="row">
            <div class="col col-md-4 col-lg-4 text-center col-md-offset-1">
                <h2>{!! trans($route.'.price_1_big') !!}</h2>
                <p><strong>{!! trans($route.'.price_1_text') !!}</strong></p>
            </div>
            <div class="col col-md-4 col-lg-4 text-center col-md-offset-1">
                <h2>{!! trans($route.'.price_2_big') !!}</h2>
                <p><strong>{!! trans($route.'.price_2_text') !!}</strong></p>
            </div>
            <div class="col col-md-4 col-lg-4 text-center col-md-offset-1">
                <p><strong>{!! trans($route.'.price_3_small') !!}</strong></p>
                <h2>{!! trans($route.'.price_3_big') !!}</h2>
                <p><strong>{!! trans($route.'.price_3_text') !!}</strong></p>
            </div>


        </div>
    </div>


    <div class="container-fluid  grey-banner" id="testimonials">
        <div class="row">
            <div style="margin-bottom: 60px;" class="col col-xs-16 col-sm-16 col-md-4 col-lg-4 col-md-offset-2">
                <div class="row box-testimonial">
                    <div class="col col-md-3 col-xs-3 col-sm-3">
                        <img src="/img/montanari_groupm.jpg" class="avatar">
                    </div>
                    <div class="col col-md-13 col-xs-13 col-sm-13">
                        <p class="name">{{trans('are-you-company.testimonial_1_name')}}</p>
                        <p class="role">{!! trans('are-you-company.testimonial_1_role') !!}</p>
                    </div>
                    <div class="col col-md-16 col-xs-16 col-sm-16">
                        <p class="text">"{{trans('are-you-company.testimonial_1_text')}}"</p>
                    </div>
                </div>
            </div>
            <div class="col col-xs-16 col-sm-16 col-md-4 col-lg-4 ">
                <div class="row box-testimonial">
                    <div class="col col-md-3 col-xs-3 col-sm-3">
                        <img src="/img/hood_wooga.jpg" class="avatar">
                    </div>
                    <div class="col col-md-13 col-xs-13 col-sm-13">
                        <p class="name">{{trans('are-you-company.testimonial_2_name')}}</p>
                        <p class="role">{!!trans('are-you-company.testimonial_2_role')!!}</p>
                    </div>
                    <div class="col col-md-16 col-xs-16 col-sm-16">
                        <p class="text">"{{trans('are-you-company.testimonial_2_text')}}"</p>
                    </div>
                </div>
            </div>
            <div class="col col-md-4 col-lg-4 col-md-offset-1 ">
                <div class="row box-testimonial">
                    <div class="col col-md-3">
                        <img src="/img/parma_aon.jpg" class="avatar">
                    </div>
                    <div class="col col-md-13">
                        <p class="name">{{trans('are-you-company.testimonial_3_name')}}</p>
                        <p class="role">{!!trans('are-you-company.testimonial_3_role')!!}</p>
                    </div>
                    <div class="col col-md-16">
                        <p class="text">"{{trans('are-you-company.testimonial_3_text')}}"</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-14 col-md-offset-1">
                    <div style="border-bottom: 1px solid black;margin-top:20px;
    height: 16px;
    text-align: center;
    width: 100%;">
                    <span style="background-color: #e5e5e5; padding: 0px 10px; font-size: 20px; ">
                        {{ trans('common.partner_title_are_you_company') }} <!--Padding is optional-->
                    </span>
                    </div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="row grey-banner sponsor-company" style="margin-top:20px;margin-bottom:0px">


                <div class="col col-md-2 col-xs-5 col-sm-4  ">
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
                    <img src="/img/loghi_aziende/ticket-blu-1.png">
                </div>
                <div class="col col-md-2 col-xs-5 col-sm-4">
                    <img src="/img/loghi_aziende/tetra-blu.png">
                </div>
                <div class="col col-md-2 col-xs-5 col-sm-4">
                    <img src="/img/loghi_aziende/voda-blu.png">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid  " id="pricing">
        <div class="row ">
            <div class="col col-md-16">
                <div class="sponsor-company">
                    <div class="row">
                        <div class="col col-md-16">
                            <h4 data-translate="partner_title"
                                style="padding-bottom:20px">{{trans($route.".title_our_plans")}}</h4>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col col-md-3 col-md-offset-3 banner-price banner-price-red">
                            <div class="row">
                                <div class="col col-md-16 title">
                                    {{trans($route.".box_1_price_title")}}
                                </div>
                                <div class="col col-md-16 subtitle">
                                    <br>{{trans($route.".box_1_price_subtitle")}}
                                </div>
                                <div class="col col-md-16 price white-text">
                                    {{trans($route.".box_1_price_price")}}

                                </div>
                                <div class="col col-md-16 description_price">
                                    {{trans($route.".box_1_price_subtitle_price")}}

                                </div>
                                <div class="col col-md-16 ">
                                    <div class="divider"></div>
                                </div>
                                <div class="col col-md-16 title_description">
                                    {{trans($route.".box_1_price_title_description")}}

                                </div>
                                <div class="col col-md-16 description">
                                    {!! trans($route.".box_1_price_description")!!}
                                </div>
                                <div class="col col-md-16 price-button hidden-xs">
                                    <a href="/register/company">
                                        <button class="btn btn-large dark-button">
                                            {{trans($route.".box_1_price_button")}}
                                        </button>
                                    </a>
                                </div>
                                <div class="col col-md-16 hidden-sm hidden-md hidden-lg">
                                    <a href="/register/company">
                                        <button class="btn btn-large dark-button">
                                            {{trans($route.".box_1_price_button")}}
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-3 banner-price ">
                            <div class="row">
                                <div class="col col-md-16 title">
                                    {{trans($route.".box_2_price_title")}}
                                </div>
                                <div class="col col-md-16 subtitle">
                                    {{trans($route.".box_2_price_subtitle")}}
                                </div>
                                <div class="col col-md-16 price white-text">
                                    {!!trans($route.".box_2_price_price")!!}

                                </div>
                                <div class="col col-md-16 description_price">
                                    {{trans($route.".box_2_price_subtitle_price")}}

                                </div>
                                <div class="col col-md-16 ">
                                    <div class="divider"></div>
                                </div>
                                <div class="col col-md-16 title_description">
                                    {{trans($route.".box_2_price_title_description")}}

                                </div>
                                <div class="col col-md-16 description">
                                    {!! trans($route.".box_2_price_description")!!}
                                </div>
                                <div class="col col-md-16 price-button hidden-xs">
                                    <a href="/register/company">
                                        <button class="btn btn-large dark-button">
                                            {{trans($route.".box_2_price_button")}}
                                        </button>
                                    </a>
                                </div>

                                <div class="col col-md-16 hidden-sm hidden-md hidden-lg">
                                    <a href="/register/company">
                                        <button class="btn btn-large dark-button">
                                            {{trans($route.".box_2_price_button")}}
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col col-md-4 banner-price " style="border-left:0px !important;">
                            <img src="/img/best-choice_badge.png" style="position: absolute;
    right: 10px;
    top: 0;
    width: 100px;">
                            <div class="row">
                                <div class="col col-md-16 title">
                                    {{trans($route.".box_3_price_title")}}
                                </div>
                                <div class="col col-md-16 subtitle">
                                    {{trans($route.".box_3_price_subtitle")}}
                                </div>
                                <div class="col col-md-16 price white-text">
                                    {!! trans($route.".box_3_price_price") !!}

                                </div>
                                <div class="col col-md-16 description_price">
                                    {{trans($route.".box_3_price_subtitle_price")}}

                                </div>
                                <div class="col col-md-16 ">
                                    <div class="divider"></div>
                                </div>
                                <div class="col col-md-16 title_description">
                                    {{trans($route.".box_3_price_title_description")}}

                                </div>
                                <div class="col col-md-16 description">
                                    {!!  trans($route.".box_3_price_description")!!}
                                </div>
                                <div class="col col-md-16 price-button hidden-xs">
                                    <button class="btn btn-large dark-button contact-us-company-contact">
                                        {{trans($route.".box_3_price_button")}}
                                    </button>
                                </div>
                                <div class="col col-md-16 hidden-sm hidden-md hidden-lg">
                                    <button class="btn btn-large dark-button contact-us-company-contact">
                                        {{trans($route.".box_3_price_button")}}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col col-md-4 col-md-offset-9" style="margin-top:20px">
                            <div class="row">
                                <div class="col col-md-16 text-center">
                                    <p style="font-size:13px"> {{trans($route.".pricing_number")}} </p>
                                </div>
                                <div class="col col-md-16">
                                    <button class="btn btn-large button-light-blue hide" style="padding-left: 23px;
    padding-right: 18px;">
                                        {{trans($route.".pricing_sub_button")}}
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>


        <div class="row sponsor-company "
             style="background: #e5e5e5 none repeat scroll 0 0;padding-bottom:30px;margin-bottom:0px" id="faq">
            <div class="col col-md-16">
                <div class="row">
                    <div class="col col-md-16">
                        <h4 data-translate="partner_title">{{trans($route.".Faq_section_title")}}</h4>
                    </div>
                </div>

                <div class="row" style="margin-top:30px">
                    <div class="col col-md-6 col-md-offset-2">

                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_1_title')}}</h4>
                                <p>{{trans($route.'.faq_1_text')}}</p>
                            </div>
                        </div>
                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_2_title')}}</h4>
                                <p>{{trans($route.'.faq_2_text')}}</p>
                            </div>
                        </div>
                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_3_title')}}</h4>
                                <p>{{trans($route.'.faq_3_text')}}</p>
                            </div>
                        </div>

                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_7_title')}}</h4>
                                <p>{{trans($route.'.faq_7_text')}}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col col-md-6">
                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_4_title')}}</h4>
                                <p>{{trans($route.'.faq_4_text')}}</p>
                            </div>
                        </div>
                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_5_title')}}</h4>
                                <p>{{trans($route.'.faq_5_text')}}</p>
                            </div>
                        </div>
                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_6_title')}}</h4>
                                <p>{{trans($route.'.faq_6_text')}}</p>
                            </div>
                        </div>
                        <div class="row faq">
                            <div class="col col-md-2">
                                <div class="circle red">
                                    +
                                </div>
                            </div>
                            <div class="col col-md-14">
                                <h4>{{trans($route.'.faq_8_title')}}</h4>
                                <p>{{trans($route.'.faq_8_text')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col col-md-6 col-md-offset-2 ">


                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-scripts')
    <script type="text/javascript" src="/js/pages/are-you-company.js"></script>
    <script>CompanyPage.init();
   </script>


    <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>


    <!-- Google Code per il tag di remarketing -->
    <!--------------------------------------------------
    I tag di remarketing possono non essere associati a informazioni di identificazione personale o inseriti in pagine relative a categorie sensibili. Ulteriori informazioni e istruzioni su come impostare il tag sono disponibili alla pagina: http://google.com/ads/remarketingsetup
    --------------------------------------------------->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 935998541;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/935998541/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>

@endsection