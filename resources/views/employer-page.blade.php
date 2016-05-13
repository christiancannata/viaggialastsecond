@extends('template.layout')

@yield('header')

@section('page-css')
    <link rel="stylesheet" href="/vendors/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="/vendors/photoswipe/default-skin/default-skin.css">

    <style>
        .popover-title {
            margin: 0;
            padding: 8px 14px;
            font-size: 15px;
            background-color: #FAC349 !important;
            border-bottom: none;
            border-radius: 0 !important;
            font-family: 'Karla-Bold', 'sans-serif';
            text-align: center;
        }

        .popover {
            background-color: #FAC349 !important;
            border-radius: 0 !important;
            border: none !important;
        }

        .popover-content {
            background-color: #FAC349 !important;
            text-align: center !important;
            font-family: 'Karla-Regular', 'sans-serif';
        }

        .popover.top > .arrow:after {
            border-top-color: #FAC349 !important;
        }

    </style>


@endsection

@section('content')
    <?php
    if (isset($company['website']) && session('refererUrlAts') && session('refererUrlAts') == "resetted" && isset($_SERVER['HTTP_REFERER']) && $company['has_ats'] && strpos($_SERVER['HTTP_REFERER'], $company['website'])) {
        session(["refererUrlAts" => $_SERVER['HTTP_REFERER']]);
    }
    $ats = "";
    ?>
    @if((isset($company['website']) && session('refererUrlAts') && strpos(session('refererUrlAts'),$company['website']) && $company['has_ats'] ) || \Illuminate\Support\Facades\Input::get("__ats") || (isset($company['website']) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],$company['website'])))
        <?php $ats = "?__ats=1"; session(["refererUrlAts" => "resetted"]); ?>
    @endif

    @if($ats!="")
        <style>.header-menu {  display: none !important;  } </style>
    @endif


        <div class="pswp " tabindex="-1" role="dialog" aria-hidden="true">

           <div class="pswp__bg"></div>

            <div class="pswp__scroll-wrap">


                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>

                <div class="pswp__ui pswp__ui--hidden">

                    <div class="pswp__top-bar">


                        <div class="pswp__counter"></div>

                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                        <button class="pswp__button pswp__button--share" title="Share"></button>

                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>

                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>

                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>

                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>

                </div>

            </div>

        </div>

        <div data-interval="false" id="company-slider" data-ride="carousel"
             class="container-fluid container-photo-slider carousel slide ">


            <div class="row ">


                <div class="carousel-inner company-slider " role="listbox">

                    @if(isset($company["video_home"]))
                        <div class="item active">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video id="companyVideo" style="max-height: 75vh!important;  object-fit: cover;"
                                       class="embed-responsive-item" muted
                                       poster="{{$company["video_home_thumb"] or "https://storage.meritocracy.is/Video/thumbnail%20youtube.png"}}">
                                    <source src="{{$company["video_home"]}}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    @endif

                    {{-- */$a=0;/* --}}
                    @if(isset($company["sliders"]) && count($company["sliders"]) > 0 )
                        @foreach($company["sliders"] as $index =>$slide)


                            @if($slide['status'])
                                <div class="item @if($a==0 && !isset($company["video_home"])) active @endif">
                                    <div class="company-img-parent overlay">

                                        <img
                                             class="company-img"
                                             src="{{$slide["link"]}}"
                                             alt="Company office photos">
                                    </div>
                                </div>
                                {{-- */$a++;/* --}}
                            @endif
                        @endforeach
                    @else
                            <div class="item active">
                                <div class="company-img-parent overlay">

                                    <img
                                            class="company-img"
                                            src="https://www.filepicker.io/api/file/s3VNHzH8TNGfAjd2pLLM"
                                            alt="Company office placeholder image">
                                </div>
                            </div>


                    @endif
                </div>


            </div>

            <!-- Left and right controls -->
            <a onclick="Company.loadPhotoswipeSlider()" class="left carousel-control" href="#company-slider"
               role="button"
               data-slide="prev">
                <img src="/img/freccia_sx.png">

            </a>
            <a onclick="Company.loadPhotoswipeSlider()" class="right carousel-control" href="#company-slider"
               role="button"
               data-slide="next">
                <img src="/img/freccia_dx.png">
            </a>


        </div>


        <div class="container-fluid company-container">
            <div class="top" id="sticky-anchor"></div>
            <div class="top" id="sticky-anchor-2"></div>

            <div class="container">

                <div class="row">
                    <div class="col col-md-5 col-sm-5 block-width">

                        <div id="sticky-2" class="block block-company block-violet">


                            <div style=" " class="block-content-title-parent animated">

                                <div class="col-md-16 block-content-title background-red title">

                                    <p class="company-title hidden-xs"
                                    >{{count($vacancies)}} @if(count($vacancies)>1){{trans('common.opportunities')}}@else{{trans('common.opportunity')}}@endif</p>

                                    <h1 class="company-title hidden-md hidden-lg hidden-sm"
                                    >
                                        {{$company["name"]}}
                                    </h1>
                                </div>

                            </div>

                            <div class="">
                                <div class="col-md-16 block-content">

                                    @if (isset($company["addresses"][0]) && trim($company["addresses"][0]['name'])!="")
                                        <div class="map " id="map"></div>
                                        <h4 class="content">{{ $company["city_plain_text"] }}</h4>
                                        <input type="hidden" id="address"
                                               value="{{$company["addresses"][0]['name']}}, {{$company["addresses"][0]['city_plain_text']}}">
                                    @elseif($company["city_plain_text"]!="")
                                        <div class="map" id="map"></div>
                                        <h4 class="content">{{ $company["city_plain_text"] }}</h4>
                                        <input type="hidden" id="address" value="{{ $company["city_plain_text"] }}">
                                    @endif
                                    <div class="clear hidden-lg hidden-md"></div>

                                    <div style="padding-left: 0!important" class="col-xs-16 col-md-16 col-lg-16">
                                        @if (isset($company["industry"]['name']))
                                            <div class="clear hidden-xs"></div>
                                            <h3 class="title">{{ trans('common.industry') }}</h3>
                                            <h3 class="content">{{$company["industry"]['name']}}</h3>
                                        @endif

                                    </div>

                                    <div style="padding-left: 0!important" class="col-xs-16  col-md-16 col-lg-16">
                                        @if (isset($company["foundation_date"]) && $company["foundation_date"]!="")
                                            <div class="clear hidden-xs"></div>
                                            <h3 class="title">{{ trans('common.foundation_date') }}</h3>
                                            <h3 class="content">{{$company["foundation_date"]}}</h3>
                                        @endif
                                    </div>

                                    <div class="clearfix"></div>

                                    <h5 class="share-company text-uppercase red">{{ trans('common.share_this_page') }}</h5>
                                    <ul class="soc soc-red">
                                        <li><a class="soc-linkedin" href="#"></a></li>
                                        <li><a class="soc-facebook" href="#"></a></li>
                                        <li><a class="soc-twitter" href="#"></a></li>

                                        <li><a class="" href="mailto:?Subject="><i class="fa fa-envelope"></i></a>
                                        </li>

                                        <div class="fb-save hidden-xs" data-uri="{{Request::url()}}"
                                             data-size="large"></div>


                                    </ul>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="hidden-md hidden-xs hidden-lg">
                        <h1 class="company-title" style="margin-bottom: 20px;"
                        >{{$company['name']}}</h1>

                        @if (isset($company["addresses"]))
                            <h4 class="content red-label"
                                style="font-size: 16px;margin-top: 10px;">{{ $company["city_plain_text"] }}</h4>

                        @endif


                        <div class="col col-sm-2 col-sm-offset-1">

                            @if (isset($company["employees"]))
                                <div class="row">
                                    <div class="col col-md-8">
                                        <div class="benefit">

                                            <img class="img-responsive"
                                                 src="/img/employees.png">
                                        </div>

                                    </div>
                                    <div style="margin-top:10px;" class="col col-md-8 text-center">
                                        <span>{{ trans('common.employees') }}</span>
                                        <span>{{ $company["employees"] }}</span>

                                    </div>

                                </div>

                            @endif
                        </div>
                        <div class="col col-sm-2">
                            @if (isset($company["age_average"]) && $company['age_average']!="")
                                <div class="row">
                                    <div class="col col-md-8">
                                        <div class="benefit">

                                            <img class="img-responsive" src="/img/avg_age.png">
                                        </div>

                                    </div>
                                    <div style="margin-top:10px;" class="col col-md-8 text-center">
                                        <span>{{ trans('common.age_range') }}</span>
                                        <span>{{$company["age_average"]}}</span>

                                    </div>

                                </div>
                            @endif
                        </div>
                        <div class="col col-sm-2">
                            @if (isset($company["male"]) && isset($company["female"]) && $company["female"]!="" && $company['male']!="")
                                <div class="row">
                                    <div class="col col-md-8">
                                        <div class="benefit">

                                            <img class="img-responsive"
                                                 src="/img/male_female.png">
                                        </div>

                                    </div>
                                    <div style="margin-top:10px;" class="col col-md-8 text-center">
                                        <span>{{ trans('common.genere') }}</span><br>
                                        <span>{{ $company["male"]!=""?$company['male']:"0" }}
                                            % {{ " / " . $company["female"]}}%</span>

                                    </div>

                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="information-container col-md-11 col-sm-16" style="padding-top:20px;">


                        <div class="row hidden-xs hidden-sm">
                            <div class="col col-md-16">

                                <h1 class="company-title"
                                >{{$company['name']}}</h1>

                                @if (isset($company["addresses"]))
                                    <h4 class="content red-label"
                                        style="font-size: 16px;margin-top: 10px;">{{ $company['city_plain_text'] }}</h4>

                                @endif
                                @if($company['is_premium'])
                                    <img id="isPremium" data-placement="top" data-toggle="popover"
                                         title="{{trans('common.premium_flag_title')}}"
                                         data-content="{{trans('common.premium_flag_desc')}}" src="/img/premium.png"
                                         style="margin-top: -20px;
    position: absolute;
    right: 15%;
    top: 0;">
                                @endif
                            </div>


                        </div>

                        <div class="row hidden-xs" style="margin-top: 20px;">
                            <div class="col col-md-4 col-xs-4 col-xs-offset-2 col-md-offset-0">

                                @if (isset($company["employees"]))
                                    <div class="row">
                                        <div class="col col-md-8">
                                            <div class="benefit">

                                                <img class="img-responsive"
                                                     src="/img/employees.png">
                                            </div>

                                        </div>
                                        <div style="margin-top:10px; padding-left: 5px;" class="col col-md-8">
                                            <span>{{ trans('common.employees') }}</span>
                                            <span>{{ $company["employees"] }}</span>

                                        </div>

                                    </div>

                                @endif
                            </div>
                            <div class="col col-md-4 col-xs-4">
                                @if (isset($company["age_average"]) && $company['age_average']!="" && $company['age_average']!=0)
                                    <div class="row">
                                        <div class="col col-md-8">
                                            <div class="benefit">

                                                <img class="img-responsive"
                                                     src="/img/avg_age.png">
                                            </div>

                                        </div>
                                        <div style="margin-top:10px; padding-left: 5px;" class="col col-md-8">
                                            <span>{{ trans('common.age_range') }}</span>
                                            <span>{{$company["age_average"]}}</span>


                                        </div>

                                    </div>
                                @endif
                            </div>
                            <div class="col col-md-4 col-xs-4">
                                @if (isset($company["male"]) && isset($company["female"]) && $company["female"]!="" && $company['male']!="")
                                    <div class="row">
                                        <div class="col col-md-8">
                                            <div class="benefit">

                                                <img class="img-responsive"
                                                     src="/img/male_female.png">
                                            </div>

                                        </div>
                                        <div style="margin-top:10px; padding-left: 5px;" class="col col-md-8">
                                            <p style="width:150px; margin: 0 0 0">{{ trans('common.genere') }}</p>
                                        <span>{{ $company["male"]!=""?$company['male']:"0" }}
                                            % {{ " / " . $company["female"]}}%</span>

                                        </div>

                                    </div>
                                @endif
                            </div>


                        </div>
                        <div class="row hidden-sm hidden-md hidden-lg center space-div" style="margin-top: 20px;">


                            @if (isset($company["employees"]))
                                <div class="col col-xs-5">
                                    <span>{{ trans('common.employees') }}</span>
                                    <h4>{{ $company["employees"] }}</h4>

                                </div>



                            @endif

                            @if (isset($company["age_average"]) && $company['age_average']!="" && $company['age_average']!=0)

                                <div class="col col-xs-5">
                                    <span>{{ trans('common.age_range') }}</span>
                                    <h4>{{$company["age_average"]}}</h4>


                                </div>


                            @endif

                            @if (isset($company["male"]) && isset($company["female"]) && $company["female"]!="" && $company['male']!="")

                                <div class="col col-xs-6">
                                    <span>{{ trans('common.genere') }}</span>
                                    <h4>{{ $company["male"]!=""?$company['male']:"0" }}
                                        % {{ " / " . $company["female"]}}%</h4>

                                </div>


                            @endif


                        </div>

                        <div class="row">


                            @if (isset($vacancies) && count($vacancies) > 0)

                                <div id="job-vacancies" class="col col-md-16">
                                    <h4 data-target=".jobs-vacancies"
                                        class="bold red-label fade-trigger">{{ trans($route.'.job_opportunities') }} <i
                                                style="float: right;"
                                                class="fa fa-minus hidden-sm hidden-md hidden-lg sp-change"
                                                aria-hidden="true"></i></h4>
                                </div>

                                <div class="col col-md-16">
                                    <div class="row">
                                        <div class="col col-md-16 jobs-container jobs-vacancies">
                                            <div class="row">
                                                @if(count($vacancies) == 0)
                                                    <div class="col-md-16 jobs-stat">
                                                        <h5>{{ trans($route.'.no_vacancies') }}</h5>
                                                    </div>
                                                @endif

                                                @foreach ($vacancies as $vacancy)
                                                    <div class="col-md-16 jobs-stat">
                                                        <div class="row">
                                                            <div class="col-md-11 col-xs-16 col-sm-12">


                                                                <h4 class="vacancy-name"><a class="vacancy-name-apply" href="/{{App::getLocale()}}/{{$company['permalink']}}/{{$vacancy['permalink']}}@if(\Illuminate\Support\Facades\Input::get("__ats") || $ats!=""){{"?__ats=1"}}@endif">{{ $vacancy['name'] }}</a>
                                                                    @if($vacancy["is_new"])<span
                                                                            class="badge badge-new-vacancy">NEW</span>@endif
                                                                </h4>
                                                                <p class="margin-top-10">
                                                                    {{--*/  $m =  (new \Moment\Moment($vacancy['open_date']))->fromNow();/*--}}
                                                                    {{trans('common.vacancy_opened_on')}}
                                                                    <b>{{$m->getRelative()}}</b><br>
                                                                    {{trans('common.vacancy_position')}}:
                                                                    <b>{{$vacancy["city_plain_text"]}}</b>
                                                                </p>

                                                                <p class="vacancy-location-value"></p>

                                                                <span class="vacancy-purpose">{{ trans($route.'.job_purpose') }}:</span>
                                                                <div class="vacancy-description"><?php echo strip_tags($vacancy['description'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?></div>


                                                            </div>

                                                            <div class="col-md-5 col-xs-16">

                                                                <a href="/{{App::getLocale()}}/{{$company['permalink']}}/{{$vacancy['permalink']}}@if(\Illuminate\Support\Facades\Input::get("__ats") || $ats!=""){{"?__ats=1"}}@endif">
                                                                    <button class="btn btn-red btn-block">{{ trans('common.apply_now_btn_std') }}</button>
                                                                </a>

                                                                <p class="vacancy-share-job text-center text-uppercase red hidden-lg hidden-md hidden-xs hidden-sm">
                                                                    {{ trans('common.share_job') }}</p>

                                                                <div class="text-center job-social-share">
                                                                    <h5 class="share-company text-uppercase red">{{ trans('common.share_job') }}</h5>
                                                                    <ul class="soc soc-violet"
                                                                        data-share-title="{{ $vacancy['name'] }}"
                                                                        data-share-link="/{{App::getLocale()}}/{{$company['permalink']}}/{{$vacancy['permalink']}}@if(\Illuminate\Support\Facades\Input::get("__ats") || $ats!=""){{"?__ats=1"}}@endif">
                                                                        <li><a class="soc-linkedin " href="#"></a>
                                                                        </li>
                                                                        <li><a class="soc-facebook" href="#"></a>
                                                                        </li>
                                                                        <li><a class="soc-twitter" href="#"></a>
                                                                        </li>

                                                                        <li><a class="" href="mailto:?Subject="><i
                                                                                        class="fa fa-envelope"></i></a>
                                                                        </li>


                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>

                                        <div style="display:none;" class="col col-md-16 hidden-sm sp-placeholder">
                                            <div class="row">
                                                <div class="col col-md-16">
                                                    <div class="row">


                                                        <div class="col-md-14">
                                                            <div style="padding:0!important" class="row jobs-stat">
                                                                <h4 class="text-center"
                                                                    style="margin-bottom: 30px; margin-top: 30px;">{{count($vacancies)}} {{trans('common.jobs')}}</h4>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div id="job-vacancies" class="col col-md-16">
                                    <h4 class="bold red-label">{{ trans($route.'.job_opportunities') }}</h4>
                                </div>
                                <div class="col col-md-16">
                                    <div class="row">
                                        <div class="col col-md-16 jobs-container jobs-vacancies">
                                            <div class="row">


                                                <div class="col-md-14">
                                                    <div class="row jobs-stat">
                                                        <h4 class="text-center"
                                                            style="margin-bottom: 30px; margin-top: 30px;"> {{trans('common.no_job_opportunity')}}</h4>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if (isset($company['story']) && strlen($company['story']) >= 1)
                                <div id="our-story" class="col col-md-13">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <h4 class="bold red-label">{{ trans('common.our_story') }}</h4>
                                        </div>

                                        <div class="col col-md-16 jobs-container">

                                            <p>
                                                <?php echo strip_tags($company['story'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?>
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if (isset($company['vision'])  && strlen($company['vision']) >= 1)
                                <div id="vision" class="col col-md-13">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <h4 data-json-mod="vision-label"
                                                class="bold red-label">{{ $company['visionTitle'] or  trans('common.vision') }}</h4>
                                        </div>

                                        <div class="col col-md-16 jobs-container">

                                            <p>
                                                <?php echo strip_tags($company['vision'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            @endif


                            @if (isset($company['mission'])  && strlen($company['mission']) >= 1)
                                <div id="mission" class="col col-md-13">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <h4 class="bold red-label">{{ trans('common.company_mission') }}</h4>
                                        </div>

                                        <div class="col col-md-16 jobs-container">

                                            <p>
                                                <?php echo strip_tags($company['mission'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?>
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            @endif


                            @if (isset($company['our_values']) && strlen($company['our_values']) >= 1)
                                <div id="our-values" class="col col-md-13">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <h4 class="bold red-label">{{ trans('common.our_values') }}</h4>
                                        </div>

                                        <div class="col col-md-16 jobs-container">

                                            <p>
                                                <?php echo strip_tags($company['our_values'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?>
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if(isset($company['benefits']) && count($company['benefits'])>0)
                                <div class="col col-md-16 ">
                                    <div class="row">

                                        <div class="col col-md-16">
                                            <h4 class="bold red-label" id="benefit">Benefits</h4>
                                        </div>
                                        @foreach ($company['benefits'] as $benefit)
                                            <div class="col col-md-8 col-xs-8 col-sm-8 benefit-container">
                                                <div class="row" style="height: 70px">
                                                    <div class="col-md-4">
                                                        <div class="benefit-std" style="display: inline;">
                                                            <img style="display: inline;margin-right: 10px;"
                                                                 class="img-responsive"
                                                                 src="/img/{{$benefit["icon"]}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10"><span
                                                                style="display: inline;">{{$benefit["name"]}}</span>

                                                    </div>
                                                </div>


                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if (isset($company['team'][0]))
                                <div class="col col-md-16">

                                    <div class="row team-container" id="team">
                                        <div class="col col-md-16">
                                            <h4 class="bold red-label">{{ trans('common.meet_the_team') }}</h4>
                                        </div>


                                    </div>

                                    <div class="hidden-sm hidden-md hidden-lg">
                                        <div style="margin-top: 0" id="myCarousel" class="carousel slide"
                                             data-ride="carousel">
                                            <!-- Indicators -->
                                            <ol class="carousel-indicators">
                                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                                @if(isset($company["team"][1]))
                                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                                @endif
                                                @if(isset($company["team"][2]))
                                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                                @endif
                                            </ol>

                                            <!-- Wrapper for slides -->
                                            <div class="carousel-inner" role="listbox">

                                                <div class="col col-xs-16 item active">
                                                    <div class="profile">
                                                        <img src="{{$company["team"][0]["photo"]}}" class="image">

                                                        <p class="name">{{$company["team"][0]["name"]}}</p>

                                                        <p class="role">{{$company["team"][0]["role"]}}</p>

                                                        <div class="social">
                                                            <ul class="soc-no-action">
                                                                <li><a target="_blank" class="soc-linkedin"
                                                                       href="{{$company["team"][0]["linkedin_url"]}}"></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(isset($company["team"][1]))
                                                    <div class="col col-xs-16 item">
                                                        <div class="profile">
                                                            <img src="{{$company["team"][1]["photo"]}}" class="image">

                                                            <p class="name">{{$company["team"][1]["name"]}}</p>

                                                            <p class="role">{{$company["team"][1]["role"]}}</p>

                                                            <div class="social">
                                                                <ul class="soc-no-action">
                                                                    <li><a target="_blank" class="soc-linkedin"
                                                                           href="{{$company["team"][1]["linkedin_url"]}}"></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(isset($company["team"][2]))
                                                    <div class="col col-xs-16 item">
                                                        <div class="profile">
                                                            <img src="{{$company["team"][2]["photo"]}}" class="image">

                                                            <p class="name">{{$company["team"][2]["name"]}}</p>

                                                            <p class="role">{{$company["team"][2]["role"]}}</p>

                                                            <div class="social">
                                                                <ul class="soc-no-action">
                                                                    <li><a target="_blank" class="soc-linkedin"
                                                                           href="{{$company["team"][2]["linkedin_url"]}}"></a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Left and right controls -->
                                            <a style="color: black!important; padding-left: 0; padding-right: 0px!important; "
                                               class="left carousel-control" href="#myCarousel" role="button"
                                               data-slide="prev">
                                                <span style="font-size: 25px;!important;"
                                                      class="glyphicon glyphicon-chevron-left"
                                                      aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a style="color: black!important; padding-left: 0; padding-right: 0px!important;"
                                               class="right carousel-control" href="#myCarousel" role="button"
                                               data-slide="next">
                                                <span style="font-size: 25px;!important;"
                                                      class="glyphicon glyphicon-chevron-right"
                                                      aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>

                                    </div>


                                    <div class="hidden-xs">
                                        <div class="col col-md-5 col-sm-8 col-xs-16">
                                            <div class="profile">
                                                <img src="{{$company["team"][0]["photo"]}}" class="image">

                                                <p class="name">{{$company["team"][0]["name"]}}</p>

                                                <p class="role">{{$company["team"][0]["role"]}}</p>

                                                <div class="social">
                                                    <ul class="soc-no-action">
                                                        <li><a target="_blank" class="soc-linkedin"
                                                               href="{{$company["team"][0]["linkedin_url"]}}"></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($company["team"][1]))
                                            <div class="col col-md-5 col-sm-8 col-xs-16">
                                                <div class="profile">
                                                    <img src="{{$company["team"][1]["photo"]}}" class="image">

                                                    <p class="name">{{$company["team"][1]["name"]}}</p>

                                                    <p class="role">{{$company["team"][1]["role"]}}</p>

                                                    <div class="social">
                                                        <ul class="soc-no-action">
                                                            <li><a target="_blank" class="soc-linkedin"
                                                                   href="{{$company["team"][1]["linkedin_url"]}}"></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(isset($company["team"][2]))
                                            <div class="col col-md-5 col-sm-8 col-xs-16">
                                                <div class="profile">
                                                    <img src="{{$company["team"][2]["photo"]}}" class="image">

                                                    <p class="name">{{$company["team"][2]["name"]}}</p>

                                                    <p class="role">{{$company["team"][2]["role"]}}</p>

                                                    <div class="social">
                                                        <ul class="soc-no-action">
                                                            <li><a target="_blank" class="soc-linkedin"
                                                                   href="{{$company["team"][2]["linkedin_url"]}}"></a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if (isset($company['video_url']) && $company['video_url']!="" )
                                <div class="col col-md-16">

                                    <div class="row " id="video">
                                        <div class="col col-md-16">
                                            <h4 class="bold red-label">{{ trans('common.video_introduction') }} {{$company["name"]}} </h4>

                                            <div class="video-container">
                                                <div class="embed-responsive embed-responsive-4by3">
                                                    <div data-video="{{$company["video_url"]}}"
                                                         id="ytplayer"></div>

                                                    <script>
                                                        // Load the IFrame Player API code asynchronously.
                                                        var tag = document.createElement('script');
                                                        tag.src = "https://www.youtube.com/player_api";
                                                        var firstScriptTag = document.getElementsByTagName('script')[0];
                                                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                                                        // Replace the 'ytplayer' element with an <iframe> and
                                                        // YouTube player after the API code downloads.
                                                        var player;

                                                        var videoId = document.getElementById("ytplayer").getAttribute("data-video").split(/[/ ]+/).pop();
                                                        function onYouTubePlayerAPIReady() {
                                                            player = new YT.Player('ytplayer', {
                                                                videoId: videoId,
                                                                modestbranding: false,
                                                                rel: 0
                                                            });
                                                        }
                                                    </script>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            @endif


                            <div class="clear col col-md-16 hidden-xs" style="height: 100px">
                                <div style="position:absolute; top: -400px;" id="sticky-2-max"></div>
                            </div>


                        </div>
                    </div>


                </div>


            </div>

        </div>
        </div>

        @foreach($company["extra"] as $key => $extra)
            <input class="sisti" type="hidden" value="{!! $extra or "" !!}" id="{{$key}}">
        @endforeach

        @include('template.sticky-menu-company')
@endsection

@section('page-scripts')
    <script type="text/javascript" src="{{auto_version("/js/pages/company.js")}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript" src="/vendors/photoswipe/photoswipe-ui-default.min.js"></script>
    <script type="text/javascript" src="/vendors/photoswipe/photoswipe.min.js"></script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/939631663/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>

    <script type="text/javascript">
        Company.init();

        /* <![CDATA[ */
        var google_conversion_id = 939631663;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */

        @if(Auth::check() && Auth::user()->vacancies_applicated)

      setTimeout(function () {
            if ($.cookie('_pushHomeRequest') == null || $.cookie('_pushHomeRequest') != 1) {
                $.cookie('_pushHomeRequest', 1, {expires: 7});
                requirePush();
            }
        }, 1500);
        @endif





            fbq('track', 'ViewContent');

    </script>

@endsection