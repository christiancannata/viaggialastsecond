@extends('template.empty')

@yield('header')
        <!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '1118004568212356');
    fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=1118004568212356&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->
@section('page-css')

    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/animate.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">

    @endsection


    @section('content')


        <div style="font-size: 26px;" class="text-center logo-header">
            <a href="/">
            <div class="text-center">
                <img src="/img/white-full-logo.png" class="logo-modal">
            </div>
            </a>
        </div>
        <div class="container" style="">



            <!-- Begin Login -->
            <div style="margin: 0 auto; max-width: 500px;" id="login-container">


                    <div id="login-modal-content" class="signup">



                        <h4 style="margin-bottom: 20px; font-size:19px; color: white;"
                            class="col-md-16 title-login">{{trans('common.welcome_back_login_only')}}</h4>
                        <div class="panel-body col-md-16">


                            <a data-loading-text="{{ trans('common.loggin_in') }}"
                               data-href="/auth/facebook"
                               class="btn icon-btn btn-block btn-large row-space-1 btn-big btn-facebook social-login margin-bottom-20">
                                <i style="margin-right: 10px" class="fa fa-facebook fa-lg"></i>
                                {{trans('common.login_facebook_button')}}
                            </a>

                            <a data-loading-text="{{ trans('common.loggin_in') }}"
                               data-href="/auth/linkedin"
                               class="btn icon-btn btn-block btn-large row-space-1 btn-big btn-linkedIn social-login margin-bottom-20">
                                <i style="margin-right: 10px" class="fa fa-linkedin fa-lg"></i>
                                {{trans('common.login_linkedin_button')}}
                            </a>

                            <p style="margin-bottom: 20px; color: white; text-align: center;"
                               class="col-centered text-center hidden-xs">{{trans('common.or_use_meritocracy')}}</p>


                            <form id="login-form" method="post" data-action="Signin" class="signin-form login-form"
                                  action="/login"
                                  accept-charset="UTF-8">


                                <div class="control-group row-space-1">
                                    <input autocomplete="username" title="Please type a valid email address" type="email"
                                           placeholder="{{trans('common.email_address')}}" name="email" id="email"
                                           class="decorative-input inspectletIgnore" required>
                                </div>
                                <div class="control-group row-space-2">
                                    <input autocomplete="current-password" title="Please type at least 6 characters"
                                           type="password"
                                           placeholder="Password" name="password" id="password"
                                           class="decorative-input" required>
                                </div>

                                <input type="hidden" name="csrf_token"
                                       value="{{base64_encode(openssl_random_pseudo_bytes(16))}}"/>

                                <div class="clearfix row-space-2"><a href="/password/recovery"
                                            class=" pull-right">{{trans('common.lost_password_button')}}</a>
                                </div>

                                <div class="alert alert-info error-login animated fadeIn hide"
                                     role="alert"></div>

                                <div class="clear" style="margin-bottom: 20px"></div>
                                <button data-loading-text="{{ trans('common.loggin_in') }}" type="submit" id="user-login-btn"
                                        class="btn btn-red btn-block btn-big bordered-white-button"
                                        autocomplete="off">{{ trans('common.login_button') }}</button>

                                <p style="margin-top: 20px; color: white; text-align: center;"
                                   class="col-centered text-center">{{trans('common.no_account_')}}</p>

                                @if(isset($route) && $route == "are-you-company")
                                    <a target="_blank" href="https://meritocracy.is/register/company"
                                       class="btn btn-big dark-button btn-block margin-top-15 ">{{ trans('common.sign_in_button') }}</a>
                                @else
                                    <a href="/register/user"
                                       class="btn btn-big dark-button btn-block margin-top-15">{{ trans('common.sign_in_button') }}</a>

                                @endif
                            </form>


                        </div>


                    </div>
                    <div style="display:none;" id="login-modal-content-progress" class="modal-content animated fadeIn">


                        <div class="clear" style="height: 50px"></div>

                        <div id="spin-login-credentials"></div>

                        <div class="clear" style="height: 70px"></div>
                        <div class="col col-md-16 text-center">
                            <span style="font-size: 27px;font-weight: 200; color: white;">{{ trans('common.loggin_in') }}</span>
                            <div style="height: 20px;" class="clearfix"></div>
                            <span class="email" style="font-size: 16px;font-weight: 200; color: white;"></span>

                        </div>


                    </div>
                </div>



            <div style="display: none;" id="login-progress-modal" >
                <div style=" margin: 0 auto; max-width: 500px;" class="modal-dialog">

                    <div id="login-modal-content" class="modal-content">




                        <div class="clear" style="height: 50px"></div>

                        <div id="spin-login-credentials"></div>

                        <div class="clear" style="height: 70px"></div>
                        <div class="col col-md-16 text-center">
                            <span style="font-size: 27px;font-weight: 200; color: white;">{{ trans('common.loggin_in_auto') }}</span>
                            <div style="height: 20px;" class="clearfix"></div>
                            <span class="email" style="font-size: 16px;font-weight: 200; color: white;"></span>

                        </div>


                    </div>

                </div>
            </div>
            <!-- End Login Modal -->




            <div style="height: 30px;" class="clear"></div>
</div>



@endsection

@section('page-scripts')


        <script type="text/javascript" src="/js/jsonGenerator.js"></script>
        <script type="text/javascript" src="/js/utils/timezone.js"></script>
        <script type="text/javascript" src="/js/strength.min.js"></script>
        <script type="text/javascript" src="/js/spin.min.js"></script>
        <script type="text/javascript" src="{{auto_version("/js/main.js")}}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <script type="text/javascript" src="{{auto_version("/js/meritocracy-framework.js")}}"></script>


        <script>

            $(document).ready(function(){
                Meritocracy.init();
            });
            try {
                var tz = jstz.determine(); document.cookie = "timezone=" + tz.name();
            } catch (ee) {}

            var OneSignal = OneSignal || [];

            OneSignal.push(["init", {
                // Your other init options here
                promptOptions: {
                    showCredit: false, // Hide Powered by OneSignal
                    actionMessage: trans('notif_title'),
                    exampleNotificationTitleDesktop: trans('notif_title_2'),
                    exampleNotificationMessageDesktop: trans('notif_desktop'),
                    exampleNotificationTitleMobile: trans('notif_title_2'),
                    exampleNotificationMessageMobile: trans('notif_mobile'),
                    exampleNotificationCaption: trans('notif_unsub'),
                    acceptButtonText: trans('continua').toUpperCase(),
                    cancelButtonText: trans('cancella').toUpperCase()
                },
                welcomeNotification: {
                    disable: true
                },
                path: "/",
                appId: "464434c7-dadc-4edb-8a80-fb73dcb5040d",
                safari_web_id: "web.onesignal.auto.650c091f-37ea-4fe0-8793-2961481353d2",
                autoRegister: false
            }]);



        </script>



           <script src="https://cdn.ravenjs.com/3.0.3/console/raven.min.js"></script>
            <script language="javascript">
                if (!$('html').is('.lt-ie7, .lt-ie8, .lt-ie9')) {
                    /*** Raven for Javascript Exception Handlers ***/
                    Raven.config('https://3c874071c7ca47bbb5767984f485cb7c@app.getsentry.com/43384', {
                        release:  '<?php echo gitVersion() ?>',
                        fetchContext: true,
                        includePaths: [/https?:\/\/meritocracy\.is/, /http?:\/\/beta\.meritocracy\.is/]

                    }).install();

                    Raven.setUserContext({
                        email: '{{Auth::check() && Auth::user()->email or "" }}',
                        id: '{{Auth::check() && Auth::user()->id or "" }}'
                    });

                } else {
                    alert("Your browser is out-of-date and your experience with Meritocracy may be slower or unexpected");
                }


            </script>

        <input value="<?php if(\Illuminate\Support\Facades\Input::get("redirectLink")){ ?>{{\Illuminate\Support\Facades\Input::get("redirectLink")}}<?php } ?>" type="hidden" id="redirectLogin">

        <div id="fb-root"></div>
        <script type="text/javascript" src="//api.filestackapi.com/filestack.js"></script>

    @endsection