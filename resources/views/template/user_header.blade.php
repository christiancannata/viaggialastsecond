
<!-- START HEADER -->
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="dark-violet">
            <div class="nav-wrapper">

                <ul class="left">
                    <li><h1 class="logo-wrapper"><a href="/{{App::getLocale()}}/" class="brand-logo darken-1">
                            <img src="/img/logos/white-full-logo.png"></a>
                            <span class="logo-text">Meritocracy</span></h1></li>
                </ul>
                <div class="header-search-wrapper hide-on-med-and-down">
                    <div class="row">
                        <form name="search" target="_blank" method="GET" action="/search">
                        <div class="col m10">
                            <i class="mdi-action-search"></i>
                            <input style="width:88%" type="text" name="key" class="header-search-input z-depth-2" placeholder="{{ trans('homepage.placeholder_search') }}"/>
                        </div>

                        <div class="col m2">
                            <button style="vertical-align: top; height: 39px;" name="action" type="submit" class="btn btn-red waves-effect waves-light ">{{trans('profile.vai')}}
                            </button>
                        </div>
                        </form>

                    </div>


                </div>
              <!--  <ul class="right hide-on-med-and-down">

                    <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light"><i class="mdi-social-notifications"></i></a>
                    </li>
                </ul>-->
            </div>
        </nav>
    </div>
    <!-- end header nav-->
</header>
<!-- END HEADER -->

