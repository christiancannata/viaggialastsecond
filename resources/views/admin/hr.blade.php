@extends('template.admin_layout')

@yield('header')

@section('page-css')
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">


<link href="/admin/js/plugins/xcharts/xcharts.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<link href="/admin/js/plugins/jsgrid/css/jsgrid.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/jsgrid/css/jsgrid-theme.min.css" type="text/css" rel="stylesheet"
      media="screen,projection">

@endsection

@section('breadcrumbs')

        <!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <!-- Search for small screen -->
    <div class="header-search-wrapper grey hide">
        <i class="mdi-action-search active"></i>
        <input type="text" name="Search" class="header-search-input z-depth-2"
               placeholder="Search for candidates">
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Welcome to your HR Dashboard</h5>
                <ol class="breadcrumbs">
                    <li><a href="/hr">Dashboard</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

    <input type="hidden" id="company-videos" value="{{json_encode($videos)}}">
    <div class="section">

        <!--card stats start-->
        <div id="card-stats ">
            <div class="row">
                @if(Auth::user()->type=="ANALYTICS")
                    <div class="col s12 m6 l6">

                        <div id="morris-line-chart" class="section">
                            <h4 class="header">Last Month visitors</h4>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="row">
                                        <div class="col s2 m3 l3">
                                            <input name="visit_type" value="P8D" type="radio" id="test1" checked/>
                                            <label style="padding-left: 24px;" for="test1">Last Week</label>
                                        </div>
                                        <div class="col s2 m3 l3">
                                            <input name="visit_type" value="P15D" type="radio" id="2_weeks"/>
                                            <label style="padding-left: 24px;" for="2_weeks">Last 2 Weeks</label>
                                        </div>
                                        <div class="col s2 m3 l3">
                                            <input name="visit_type" value="P31D" type="radio" id="month"/>
                                            <label style="padding-left: 24px;" for="month">Last Month</label>
                                        </div>
                                        <div class="col s2 m3 l3">
                                            <input name="visit_type" value="P91D" type="radio" id="3_month"/>
                                            <label style="padding-left: 24px;" for="3_month">Last 3 Months</label>
                                        </div>
                                        <div class="col s4 m4 l4">
                                            <select name="group" id="group">
                                                <option value="day">Day</option>
                                                <option value="week">Week</option>
                                                <option value="month">Month</option>
                                            </select>
                                            <label style="padding-left: 24px;" for="group">Group Data By</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col s12 m12 l12">
                                    <div class="sample-chart-wrapper">
                                        <div id="morris-line" class="graph"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col s6 m6 l6">

                        <div id="morris-line-chart" class="section">
                            <h4 class="header">TOP Referral Applications</h4>
                            <div class="row">
                                <div class="col s6 m6 l6">
                                    <canvas id="doughnut-chart-sample"></canvas>
                                </div>
                                <div class="col s4 m4 l4">
                                    <div id="doughnut-chart-sample-legend"></div>
                                </div>
                            </div>
                        </div>
                        <div id="morris-bar-chart" class="section">
                            <h4 class="header">TOP Quality Referral</h4>
                            <div class="row">
                                <div class="col s12 m8 l9">
                                    <div class="sample-chart-wrapper">
                                        <div id="jsGrid-basic"></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col s12 m6 l3">
                        <div class="card component-statistic disabled" data-type="application" data-type-group="company"
                             data-id="{{$user->company["id"]}}">
                            <div class="card-content red white-text text-center">
                                <p class="card-stats-title  center">Applications
                                </p>
                                <h4 class="card-stats-number value-a text-center center"></h4>

                            </div>
                            <div class="card-action red darken-2">
                                <div id="sales-compositebar" class="center-align white-text"><i
                                            class="mdi-hardware-keyboard-arrow-up"></i> <span class="difference"></span>
                                    <span class="purple-text text-lighten-5 white-text">last month</span></div>
                            </div>
                        </div>
                    </div>


                    <div class="col s12 m6 l6 hide">
                        <div class="card">
                            <div class="card-content  red white-text">
                                <p class="card-stats-title"><i class="mdi-social-group-add"></i> Applications</p>
                                <h4 class="card-stats-number">566</h4>
                                <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> 15
                                    <span class="green-text text-lighten-5">from yesterday</span>
                                </p>
                            </div>
                            <div class="card-action  red darken-2">
                                <div id="clients-bar" class="center-align"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6 hide">
                        <div class="card">
                            <div class="card-content red lighten-1 white-text">
                                <p class="card-stats-title"><i class="mdi-social-people"></i> Visitors</p>
                                <h4 class="card-stats-number">1806</h4>
                                <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-down"></i>
                                    3% <span class="deep-purple-text text-lighten-5">from last month</span>
                                </p>
                            </div>
                            <div class="card-action  red darken-2">
                                <div id="invoice-line" class="center-align"></div>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>

        <div class="divider"></div>
        <div style="height: 10px;" class="clearfix"></div>


        <div data-count="" data-other="" id="vacancies">
            @if(!$user->company['is_complete'] || (isset($company['sliders']) && count($company['sliders']) < 3))
                <div class="clearfix"></div>
                <div class="card animated fadeInUp uncompleted-adv red">
                    <div class="card-content">
                        <div class="card-title activator white-text  bold">
                            <i class="mdi-alert-error"></i>
                            <span>Your Branding Page is not completed</span>
                        </div>

                        <div class="card-description">

                                    <span class="white-text">
                                        To open your first job and empower your brand, please add company's information to your Branding Page.</span>
                        </div>


                    </div>
                    <div class="card-action">
                        <a class="btn waves waves-light waves-effect black"
                           onclick="location.href='/hr/company-page'">

                            @if(!isset($_COOKIE['first_view_message_hr']))
                                <?php
                                setcookie("first_view_message_hr", "1", time() + 360000);  /* expire in 1 hour */
                                ?>
                                Start completing your company page
                            @else
                                Complete your Branding Page
                            @endif

                        </a>


                    </div>

                </div>

            @elseif(isset($company['sliders']) && count($company['sliders']) < 3)
                <div class="card animated fadeInUp uncompleted-adv">
                    <div class="card-content">
                        <div class="card-title activator  bold">
                            <i class="mdi-action-info-outline"></i>
                            <span>Branding page almost completed</span>
                        </div>

                        <div class="card-description">

                                    <span  class="">
                                        Please upload a minimum of 3 photos of your
                        company's workspaces and your team</span>
                        </div>


                    </div>
                    <div class="card-action">
                        <a class="btn waves waves-light waves-effect red"
                           onclick="location.href='/hr/photogallery'">
                            Upload company's workspace photo
                        </a>


                    </div>

                </div>

                @endif
            <div class="card animated fadeInUp no-vacancies " style="display:none">
                <div class="card-content">
                    <div class="card-title activator grey-text text-darken-4 bold">
                        <span>No vacancies created</span>
                    </div>

                    <div class="card-description">
                        <span class="grey-text">You have no open position for your company: open your first vacancy to receive candidates.</span>
                    </div>


                </div>
                <div class="card-action">
                    <a href="#modal-new-vacancy" class="btn waves waves-light waves-effect red modal-trigger"
                       lang="en" target="_blank">Open your first vacancy</a>


                </div>

            </div>
            <div class="col s12 m8 l9 vacancies-container">

                <div style="margin-top: 50px; margin-bottom: 50px;"
                     class="col s12 m12 l12 center form-loader">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-red-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div style="display: none;" class="card no-positions animated fadeInUp">
                    <div class="card-content">
                        <div class="card-title activator grey-text text-darken-4 bold">
                            <span>No vacancies recently opened</span>
                        </div>

                        <div class="card-description">
                            <span class="grey-text">You have no open position for your company: open a new vacancy to receive candidates.</span>
                        </div>


                    </div>
                    <div class="card-action">
                        <a href="#modal-new-vacancy" class="btn waves waves-light waves-effect red modal-trigger"
                           lang="en" target="_blank">Open a vacancy</a>


                    </div>

                </div>
            </div>
        </div>


        <!-- Compose Email Structure -->
        <div id="modal-new-vacancy" class="modal std-modal" style="width:80%">
            <div class="modal-content">
                <nav class="red color-result darken-1">
                    <div class="nav-wrapper">
                        <div class="left col s12 m5 l5">
                            <ul>

                                <li><a lang="en" href="#!" class="email-type" style="font-size:1.4rem">Add a new
                                        vacancy</a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </nav>
            </div>
            <div class="model-email-content color-result">
                <div class="row">


                    <form id="new-vacancy" class="col s12" method="POST" action="">

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="col s12 m12 l12 center form-loader">
                            <div class="preloader-wrapper big active">
                                <div class="spinner-layer spinner-red-only">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="gap-patch">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-content">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input name="vacancyAddName" id="vacancyAddName" type="text" class="validate">
                                    <label lang="en" for="vacancyAddName" data-error="This field is required"
                                           data-success="Ok">Title<span class="label-required">*</span></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                <textarea name="vacancyAddDescription" id="vacancyAddDescription"
                                          length="9000" required></textarea>
                                    <label lang="en" for="vacancyAddDescription " data-error="This field is required"
                                           data-success="Ok">Description<span class="label-required">*</span></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="vacancyAddJobFunction" name="vacancyAddJobFunction"
                                            class="select2-jobFunctions" required>
                                        <option value="" disabled selected>Choose your option</option>
                                    </select>
                                    <label for="vacancyAddJobFunction" lang="en" data-error="This field is required"
                                           data-success="Ok">Job Function<span class="label-required">*</span></label>

                                </div>
                                <div class="input-field col s6">

                                    <select id="vacancyAddStudyField" name="vacancyAddStudyField"
                                            class="select2-studyFields" required>
                                        <option value="" disabled selected>Choose your option</option>

                                    </select>
                                    <label lang="en" data-error="This field is required" data-success="Ok">Preferred
                                        Study Field<span class="label-required">*</span></label>
                                </div>
                            </div>


                            <div class="row">

                                <div class="input-field col s6">
                                    <select id="vacancyAddIndustry" name="vacancyAddIndustry" required>
                                        <option value="" disabled selected>Choose your option</option>
                                        @foreach($industries as $industry)
                                            <option @if($industry["id"] === $companyIndustry) selected
                                                    @endif value="{{$industry['id']}}">{{$industry['name']}}</option>
                                        @endforeach
                                    </select>
                                    <label lang="en" data-error="This field is required" data-success="Ok">Industry<span
                                                class="label-required">*</span></label>

                                </div>

                                <div class="input-field col s6">
                                    <select id="vacancyAddSeniority" name="vacancyAddSeniority" required class="">
                                        <option value="" disabled selected>Choose your option</option>
                                        <option lang="en" value="INTERN_STAGE">Intern / Stage</option>
                                        <option lang="en" value="JUNIOR">Junior</option>
                                        <option lang="en" value="MIDDLE">Middle</option>
                                        <option lang="en" value="SENIOR">Senior</option>
                                    </select>
                                    <label lang="en" data-error="This field is required"
                                           data-success="Ok">Seniority<span class="label-required">*</span></label>

                                </div>

                            </div>

                            <div class="row">

                                <div class="input-field col s12">
                                    <select multiple id="vacancyAddLanguages" required name="vacancyAddLanguages"
                                            class="select2-languages">
                                        <option value="" disabled selected>Choose your options</option>


                                        @foreach($languages as $language)
                                            <option @if( isset($language['id']) && $language["id"] === $companyLanguage) selected
                                                    @endif value="{{$language['id']}}">{{$language['name']}}</option>
                                        @endforeach

                                    </select>
                                    <label lang="en" data-error="This field is required" data-success="Ok">Required
                                        Languages<span class="label-required">*</span></label>

                                </div>

                            </div>


                            @if(!empty($videos))
                                <div class="row">

                                    <div class="input-field col s12">

                                        <select multiple id="vacancyAddVideo" required name="video[id]"
                                                class="select2-video">
                                            <option value="" disabled selected>Choose your video</option>

                                            @foreach($videos as $video)
                                                <option value="{{$video['id']}}">{{$video['name']}}</option>
                                            @endforeach

                                        </select>
                                        <label lang="en">Vacancy Video</label>

                                    </div>

                                </div>
                            @endif


                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="hidden" name="city[id]" class="address_city_id"
                                           value="@if(isset($company['city']['id'])){{$company['city']['id']}}@endif"
                                           id="work_city_id">
                                    <input id="luogo_lavoro" name="city_plain_text" type="text"
                                           class="required validate"
                                           value="@if(isset($company['city'])){{$company['city_plain_text']}}@endif"
                                           required>
                                    <label for="luogo_lavoro" data-error="This field is required"
                                           data-success="Ok">{{ trans('company-page.citta') }}<span
                                                class="label-required">*</span></label>
                                </div>
                            </div>

                            @if(Auth::user()->type=="COMPANY")
                                <?php
                                $now = new \DateTime();
                                ?>
                                <input
                                        name="vacancyAddDate"
                                        id="vacancyAddDate" type="hidden"
                                        value="<?php echo $now->format("Y-m-d H:i") ?>">
                            @else
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <input class="datepicker"
                                               name="vacancyAddDate"
                                               id="vacancyAddDate" type="text">
                                        <label lang="en" for="vacancyAddDate" data-error="This field is required"
                                               data-success="Ok">Opening date<span
                                                    class="label-required">*</span></label>

                                    </div>
                                </div>
                            @endif


                            <div class="row">
                                <div class="col s12 m8 l9">
                                    <h5 style="font-size: 1.30rem;" class="title">{{trans('hr.sponsored_title')}}<span
                                                class="label-required">*</span></h5>
                                    <p>
                                        <input name="sponsored_yes" type="radio" id="sponsored_yes" value="on"/>
                                        <label for="sponsored_yes"
                                               style="font-size: 1.3rem;">{!! trans('hr.sponsored_yes_title') !!}<br>
                                            <span style="font-size:0.8rem"> {{trans('hr.sponsored_yes_text')}}</span>
                                        </label>
                                    </p>
                                    <p>
                                        <input name="sponsored_yes" type="radio" id="sponsored_no" value="off"/>
                                        <label for="sponsored_no"
                                               style="font-size: 1.3rem;">{{trans('hr.sponsored_no_title')}}<br>
                                            <span style="font-size:0.8rem"> {{trans('hr.sponsored_no_text')}}</span></label>
                                    </p>

                                </div>
                            </div>

                            <div class="row promotional-code" style="display:none;">
                                <div class="input-field col s12 " style="margin-top: 30px;margin-bottom: 20px">
                                    <input name="codiceScontoId" id="codiceScontoId" type="hidden">
                                    <input name="codiceSconto" id="codiceSconto" type="text" class="validate">
                                    <label lang="en" for="codiceSconto">Promotional code</label>
                                </div>
                            </div>

                            <div class="input-field col s12 ">
                                <button lang="en" class="btn waves-effect waves-light right red submit btn-add-vacancy"
                                        type="submit"
                                >Add vacancy<i class="mdi-content-add right"></i>
                                </button>
                            </div>

                        </div>

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Vacancy created
                                </h4>
                                <h6 lang="en">The vacancy has been created succesfully.<br></h6>
                                <form id="paypalForm" method="post" action="/checkout/paypal"></form>
                            </div>
                            <div class="button-action">
                                <button type="button" data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light green darken-2 btn form-recreate-modal">Add
                                    another
                                </button>
                                <button type="button" lang="en"
                                        class="waves-effect waves-light green darken-2 btn modal-close">
                                    Close
                                </button>
                            </div>

                        </div>


                        <div style="display: none; margin-bottom: 50px;"
                             class="center form-confirm-paypal animated fadeIn">
                            <div class="black-text">
                                <h6 lang="en">
                                    Hi {{Auth::user()->first_name or ""}} {{Auth::user()->last_name or ""}}, please
                                    complete your purchase. You will sponsor the following job:<br><br>
                                </h6>

                                <div style="text-align:left;" class="card animated fadeIn col m6 offset-m3">
                                    <div class="card-content">

                                        <div class="card-title activator grey-text text-darken-4 bold">
                                            <strong id="paypal_name"></strong>
                                            <ul style="display: inline-block; margin-left: 5px;" class="card-subtitle">
                                                <li>
                                                    <div class="chip2 light-grey grey-text"><span
                                                                id="paypal_seniority"></span></div>
                                                </li>
                                            </ul>
                                        </div>


                                        <div style="max-height: 160px;!important; -webkit-line-clamp: 9!important;"
                                             class="card-description">

                                            <span class="grey-text truncate-text">Vacancy description:</span> <strong
                                                    id="paypal_description"></strong><br>
                                            <span class="grey-text truncate-text">Sponsorship Price:</span> € <strong
                                                    id="paypal_subtotal">{{$subtotal}}</strong><br>
                                            <span class="grey-text truncate-text">VAT:</span> <strong
                                                    id="paypal_vat">{{$vat}}</strong>%<br>
                                            <span class="grey-text truncate-text">Total:</span> € <strong
                                                    id="paypal_total">{{$total}}</strong>
                                        </div>


                                    </div>
                                    <div class="card-action">
                                        <a type="button" data-form="new-vacancy" lang="en"
                                           class="waves-effect waves-light green darken-2 btn form-do-paypal">Confirm
                                            and purchase</a>
                                        <a type="button" lang="en"
                                           class="btn waves waves-light waves-effect grey modal-trigger modal-close">
                                            Cancel
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-error animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to add vacancy
                                </h4>
                                <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                            </div>
                            <div class="button-action">
                                <button type="button" data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit data
                                </button>
                                <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again</button>
                            </div>

                        </div>


                    </form>
                </div>
            </div>


        </div>
        <!-- Edit vacancy -->
        <div id="modal-edit-vacancy" class="modal std-modal" style="width:80%">
            <div class="modal-content">
                <nav class="red color-result darken-1">
                    <div class="nav-wrapper">
                        <div class="left col s12 m5 l5">
                            <ul>
                                <li><a lang="en" href="#!" class="vacancy-name"></a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </nav>
            </div>
            <div class="model-email-content color-result">
                <div class="row">


                    <form data-vacancy-id="" id="edit-vacancy" class="col s12" method="POST" action="">
                        <input type="hidden" name="action" id="action-edit" value="">

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="col s12 m12 l12 center form-loader">
                            <div class="preloader-wrapper big active">
                                <div class="spinner-layer spinner-red-only">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="gap-patch">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Vacancy updated
                                </h4>
                                <h6 lang="en">The vacancy has been update succesfully.</h6>
                            </div>
                            <div class="button-action">

                                <button lang="en" class="waves-effect waves-light green darken-2 btn modal-close">
                                    Close
                                </button>
                            </div>

                        </div>


                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-clone animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Vacancy added
                                </h4>
                                <h6 lang="en">The vacancy has been cloned succesfully.</h6>
                            </div>
                            <div class="button-action">

                                <button lang="en" class="waves-effect waves-light green darken-2 btn modal-close">
                                    Close
                                </button>
                            </div>

                        </div>

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-error-clone animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to clone
                                    vacancy
                                </h4>
                                <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                            </div>
                            <div class="button-action">
                                <button data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit data
                                </button>
                                <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again</button>
                            </div>

                        </div>
                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-error animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to edit
                                    vacancy
                                </h4>
                                <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                            </div>
                            <div class="button-action">
                                <button data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit data
                                </button>
                                <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again</button>
                            </div>

                        </div>


                        <div class="form-content">

                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="iOs Developer" name="vacancyEditName" id="vacancyEditName"
                                           type="text" class="validate">
                                    <label lang="en" for="vacancyEditName">Name<span
                                                class="label-required">*</span></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12">
                                <textarea
                                        name="vacancyEditDescription" id="vacancyEditDescription"
                                ></textarea>
                                    <label lang="en" for="vacancyEditDescription">Description<span
                                                class="label-required">*</span></label>
                                </div>
                            </div>


                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="vacancyEditJobFunction" name="vacancyEditJobFunction"
                                            class="select2-jobFunctions" required>
                                        <option value="" disabled selected>Choose your option</option>
                                    </select>
                                    <label for="vacancyEditJobFunction" lang="en">Job Function<span
                                                class="label-required">*</span></label>

                                </div>
                                <div class="input-field col s6">

                                    <select id="vacancyEditStudyField" name="vacancyEditStudyField"
                                            class="select2-studyFields" required>
                                        <option value="" disabled selected>Choose your option</option>

                                    </select>
                                    <label lang="en">Study Field<span class="label-required">*</span></label>
                                </div>
                            </div>


                            <div class="row">

                                <div class="input-field col s6">
                                    <select id="vacancyEditIndustry" name="vacancyEditIndustry"
                                            class="select2-industries" required>
                                        <option value="" disabled selected>Choose your option</option>
                                    </select>
                                    <label lang="en">Industry<span class="label-required">*</span></label>

                                </div>

                                <div class="input-field col s6">
                                    <select id="vacancyEditSeniority" name="vacancyEditSeniority" required class="">
                                        <option value="" disabled selected>Choose your option</option>
                                        <option lang="en" value="INTERN_STAGE">Intern / Stage</option>
                                        <option lang="en" value="JUNIOR">Junior</option>
                                        <option lang="en" value="MIDDLE">Middle</option>
                                        <option lang="en" value="SENIOR">Senior</option>
                                    </select>
                                    <label lang="en">Seniority<span class="label-required">*</span></label>

                                </div>

                            </div>


                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <input type="hidden" name="city[id]" class="address_city_id"
                                           value="" id="work_city_id_1">
                                    <input id="luogo_lavoro_1" name="city_plain_text" type="text"
                                           class="required validate address_city" value="" required>
                                    <label class="active" for="luogo_lavoro_1">{{ trans('company-page.citta') }}</label>
                                </div>

                                @if(!empty($videos))
                                    <div class="input-field col s12 m12">
                                        <select id="vacancyEditVideo" name="video[id]"
                                                class="select2-videos">
                                            <option value="" disabled selected>Choose your video</option>
                                        </select>
                                        <label lang="en">Video</label>

                                    </div>
                                @endif
                            </div>


                            @if(Auth::user()->type=="COMPANY")
                                <input
                                        name="vacancyEditDate"
                                        id="vacancyEditDate" type="hidden" value="">
                            @else
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <input class="datepicker"
                                               name="vacancyEditDate"
                                               id="vacancyEditDate" type="text">
                                        <label lang="en" for="vacancyEditDate">Opening date<span class="label-required">*</span></label>

                                    </div>
                                </div>
                            @endif


                            <div class="row">

                                <div class="input-field col s12">
                                    <select multiple id="vacancyEditLanguages" required name="vacancyEditLanguages[]"
                                    >
                                        <option value="" disabled selected>Choose your options</option>
                                        @foreach($languages as $language)
                                            <option value="{{$language['id']}}">{{$language['name']}}</option>
                                        @endforeach
                                    </select>


                                    <label lang="en">Required Languages<span class="label-required">*</span></label>

                                </div>

                            </div>


                            <div class="input-field col s12">
                                <button lang="en"
                                        class="btn waves-effect waves-light right red submit save-edit-vacancy"
                                        type="submit"
                                >Save changes
                                </button>
                            </div>

                        </div>


                    </form>
                </div>
            </div>

        </div>


    </div>

    @if($hasCancel!=false)


            <!-- Compose Email Structure -->
    <div id="modal-checkout-cancel" class="modal std-modal" style="width:60%">
        <div class="modal-content">
            <nav class="red color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>

                            <li><a class="email-type" style="font-size:1.4rem">Payment failed.</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result red">
            <div class="row">

                <div style=" margin-top: 50px; margin-bottom: 50px;"
                     class="center form-result animated fadeIn">
                    <div class="white-text">
                        <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Payment failed.
                        </h4>
                        <h6 lang="en" style="margin-bottom: 20px">Your payment failed, no charges were made. Please try
                            again later.<br></h6>
                        <div class="col m2 offset-m3 left-align">
                            <p><strong>Vacancy:</strong></p>

                        </div>
                        <div class="col m6 left-align">
                            <p>{{$hasCancel['name']}}</p>
                        </div>

                    </div>
                    <div class="button-action" style="margin-top:20px">

                        <button type="button" lang="en"
                                class="waves-effect waves-light grey darken-2 btn modal-close">
                            Continue
                        </button>

                        <button type="button" lang="en" paypal-data-vacancy="{{json_encode($hasCancel)}}"
                                class="waves-effect waves-light green darken-2 btn try-again-paypal">
                            Try Again
                        </button>

                    </div>

                </div>
            </div>
        </div>


    </div>
    @endif

    @if($hasCheckout!=false)


            <!-- Compose Email Structure -->
    <div id="modal-checkout-done" class="modal std-modal" style="width:60%">
        <div class="modal-content">
            <nav class="green color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>

                            <li><a class="email-type" style="font-size:1.4rem">Thanks for your purchase!</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result green">
            <div class="row">

                <div style=" margin-top: 50px; margin-bottom: 50px;"
                     class="center form-result animated fadeIn">
                    <div class="white-text">
                        <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Thanks for your
                            purchase!
                        </h4>
                        <h6 lang="en" style="margin-bottom: 20px">Your ’Sponsored Job’ has been created successfully.
                            You’ll email you a receipt confirming the payment shortly.<br></h6>
                        <div class="col m2 offset-m3 left-align">
                            <p><strong>Vacancy:</strong></p>

                        </div>
                        <div class="col m6 left-align">
                            <p>{{$hasCheckout['name']}}</p>
                        </div>
                        <div class="col m2 offset-m3 left-align">
                            <p><strong>Transaction ID:</strong></p>
                        </div>
                        <div class="col m6 left-align">
                            <p>{{$hasCheckout['idPayment']}}</p>
                        </div>
                        <div class="col m2 offset-m3 left-align">
                            <p><strong>Total:</strong></p>

                        </div>
                        <div class="col m6 left-align">
                            <p>{{$hasCheckout['total']}}</p>
                        </div>
                    </div>
                    <div class="button-action" style="margin-top:20px">

                        <button type="button" lang="en"
                                class="waves-effect waves-light green darken-2 btn modal-close">
                            Continue
                        </button>
                    </div>

                </div>
            </div>
        </div>


    </div>
    @endif


            <!-- Compose Email Structure -->
    <div id="modal-sponsor-vacancy" class="modal std-modal" style="width:80%">
        <div class="modal-content">
            <nav class="red color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>

                            <li><a lang="en" href="#!" class="email-type title" style="font-size:1.4rem">Please review
                                    and confirm your order</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result">
            <div class="row">
                <div style="display: none;  margin-bottom: 50px;"
                     class="col s12 m12 l12 center form-loader">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-red-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style=" margin-top: 50px; margin-bottom: 50px;"
                     class="center form-confirm-paypal animated fadeIn">
                    <div class="black-text">

                        <input type="hidden" class="paypal_id" value="">
                        <div class="row promotional-code" style="width:70%;margin:0 auto">
                            <div class="col s12">
                                <h6 lang="en" style="text-align:left;">Hi {{Auth::user()->first_name}} <br>

                                    Please review and complete your purchase. You will sponsor the following job<br><br>

                                    Name: <strong class="paypal_name"></strong><br><br>
                                    Description: <strong class="paypal_description"></strong><br>
                                    Seniority: <strong class="paypal_seniority"></strong><br>
                                    <br><br>

                                    Sponsorship price: <strong class="paypal_subtotal">{{$subtotal}}</strong> €<br><br>
                                    VAT: <strong class="paypal_vat">{{$vat}}</strong>%<br><br>
                                    Total: <strong class="paypal_total">{{$total}}</strong> €<br><br>

                                </h6>
                            </div>
                            <div class="input-field col s4 ">
                                <input name="codiceScontoId" id="codiceScontoSponsorId" type="hidden">

                                <input name="codiceSconto" id="codiceScontoSponsor" type="text" class="validate">
                                <label lang="en" for="codiceScontoSponsor">Promotional code</label>
                            </div>
                            <div class="col s4">
                                <button type="button"
                                        class="waves-effect waves-light red darken-2 btn check-promotional-code"
                                        style="margin-top:20px">Apply code
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="button-action">
                        <button type="button" lang="en"
                                class="waves-effect waves-light green darken-2 btn pay-sponsor-vacancy">Confirm and Pay
                        </button>
                        <button type="button" lang="en"
                                class="waves-effect waves-light grey darken-2 btn modal-close" style="margin-left:80px">
                            Cancel
                        </button>
                    </div>

                </div>

            </div>
        </div>


    </div>

            <!-- Floating Action Button -->
    <div class="fixed-action-btn default-action-btn" style="bottom: 50px; right: 19px;">
        <a href="#modal-new-vacancy" class="btn-floating btn-large red modal-trigger">
            <i class="mdi-content-add"></i>
        </a>

    </div>
    <!-- Floating Action Button -->


    <!-- Floating Sort Button -->
    <div class="fixed-action-btn sort-action-btn" style="bottom: 50px; right: 19px; display: none;">
        <a class="btn-floating btn-large red">

            <div class="preloader-wrapper small active" style="display: none;">
                <div class="spinner-layer spinner-white" style="">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>

            <i class="mdi-action-done"></i>
        </a>


    </div>
    <!-- Floating Sort Button -->
    <form id="myContainer" method="post" action="/checkout"></form>

    <input type="hidden" id="companyId" value="{{Auth::user()->company['id']}}">
    <input type="hidden" id="companyPermalink" value="{{Auth::user()->company['permalink']}}">

@endsection

@section('page-scripts')


    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript"
            src="{{auto_version("/admin/js/hr.js")}}"></script>
    <script type="text/javascript" src="/admin/js/plugins/formatter/jquery.formatter.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/db.js"></script> <!--data-->
    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/jsgrid.min.js"></script>


    <script type="text/javascript" src="/admin/js/plugins/d3/d3.min.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/xcharts/xcharts.min.js"></script>
    <!-- morris -->
    <script type="text/javascript" src="/admin/js/plugins/chartist-js/chartist.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/chartjs/chart.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/raphael/raphael-min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/morris-chart/morris.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/morris-chart/morris-script.js"></script>


    <?php
    $dal = new \DateTime();
    $al = new \DateTime();
    $dal->sub(new \DateInterval("P8D"));
    $al->sub(new \DateInterval("P1D"));
    $cookie = 0;
    if (!isset($_COOKIE['count_visit'])) {
        setcookie("count_visit", "1", time() + (10 * 365 * 24 * 60 * 60));
        $cookie = 1;
    } else {
        $cookie = intval($_COOKIE['count_visit']) + 1;
        setcookie("count_visit", $cookie, time() + (10 * 365 * 24 * 60 * 60));
    }

    $env = "production";
    if (getenv('APP_ENV') == "local") {
        $env = "sandbox";
    }

    ?>
    <input type="hidden" id="al" value="{{$al->format("d-m-Y")}}">
    <input type="hidden" id="dal" value="{{$dal->format("d-m-Y")}}">
    <style>
        #doughnut-chart-sample-legend li span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
        }
    </style>

    <script type="text/javascript">

        $(document).ready(function () {
            HR.init();
            window.statisticsRequest = [];
            <?php

            if($cookie==2 && \Illuminate\Support\Facades\Auth::user()->company['is_complete']==false){ ?>
            swal({
                        title: "{{trans("hr.title_popup_complete_page")}}",
                        text: "{{trans("hr.text_popup_complete_page")}}",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "{{trans("hr.button_cancel_popup_complete_page")}}",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans("hr.button_confirm_popup_complete_page")}}",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                    },
                    function () {
                        setTimeout(function () {
                            $.post("/hr/enqueue/complete-page", [], function (data, status, xhr) {
                                swal("{{trans("hr.confirm_message_popup_complete_page")}}");
                            }).fail(function () {

                            });
                        }, 2000);

                    });
            <?php }


                    ?>



            <?php
              if($hasCheckout!=false){
                        ?>
                      $("#modal-checkout-done").openModal();

            <?php }
            ?>

 <?php
              if($hasCancel!=false){
                        ?>
                      $("#modal-checkout-cancel").openModal();


            $(document).on("click", ".try-again-paypal", function (e) {
                paypal.checkout.initXO();
                var vacancy = JSON.parse($(this).attr("paypal-data-vacancy"));

                var action = $.post('/checkout/paypal?vacancyId=' + vacancy.id, vacancy);

                action.done(function (data) {
                    paypal.checkout.startFlow(data.token);
                });

                action.fail(function () {
                    paypal.checkout.closeFlow();
                });
            });


            <?php }
            ?>


        });


    </script>
@endsection