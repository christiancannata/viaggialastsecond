<div style="    z-index: 999999;" id="sticky" class="hidden-sm hidden-xs fadeIn">

    <div class="container-fluid sticky  header-menu company ">
        <div class="row">
            <div class="col col-md-16">
                <div class="col-md-2 col-md-offset-1">
                    <div class="header-menu-meritocracy-logo">
                        <a href="/{{App::getLocale()}}/"><img class="header-menu-meritocracy-logo-image" src="/img/logos/black-logo.png"></a>
                    </div>
                </div>


                <div class="col-md-8">
                    <a href="/{{App::getLocale()}}/{{$company["permalink"]}}"><h3 style="font-size:25px">{{$company["name"]}}</h3></a>
                </div>

                @include('template/sticky-header')

            </div>


        </div>
    </div>

    <div class="container-fluid sub-header-menu block-violet ">
        <div class="container">
            <div class="row">
                <div style="display: none;" class="block block-company stay-scroll col col-md-4">


                    <div class="row">
                        <div class="col-md-16 block-violet block-content">

                            @if (isset($company["address"]))
                                <div class="map" id="map-header-menu"></div>
                                <h4 class="content">{{ $company["city_plain_text"] }}</h4>

                                @endif


                                        <!--<div class="tag">
                    <h3 class="title">Tag</h3>

                </div>!-->
                                @if (isset($company["industry"]))
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.industry') }}</h3>
                                    <h3 class="content">{{$company["industry"]['name']}}</h3>
                                @endif

                                @if (isset($company["foundation_date"]))
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.foundation_date') }}</h3>
                                    <h3 class="content">{{$company["foundation_date"]}}</h3>
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

                <div class="col-md-11 col-md-offset-4 block-violet ">

                    <ul class="nav navbar-nav navbar-white">
                        <li><a href="#description">{{ trans('common.description') }}</a></li>
                        @if(isset($company['benefits']) && count($company['benefits'])>0)
                            <li><a href="#benefit">{{ trans('common.benefit') }}</a></li>
                        @endif
                    </ul>


                </div>

            </div>


        </div>


    </div>
</div>
</div>