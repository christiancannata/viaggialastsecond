<div style="    z-index: 999999;" id="sticky" class="fadeIn">


    <header class="hidden-md hidden-lg" style="background:#f04d52;width:100%;">
        <a href="#1" class="pull-left" id="secondary-menu-button" style="background:#f04d52 !important; ">
           {{trans('common.discover')}} {{$company["name"]}}  <i class="fa fa-angle-down"></i>
        </a> <!-- cd-primary-nav-trigger -->

    </header>
    <nav class="hidden-md hidden-lg secondary-menu ">
        <ul >

            <li><a href="#company-slider"
                >{{ trans('common.back_on_top') }}</a></li>

            <li><a href="#job-vacancies">{{ trans('common.job_vacancies') }}</a></li>
            @if (isset($company['vision']) && $company['vision']!="")
                <li><a href="#vision">{{ trans('common.vision_menu') }}</a></li>
            @endif
            <li><a href="#our-story">{{ trans('common.our_story_menu') }}</a></li>
            @if (isset($company['benefits']))
                <li><a href="#benefit">{{ trans('common.benefit') }}</a></li>
            @endif
            @if (isset($company['team']))
                <li><a href="#team">{{ trans('common.meet_the_team') }}</a></li>
            @endif
        </ul>
    </nav>


    <div class="container-fluid hidden-sm hidden-xs sticky header-menu company">
        <div class="row">
            <div class="col col-md-16">
                <div class="col-md-2 col-md-offset-1">
                    <div class="header-menu-meritocracy-logo">
                        <a href="/{{App::getLocale()}}/"><img class="header-menu-meritocracy-logo-image"
                                                              src="/img/logos/black-logo.png"></a>
                    </div>
                </div>

                <div class="col-md-8">
                    <h3 style="font-size:25px;">{{$company["name"]}}</h3>
                </div>


                @include('template/sticky-header')


            </div>


        </div>
    </div>

    <div class="container-fluid hidden-sm hidden-xs  sub-header-menu block-violet ">
        <div class="container">
            <div class="row">
                <div style="display: none;" class="block block-company stay-scroll col col-md-4">


                    <div class="row">
                        <div class="col-md-16 block-violet block-content">

                            @if (isset($company["info"]["address"]))
                                <div class="map" id="map-header-menu"></div>
                                <h4 class="content">{{ $company["info"]["city"] }}</h4>

                                @endif

                                @if (isset($company["industry"]))
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.industry') }}</h3>
                                    <h3 class="content">{{$company["industry"]['name']}}</h3>
                                @endif

                                @if (isset($company['foundation_date']))
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.foundation_date') }}</h3>
                                    <h3 class="content">{{$company['foundation_date']}}</h3>
                                @endif

                                <div class="clear"></div>

                                <h5 class="share-company text-uppercase red">{{ trans('common.share_page') }}</h5>
                                <ul class="soc soc-red">
                                    <li><a class="soc-linkedin" href="#"></a></li>
                                    <li><a class="soc-facebook" href="#"></a></li>
                                    <li><a class="soc-twitter" href="#"></a></li>

                                    <li><a class="" href="mailto:?Subject="><i class="fa fa-envelope"></i></a></li>

                                </ul>


                        </div>
                    </div>

                </div>

                <div class="col-md-12 col-md-offset-4 block-violet ">

                    <ul class="nav navbar-nav navbar-white">
                        <li><a href="#company-slider">{{ trans('common.back_on_top') }}</a></li>
                        <li><a href="#job-vacancies">{{ trans('common.job_vacancies') }}</a></li>

                        @if (isset($company['story']) && strlen($company['story']) >= 1)
                            <li><a href="#our-story">{{ trans('common.our_story_menu') }}</a></li>
                        @endif

                        @if (isset($company['vision']) && strlen($company['vision']) >= 1)
                            <li><a href="#vision">{{ trans('common.vision_menu') }}</a></li>
                        @endif

                        @if (isset($company['mission'])  && strlen($company['mission']) >= 1)
                            <li><a href="#mission">{{ trans('common.company_mission') }}</a></li>
                        @endif

                        @if (isset($company['values']) && strlen($company['values']) >= 1)
                            <li><a href="#our-values">{{ trans('common.company_values') }}</a></li>
                        @endif

                        @if(isset($company['benefits']) && count($company['benefits'])>0)
                            <li><a href="#benefit">{{ trans('common.benefit') }}</a></li>
                        @endif

                        @if (isset($company['team']) && count($company['team'])>0)
                            <li><a href="#team">{{ trans('common.meet_the_team') }}</a></li>
                        @endif

                        @if (isset($company['video_url']) && $company['video_url']!="" )
                            <li><a href="#video">{{ trans('common.video') }}</a></li>
                        @endif
                    </ul>


                </div>

            </div>


        </div>


    </div>
</div>
</div>