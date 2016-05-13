@extends('template.layout')

@yield('header')



@section('content')
    @include('template.sticky-menu')


    <div class="container-fluid how-it-works-container jobs-container company-container no-bordered-container search-result">
        <div class="container" style="margin-bottom:40px;background:none !important;">
            <div class="row">
                <div class="col col-md-16">

                    <div id="sticky-anchor"></div>
                    <div class="text-seperated " style="margin-left: 92px;">
                        <h1 data-translate="">
                            {!! trans($route.'.main_title') !!}"{{$key}}"
                        </h1>

                        <p data-translate="">
                            {!! trans($route.'.main_subtitle') !!} {{count($vacancies)}} {{trans($route.".results")}}
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col col-md-16">
                    <div class="search-block-meritocracy-logo  hidden-xs  hidden-sm" style="margin-left:-9px;">
                        <img src="/img/logos/black-logo.png" class="header-menu-meritocracy-logo-image">
                    </div>
                    <div class="central-block-white">


                        <form method="GET" action="">
                            <input name="key" class="search-block-input"style="width:80% !important;" data-translate=""
                                   placeholder="{{ trans('homepage.placeholder_search') }}"
                                   autocomplete="on" type="text" value="{{Input::get("key")}}">
                            <button class="btn-search"><i class="fa fa-search" style=""></i></button>
                        </form>


                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($vacancies as $vacancy)
                    @if(isset($vacancy) && $vacancy['is_visible']==true && $vacancy['company']['id']!=114)
                        <div class="col-md-16 jobs-stat">
                            <div class="row">

                                <div class="col-md-4 col-xs-12 col-sm-4">
                                    <div class="hidden-xs">
                                        <p class="vacancy-location-value company-name">{{$vacancy['company']['name']}}</p>
                                        @if(isset($vacancy['company']['logo_small']))
                                            <img class="portfolio-image img-responsive"
                                                 src="{{$vacancy['company']['logo_small']}}"
                                                 alt=""/>
                                        @endif
                                        @if(isset($vacancy['city_plain_text']))
                                            <div class="vacancy-info">
                                                <span class="vacancy-location text-uppercase">Location</span>

                                                <p class="vacancy-location-value">{{$vacancy['city_plain_text']}}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="hidden-md hidden-lg hidden-sm">
                                        <p class="vacancy-location-value company-name" >{{$vacancy['company']['name']}}</p>

                                        @if(isset($vacancy['company']['logo_small']))
                                            <img class="portfolio-image img-responsive"
                                                 src="{{$vacancy['company']['logo_small']}}"
                                                 alt=""/>
                                        @endif
                                        @if(isset($vacancy['city_plain_text']))
                                            <div iclass="vacancy-info">
                                                <span class="vacancy-location text-uppercase">Location</span>

                                                <p class="vacancy-location-value">{{ucfirst(strtolower($vacancy['city_plain_text']))}}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8 col-xs-16 col-sm-16">
                                    <h4 class="vacancy-name">{{ $vacancy['name'] }}
                                        @if($vacancy["is_new"])<span class="badge badge-new-vacancy">NEW</span>@endif
                                    </h4>

                                    @if(isset($vacancy['open_date']))
                                        <span class="vacancy-purpose hidden-xs">{{ trans('common.vacancy_opened_on') }}</span>
                                        <p class="vacancy-description hidden-xs">
                                            {{--*/ $date=new \DateTime($vacancy['open_date']) /*--}}
                                            {{ $date->format("d/m/Y") }}</p>

                                    @endif
                                    @if(isset($vacancy['description']))
                                        <span class="vacancy-purpose hidden-xs">{{ trans('company-page.job_purpose') }}</span>
                                        <p class="vacancy-description hidden-xs">{{ strip_tags($vacancy['description']) }}</p>

                                    @endif
                                    @if(isset($vacancy['city_plain_text']))
                                        <div class="vacancy-info hidden-md hidden-lg">
                                            <p class="vacancy-location-value">{{ucfirst(strtolower($vacancy['city_plain_text']))}}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="col col-xs-16 hidden-md hidden-lg">
                                    @if(isset($vacancy['description']))
                                        <p class="vacancy-description">{{ strip_tags($vacancy['description']) }}</p>
                                    @endif
                                </div>

                                <div class="col-md-4 col-xs-16">
                                    @if(isset($vacancy['permalink']) && isset($vacancy['company']['permalink']))
                                        <a href="/{{App::getLocale()}}/{{$vacancy['company']['permalink']}}/{{$vacancy['permalink']}}">
                                            <button class="btn btn-red btn-block">{{ trans('common.apply_now_button') }}</button>
                                        </a>

                                        <a href="/{{App::getLocale()}}/{{$vacancy['company']['permalink']}}">
                                            <button class="btn dark-button btn-block">{{trans('common.company_page_button')}}</button>
                                        </a>


                                    @endif

                                    <p class="vacancy-share-job text-center text-uppercase red hidden-lg hidden-md hidden-xs hidden-sm">
                                        {{ trans('common.share_job') }}</p>

                                    <div class="text-center job-social-share">
                                        <h5 class="share-company text-uppercase red">{{ trans('common.share_job') }}</h5>
                                        <ul class="soc soc-violet">
                                            <li><a class="soc-linkedin" href="#"></a></li>
                                            <li><a class="soc-facebook" href="#"></a></li>
                                            <li><a class="soc-twitter" href="#"></a></li>

                                            <li><a class="" href="#"><i class="fa fa-envelope"></i></a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach


            </div>


        </div>
    </div>

    <?php $now = new \DateTime();
    ?>

    @if(!isset($_COOKIE['modal-san-valentino']) && $now->format("d-m-Y")=="14-02-2016")
        <?php
        setcookie("modal-san-valentino", 1, 36000000000);
        ?>
        <div id="san-valentino-modal" class="modal fade" role="dialog" data-color="red" onclick="">
            <div style="width:100%;cursor:pointer;margin:0 auto" class="modal-dialog">
                <div id="san-valentino-modal-content" class="modal-content san-valentino">
                    @if(App::getLocale()=="it")
                        <img src="/img/san_valentino_it.png" width="100%">
                    @else
                        <img src="/img/san_valentino_eng.png" width="100%">
                    @endif

                </div>
            </div>
        </div>


    @endif

@endsection

@section('page-scripts')
    <script type="text/javascript" src="/js/pages/jobs.js"></script>



    <script>

        JobsPage.init();
        $(document.ready(function () {
            fbq('track', 'Search');

        }));
    </script>
@endsection