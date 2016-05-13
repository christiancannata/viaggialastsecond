<!-- Begin Login Modal -->
<div id="login-modal" class="modal red fade" role="dialog" data-color="red">
    <div style=" margin: 0 auto; max-width: 500px;" class="modal-dialog">



        <div id="login-modal-content" class="modal-content signup animated">


            <div style="color: white; font-size: 26px;" class="modal-header panel-header show-sm  text-center">
                <div class="text-center">
                    <img src="/img/logos/white-full-logo.png" class="logo-modal">
                </div>
                <a data-behavior="modal-close" class="close-modal hidden-md hidden-lg" href="#">X</a>
            </div>

            <h4 style="margin-bottom: 20px; font-size:19px; color: white;"
                class="col-md-16 title-login">{{trans('common.welcome_back')}}</h4>
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

                    <input type="hidden" name="csrf_token" value="{{base64_encode(openssl_random_pseudo_bytes(16))}}" />

                    <div class="clearfix row-space-2"><a
                                class="password-recovery-link pull-right">{{trans('common.lost_password_button')}}</a>
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
                        <a href="#"
                           class="btn btn-big dark-button btn-block margin-top-15 register-button">{{ trans('common.sign_in_button') }}</a>

                    @endif
                </form>


            </div>


        </div>
        <div style="display:none;" id="login-modal-content-progress" class="modal-content animated fadeIn">


            <div style="color: white; font-size: 26px;" class="modal-header panel-header show-sm  text-center">
                <div class="text-center">
                    <img src="/img/logos/white-full-logo.png" class="logo-modal">
                </div>
            </div>

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
</div>
<div id="login-progress-modal" class="modal red animated" role="dialog" data-color="red">
    <div style=" margin: 0 auto; max-width: 500px;" class="modal-dialog">

        <div id="login-modal-content" class="modal-content">


            <div style="color: white; font-size: 26px;" class="modal-header panel-header show-sm  text-center">
                <div class="text-center">
                    <img src="/img/logos/white-full-logo.png" class="logo-modal">
                </div>
                <a data-behavior="modal-close" class="close-modal hidden-md hidden-lg" href="#">X</a>
            </div>

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

<!-- Begin Recover Password Modal !-->
<div id="recover-password-modal" class="modal fade" role="dialog" data-color="red">
    <div style=" margin: 0 auto; max-width: 500px;" class="modal-dialog">

        <div id="login-modal-content" class="modal-content recover-password">


            <div style="color: white; font-size: 26px;" class="modal-header panel-header show-sm  text-center">
                <div class="text-center">
                    <img src="/img/logos/white-full-logo.png" class="logo-modal">
                </div>
                <a data-behavior="modal-close" class="close-modal hidden-md hidden-lg" href="#">X</a>
            </div>

            <div class="clear"></div>


            <form method="post" id="recover-password-form-modal">

                <h6 style="color: white; margin-bottom: 20px; font-size: 16px;">{{trans('common.recover_password_desc')}}</h6>


                <div class="row">
                    <div class="col col-md-16">
                        <div class="form-group">
                            <input type="email" class="form-control decorative-input inspectletIgnore"
                                   id="emailPassword"
                                   name="email" placeholder="{{trans('form.email')}}" required>
                        </div>
                    </div>


                    <div class="col col-md-16">
                        <button type="submit"
                                class="btn bordered-white-button btn-red btn-block btn-big">{{trans('common.recover_password')}}</button>
                    </div>

                    <div class="col col-md-16 message">

                    </div>


                </div>


            </form>
        </div>
    </div>
</div>
<!-- End Recover Password Modal !-->

<!-- Begin Register Modal !-->
<div id="register-modal" class="modal fade" role="dialog" data-color="red">

    <div style=" margin: 0 auto; max-width: 500px;" class="modal-dialog col-xs-offset-1">

        <div style="color: white; font-size: 26px;" class="modal-header panel-header show-sm  text-center">
            <div class="text-center">
                <img style="margin-bottom: 30px!important;" src="/img/logos/white-full-logo.png" class="logo-modal">
            </div>
            <a data-behavior="modal-close" class="close-modal hidden-md hidden-lg" href="#">X</a>
        </div>

        <div class="clear"></div>

        <div id="login-modal-content" class="modal-content signup">


            <h4 style="margin-bottom: 20px; font-size: 23px; color: white;"
                class="title-login">{{trans('common.register_manual_text')}}</h4>

            <h6 style="color: white; margin-bottom: 20px; font-size: 15px;">{{trans('common.signup_manually_desc')}}</h6>

            <div class="social-row center">
                <a data-registrationMode="reg" data-loading-text="{{ trans('common.loggin_in') }}" style="margin-bottom: 15px;  margin-right: 50px;"
                   data-href="/auth/facebook"
                   class="btn  btn-large row-space-1 btn-big btn-facebook social-login col-md-7 col-xs-16">
                    {{trans('common.register_facebook_button')}}
                </a>

                <a data-registrationMode="reg" data-loading-text="{{ trans('common.loggin_in') }}" style="margin-bottom: 15px;"
                   data-href="/auth/linkedin"
                   class="btn  btn-large row-space-1 btn-big btn-linkedIn social-login col-md-7 col-xs-16">
                    {{trans('common.register_linkedin_button')}}
                </a>
            </div>



            <p style="margin-bottom: 20px; color: white; text-align: center;"
               class="col-centered text-center hidden-xs">{{trans('common.or_manual')}}</p>


            <div class="modal-panel">




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
                                       class="form-control decorative-input inspectletIgnore" id="exampleInputEmail1"
                                       name="email" placeholder="{{trans('form.email')}}" required>
                            </div>
                        </div>

                        <div class="col col-md-16">
                            <div class="form-group">
                                <input autocomplete="new-password" type="password"
                                       class="form-control decorative-input inspectletIgnore" id="exampleInputPassword1"
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
                                <button onclick="uploadCvStandard()" type="button" class="btn bordered-white-button btn-red btn-big load-cv-registration-std">{{trans('form.carica_cv')}}</button>
                                <input id="cvUrl" type="hidden" class="cvUrl" name="cvUrl">
                            </div>
                        </div>
                        <input type="hidden" name="csrf_token" value="{{base64_encode(openssl_random_pseudo_bytes(16))}}" />


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
                            <button style="margin-top: 10px;" data-loading-text="{{trans('common.signin_up_register')}}" type="submit"
                                    class="btn dark-button btn-big btn-block register-btn-modal-std">{{trans('common.sign_in_button')}}</button>
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
</div>
<!-- End Register Modal !-->

<!-- Begin Contact Us Modal !-->
<div id="contact-us-company-modal" class="modal fade" role="dialog" data-color="red">

    <div class="modal-dialog">

        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-md-16 text-center">
                        <img src="/img/logos/white-full-logo.png" class="logo-modal">
                    </div>
                    <a data-behavior="modal-close" class="close-modal" href="#">X</a>
                    <div class="col col-md-16 ">
                        <div class="application-content">
                            <div class="row">

                                <div class="col col-md-9 modal-column">
                                    <p class="title-modal title-company-popup" style="color: white;
    margin-top: 0 !important;
    padding-top: 0;">{{trans('common.title_contact_popup')}}</p>
                                    <div style="color: white;" id="success-request-info" class="hide">
                                        <p>{{trans('common.success_contact_message')}}</p>
                                    </div>

                                </div>
                                <div class="col col-md-7 text-center modal-column">
                                    <div class="row">
                                        <div class="col col-md-16 col-md-offset-1">
                                            <form enctype="multipart/form-data" method="POST"
                                                  action="/contact/company"
                                                  class="form-horizontal" id="request-info-form">
                                                <div class="row">
                                                    <div class="form-group margin-top-20">
                                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

                                                        <div class="col-sm-16">
                                                            <input type="text" name="name"
                                                                   placeholder="{{trans('common.name')}}"
                                                                   class="form-control placeholder-no-fix name-request"
                                                                   id="name"
                                                                   autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group margin-top-20">
                                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

                                                        <div class="col-sm-16">
                                                            <input type="text" name="company"
                                                                   placeholder="{{trans('common.company')}}"
                                                                   class="form-control placeholder-no-fix company-request"
                                                                   id="company"
                                                                   autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group margin-top-20">
                                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

                                                        <div class="col-sm-16">

                                                            <input type="text" name="phone"
                                                                   placeholder="{{trans('common.telephone')}}"
                                                                   class="form-control placeholder-no-fix phone-request"
                                                                   id="phone"
                                                                   autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <button class="btn btn-big dark-button" type="submit"
                                                            data-loading-text="Invio richiesta in corso...">{{trans('common.send_request')}}
                                                    </button>

                                                    <div style="margin-top: 20px; display: none;"
                                                         class="alert alert-danger request-login animated fadeIn"
                                                         role="alert"></div>
                                                </div>

                                                <input type="hidden" name="lang" value="{{App::getLocale()}}"/>

                                            </form>
                                        </div>

                                    </div>
                                </div>


                            </div>


                        </div>


                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- End Contact Us Modal !-->
