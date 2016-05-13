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


            <!-- Begin Register Modal !-->
            <div id="register-container" >

                <div style=" margin: 0 auto; max-width: 500px;" class="col-xs-offset-1">

                    <div class="signup">


                        <h4 style="margin-bottom: 20px; font-size: 23px; color: white;"
                            class="title-login">{{trans('common.register_manual_text')}}</h4>

                        <h6 style="color: white; margin-bottom: 20px; font-size: 15px;">{{trans('common.signup_manually_desc')}}</h6>

                        <div class="social-row center">
                            <a data-registrationMode="reg" data-loading-text="{{ trans('common.loggin_in') }}"
                               style="margin-bottom: 15px;  margin-right: 50px;"
                               data-href="/auth/facebook"
                               class="btn  btn-large row-space-1 btn-big btn-facebook social-login col-md-7 col-xs-16">
                                {{trans('common.register_facebook_button')}}
                            </a>

                            <a data-registrationMode="reg" data-loading-text="{{ trans('common.loggin_in') }}"
                               style="margin-bottom: 15px;"
                               data-href="/auth/linkedin"
                               class="btn  btn-large row-space-1 btn-big btn-linkedIn social-login col-md-7 col-xs-16">
                                {{trans('common.register_linkedin_button')}}
                            </a>
                        </div>


                        <p style="margin-bottom: 20px; color: white; text-align: center;"
                           class="col-centered text-center hidden-xs">{{trans('common.or_manual')}}</p>

                        <form autocomplete="off" method="post" id="registration-form-modal">
                            <div class="row">
                                <div class="col col-md-8">
                                    <div class="form-group">
                                        <input autocomplete="name" type="text"
                                               class="form-control decorative-input inspectletIgnore" id="name"
                                               name="name"
                                               placeholder="{{trans('form.name')}}" required>
                                    </div>
                                </div>
                                <div class="col col-md-8">
                                    <div class="form-group">
                                        <input autocomplete="off" type="text"
                                               class="form-control decorative-input inspectletIgnore" id="last_name"
                                               name="familyName"
                                               placeholder="{{trans('form.last_name')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-16">
                                    <div class="form-group">
                                        <input autocomplete="email" type="email"
                                               class="form-control decorative-input inspectletIgnore"
                                               id="exampleInputEmail1"
                                               name="email" placeholder="{{trans('form.email')}}" required>
                                    </div>
                                </div>

                                <div class="col col-md-16">
                                    <div class="form-group">
                                        <input autocomplete="new-password" type="password"
                                               class="form-control decorative-input inspectletIgnore"
                                               id="exampleInputPassword1"
                                               name="password" placeholder="Password" required>
                                    </div>
                                </div>

                                <div class="col col-md-16">
                                    <div class="form-group">
                                        <input autocomplete="off" type="password"
                                               class="form-control decorative-input inspectletIgnore"
                                               id="r-exampleInputPassword1"
                                               name="password-r" placeholder="{{trans('common.r-password')}}" required>
                                    </div>
                                </div>


                                <div class="col col-md-16">
                                    <div class="form-group">
                                        <button onclick="uploadCvStandard()" type="button"
                                                class="btn bordered-white-button btn-red btn-big load-cv-registration-std">{{trans('form.carica_cv_optional')}}</button>
                                        <input id="cvUrl" type="hidden" class="cvUrl" name="cvUrl">
                                    </div>
                                </div>
                                <input type="hidden" name="csrf_token"
                                       value="{{base64_encode(openssl_random_pseudo_bytes(16))}}"/>


                                <div class="col col-md-16">
                                    <div class="checkbox">
                                        <label style="color: white;">
                                            <input autocomplete="off" type="checkbox" required>
                                            {!! trans('form.autorizzazione') !!}
                                        </label>
                                    </div>
                                </div>
                                <div style="color: white;" class="col col-md-16 hide">
                                    {!!  trans('form.detail_registration_message') !!}
                                </div>
                                <div class="col col-md-16">
                                    <button style="margin-top: 10px;"
                                            data-loading-text="{{trans('common.signin_up_register')}}" type="submit"
                                            class="btn dark-button btn-big btn-block register-form-button">{{trans('common.sign_in_button')}}</button>
                                </div>

                                <div class="col col-md-16">
                                    <a href="javascript:history.back()" type="button"
                                            class="btn btn-red btn-block btn-big bordered-white-button margin-top-15">{{trans('common.back')}}</a>
                                </div>

                                <div class="col col-md-16 message">

                                </div>
                                <div class="col col-md-16" style="display: none;" id="registration-success">
                                    {{trans('common.registration_success')}}
                                </div>
                                <div class="col col-md-16" style="display: none;" id="registration-error">

                                </div>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
            <!-- End Register Modal !-->

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