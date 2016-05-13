@if(!Auth::check())




    @if($route=="are-you-company")

        <button class="btn btn-red header-menu-btn-1 login-button ">
            <span>{{ trans('common.login_button_company') }}</span>
        </button>
        <a href="/register/company">
            <button class="btn dark-button header-menu-btn-2">
                <span>{{ trans('are-you-company.registrati_gratuitamente_2') }}</span>
            </button>
        </a>
    @else
        <div class="pull-right" style="margin-right: 20px; margin-top: 10px;">
        <button class="btn btn-red header-menu-btn-1 login-button " >
            <span>{{ trans('common.login_button') }}</span>
        </button>
            <button style="border: 0!important;" data-type="REGISTER" class="btn dark-button header-menu-btn-2 login-button">
                <span>{{ trans('common.sign_in_button') }}</span>
            </button>
        </div>
        @endif


        @else
        <?php $user = Auth::user(); ?>
                <!-- BEGIN USER IMAGE + NAME -->
        <div style="margin-top: 10px;" class="dropdown dropdown-user dropdown-dark">

            <a style="" href="/user" class="no-before">

                <?php if($user->type=="USER"){ ?>

                @if($user->avatar!="")
                <img width="211" height="211" alt="User profile placeholder" class="img-circle user-image"
                     src="{{$user->avatar}}"/>
                @else
                        <img data-placement="bottom" data-toggle="popover"
                             title="{{trans('common.logged_auto')}}"
                             data-content="{{str_replace("%e",Auth::user()->email,trans('common.logged_auto_desc'))}}"  width="211" height="211" alt="User profile placeholder" class="img-circle user-image auto-login-popover"
                             src="/img/avatar.png"/>
                    @endif
                <?php }else{ ?>

                    @if($user->company['logo_small']!="")
                        <img class="auto-login-popover img-circle" data-placement="bottom" data-toggle="popover"
                             title="{{trans('common.logged_auto')}}"
                             data-content="{{str_replace("%e",Auth::user()->email,trans('common.logged_auto_desc'))}}" src="/img/placeholder-profile.png" height="30">

                    @else
                    <img class="auto-login-popover img-circle" data-placement="bottom" data-toggle="popover"
                         title="{{trans('common.logged_auto')}}"
                         data-content="{{str_replace("%e",Auth::user()->email,trans('common.logged_auto_desc'))}}" src="/img/logo_placeholder.jpg" id="logo_src" height="40">
                    @endif

                    <?php } ?>

                <span style="margin-left: 5px; margin-top: 3px;" id="username"
                      class="username username-hide-on-mobile"><b>{{$user->first_name or ""}} {{$user->last_name or ""}} </b></span>

            </a>
            <a href="/user" class="btn btn-red header-menu-btn-1">
                <span>@if (Auth::user()->type == "USER")
                        {{  trans('common.profile') }}
                    @elseif (Auth::user()->type == "COMPANY")
                        HR Dashboard
                    @elseif (Auth::user()->type == "ANALYTICS")
                        HR Dashboard
                    @elseif (Auth::user()->type == "ADMINISTRATOR")
                        Meritocracy Admin
                    @endif</span>
            </a>

            <a onclick="logout()" class="btn dark-button header-menu-btn-1">
                <span>{{ trans('common.logout_button') }}</span>
            </a>
        </div>


    @endif