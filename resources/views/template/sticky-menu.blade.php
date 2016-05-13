<div id="sticky" class="sticky container-fluid header-menu hidden-xs hidden-sm fadeIn" style="height: 50px;">

    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-16">
                <div class="col-md-3 col-sm-2 col-md-offset-1">
                    <div class="header-menu-meritocracy-logo">
                        <a href="/{{App::getLocale()}}/"><img src="/img/logos/white-full-logo.png"></a>
                    </div>
                </div>

                <div class="col-md-7 col-lg-7 col-sm-7"  style="position: relative; z-index:99999999999999;@if($route=="are-you-company") margin-right:33px; @else @if(Auth::check())  margin-right:27px; @endif @endif">
                    <ul class="nav navbar-nav">
                        <li><a href="/{{App::getLocale()}}/jobs">{{ trans('common.browse_job_button') }}</a></li>
                        <li><a  href="/{{App::getLocale()}}/technology">{{ trans('common.tech_button') }}</a></li>
                        <li><a  href="/{{App::getLocale()}}/manifesto">{{ trans('common.manifesto_button') }}</a></li>
                        @if($route=="are-you-company")
                            <li>   <a href="/">
                                    {{ trans('common.are_you_candidate') }}
                                </a></li>

                        @else
                            <li><a   href="/{{App::getLocale()}}/company">{{ trans('common.for_employers') }}</a></li>

                        @endif
                    </ul>


                </div>

                @include('template/sticky-header')

            </div>
        </div>
    </div>
</div>