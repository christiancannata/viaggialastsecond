<body class="{{ $customClass or 'background-image' }} {{ isset($route) ? $route : '' }}">

<header class="cd-header hidden-md hidden-lg">
    <div class="cd-logo"><a href="/{{App::getLocale()}}/"><img alt="Logo" src="/img/logos/logo_small_web.svg"></a></div>
    <div class="col col-xs-16 col-xs-offset-3" style="padding-top:15px">

    @if(Auth::check())
           <?php $user = Auth::user(); ?>


                    <!-- BEGIN USER IMAGE + NAME -->
            <a class="no-before" href="/user">

                <i class="fa fa-user" style="color: white;"></i>
                    <span style="margin-left: 5px; color: white;" id="username"
                          class="username username-hide-on-mobile">{{$user->first_name}}</span>

            </a>
            <a class="btn " href="/user"
               style="padding:4px !important;display: inline;background:#F04D52;margin-left:15px; text-transform: none;">
                @if (Auth::user()->type == "USER")
                    {{  trans('common.profile') }}
                @elseif (Auth::user()->type == "COMPANY")
                    HR
                @elseif (Auth::user()->type == "ANALYTICS")
                    HR Admin
                @elseif (Auth::user()->type == "ADMINISTRATOR")
                    Meritocracy Admin
                @endif
            </a>
            <a onclick="logout()" class="btn "
               style="padding:4px !important;display: inline;background:#F04D52;margin-left:15px; text-transform: none;">
                {{ trans('common.logout_button') }}</a>


            @else

                <a class="btn" href="/register/user"
                   style="padding:4px !important;display: inline;background:#F04D52;margin-left:15px; text-transform: none;">{{trans("common.sign_in_button")}}
                </a>
                <a href="/login" class="btn"
                   style="padding:4px !important;display: inline;background:#F04D52;margin-left:15px; text-transform: none;">
                    {{ trans('common.login_button') }}</a>
            @endif
        </div>
        <a class="cd-primary-nav-trigger">
            <span class="cd-menu-text">Menu</span><span class="cd-menu-icon"></span>
        </a> <!-- cd-primary-nav-trigger -->

</header>
<nav class="hidden-lg">

    <ul class="cd-primary-nav">
        <li><a href="/{{App::getLocale()}}/">Home</a></li>
        <li><a href="/{{App::getLocale()}}/jobs">{{ trans('common.browse_job_button') }}</a></li>

        <li><a href="/{{App::getLocale()}}/manifesto">{{ trans('common.manifesto_button') }}</a></li>

        <li><a href="/{{App::getLocale()}}/technology">{{ trans('common.tech_button') }}</a></li>
        <li><a href="/{{App::getLocale()}}/company">{{ trans('common.are_you_company_button') }}</a></li>

        <li><a data-type="REGISTER" href="#" class="login-button">{{trans('common.sign_in_button')}}</a></li>
        <li><a href="#" class="login-button">{{trans('common.login_button')}}</a></li>
    </ul>
</nav>


<div id="fullpage" @if($route=="are-you-company") style="height:1000px!important; @endif">


    <div class="section">


        <div class="container-fluid header-menu header-top-menu hidden-xs hidden-sm">
            <div class="container-fluid">
                <div class="row">
                    <div class="">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="header-menu-meritocracy-logo">
                                <a href="/{{App::getLocale()}}/">
                                    @if(isset($whiteLogo))
                                        <img style="margin-top: 5px!important" src="/img/logos/white-full-logo.png">
                                    @else
                                        <img src="/img/logos/black-full-logo.png">

                                    @endif
                                </a>

                            </div>
                        </div>

                        <div class="">
                            <ul class="nav navbar-nav">
                                <li><a @if($route=="jobs")class="active"
                                       @endif href="/{{App::getLocale()}}/jobs">{{ trans('common.browse_job_button') }}</a>
                                </li>
                                <li><a @if($route=="technology")class="active"
                                       @endif href="/{{App::getLocale()}}/technology">{{ trans('common.tech_button') }}</a>
                                </li>
                                <li><a @if($route=="manifesto")class="active"
                                       @endif href="/{{App::getLocale()}}/manifesto">{{ trans('common.manifesto_button') }}</a>
                                </li>
                                @if($route=="are-you-company")
                                    <li><a href="/">
                                            {{ trans('common.are_you_candidate') }}
                                        </a></li>

                                @else
                                    <li><a @if($route=="are-you-company")class="active"
                                           @endif href="/{{App::getLocale()}}/company">{{ trans('common.for_employers') }}</a>
                                    </li>

                                @endif

                            </ul>


                        </div>

                        <div style="margin-right: 50px;" class="pull-right">

                            @include('template/sticky-header')

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
