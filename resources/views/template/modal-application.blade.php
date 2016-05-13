<div id="application-modal" class="modal fade" role="dialog" data-color="red">

    <div class="modal-dialog" style="padding-top:30px;">
        <a href="#" class="close-modal hidden-md hidden-lg"><i class="fa fa-times"></i></a>
        <div class="modal-content">
            <div class="container-fluid">
                <div class="row">
                    <a data-behavior="modal-close" class="close-modal hidden-xs" href="#">X</a>
                    <div class="col col-md-16 text-center">
                        <img src="/img/logo_white.png" class="logo-modal">
                    </div>
                    <div class="col col-md-16 ">
                        <div class="application-content">

                            <div class="row">

                                <div class="col col-md-8 modal-column ">
                                    <h3 class="title-modal">{{ trans('common.appl_title_main') }}</h3>

                                    <p>{{trans('common.appl_title_desc')}}</p>
                                    <span class="dark-label vacancy-name fadeIn animated">{{$vacancy["name"]}}</span>

                                    <p>{{trans('common.appl_title_desc_2')}}</p>
                                    <span class="dark-label company-name fadeIn animated">{{$company["name"]}}</span>
                                </div>
                                @if(!Auth::check())
                                    <div class="col col-md-8 text-center modal-column border-left not-logged-application "
                                         id="apply_phase_1">
                                       @if(isset($vacancy["requested_languages"], $vacancy["requested_languages"][0], $vacancy["requested_languages"][0]["system_language"]["name"]) && strtolower($vacancy["requested_languages"][0]["system_language"]["name"]) != "italian")
                                        <p class="divider">Only applications in {{$vacancy["requested_languages"][0]["system_language"]["name"]}} will be considered</p>
                                        @endif



                                           <div class="row">
                                            <div class="col col-md-16 col-md-offset-1">


                                                <button class="btn dark-button upload-cv-manual btn-block btn-big" onclick="CVButtonApply()" id="uploadCvFileInput">
                                                    <i class='fa fa-file-text-o icon-button'></i> {{trans('common.appl_title_btn_1')}}
                                                </button>


                                                <button data-social="Facebook" type="button" data-loading-text="{{ trans('common.loggin_in') }}"
                                                   data-href="/auth/facebook"
                                                   class="btn icon-btn btn-block btn-large row-space-1 btn-big social-apply btn-facebook">
                                                    <i style="margin-right: 10px" class="fa fa-facebook fa-lg"></i>
                                                    {{trans('common.apply_facebook_button')}}
                                                </button>

                                                <button data-social="LinkedIn" style="margin-bottom: 20px;" type="button" data-loading-text="{{ trans('common.loggin_in') }}"
                                                   data-href="/auth/linkedin"
                                                   class="btn icon-btn btn-block btn-large row-space-1 btn-big social-apply btn-linkedIn">
                                                    <i style="margin-right: 10px" class="fa fa-linkedin fa-lg"></i>
                                                    {{trans('common.apply_linkedin_button')}}
                                                </button>

                                                <h5 style="color: white; margin-bottom: 15px;">{{trans('common.advise_already_register_or_manual')}}</h5>

                                                <button class="btn white-button login-button btn-big btn-block">{{trans('common.already-registered')}}</button>

                                            </div>



                                            <div class="col col-md-16">
                                                <p class="privacy">{!! trans('common.privacy') !!}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col col-md-8 text-center modal-column logged-application"
                                         id="apply_phase_logged">
                                        <div class="row">
                                            <div class="text-center">



                                                <?php


                                                $count = 0;
                                                foreach (\Illuminate\Support\Facades\Auth::user()->attachments as $key => $value) {
                                                    if ($value ['active'] == true) {
                                                        $count++;
                                                    }
                                                }
                                                ?>
                                                @if($count>0)
                                                    <p class="title-modal-cvl">{{trans('common.appl_title_attachments')}}</p>
                                                    @foreach(\Illuminate\Support\Facades\Auth::user()->attachments as $i=>$attachment)
                                                        @if($attachment['active']==true)
                                                            <div class="row text-left" style="margin-top:15px">
                                                                <div class="col col-md-1">
                                                                    <input type="radio" id="radio_{{$i}}"
                                                                           name="attachment"
                                                                           value="{{$attachment['id']}}"/>

                                                                </div>
                                                                <div class="col col-md-12">
                                                                    <label for="radio_{{$i}}">{{$attachment['name']}}</label>
                                                                </div>
                                                                <div class="col col-md-2">
                                                                    <a target="_blank" href="{{$attachment['link']}}">
                                                                        <button class="btn dark-button"><i
                                                                                    class="fa fa-download"></i></button>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                        @endif
                                                    @endforeach

                                                @else
                                                    <p class="title-modal-cvl">{{trans('common.complete_upload_cv')}}</p>

                                                    <div rel="application-phase"
                                                         class="btn white-button btn-big load-file "
                                                         style="margin-top:30px">
                                                        {{trans('profile.upload_cv')}}
                                                    </div>
                                                    <input type="hidden" value="" id="attachment_id" name="attachment">
                                                @endif
                                                    <p class="title-modal-cvl">{{trans('common.appl_title_right_logged')}}</p>


                                                    <button style="margin-top: 20px;"
                                                        class="application-coverletter btn white-button btn-big">{{trans('common.upload_coverletter')}}</button>
                                                <p style="display: none;"
                                                   class="title-modal-cvl-done">{{trans('common.appl_title_right_logged_done')}}</p>



                                            </div>

                                        </div>
                                    </div>
                                @endif

                                <div style="display: none;" class="col col-md-8 text-center modal-column logged-application"
                                     id="apply_phase_social_apply">
                                    <div class="row">
                                        <div class="text-center">
                                            <p class="title-modal-cvl">{!! trans('common.appl_title_right_social_apply') !!}</p>

                                            <input style="" class="decorative-input application-email"
                                                   placeholder="{{trans('form.email')}}" id="email" name="email" type="email" required>
                                           <div rel="application-phase"
                                                     class="btn dark-button btn-big load-file "
                                                     style="margin-top:30px">
                                                    {{trans('profile.upload_cv')}}
                                                </div>
                                                <input type="hidden" value="" id="attachment_id" name="attachment">

                                            <label style="font-size: 12px; font-weight:normal!important; color: white;"
                                                   class="margin-top-20"
                                                   for="checkboxAuthTos">
                                                <input style="margin-right: 5px;" required class="" value="0"
                                                       name="checkboxAuthTos"
                                                       type="checkbox" checked>{!! trans('common.tos')  !!} </label>


                                            <p style="display: none;"
                                               class="title-modal-cvl-done">{{trans('common.appl_title_right_logged_done')}}</p>

                                        </div>

                                    </div>
                                </div>



                                <div style="display: none;" class="col col-md-8 text-center modal-column border-left"
                                     id="apply_phase_2">
                                    <div class="row">

                                        <div class="col col-md-14 col-md-offset-1">
                                            <div
                                                    class="upload-way animated fadeIn col-centered margin-top-20">
                                                <div class="drag-space hidden-xs">{{trans('common.application_cv')}}</div>

                                                <div class="clear" style="margin-top: 10px">

                                                <span style="color: white;"
                                                      class="cmp_appl_drag_cv col-centered hidden-xs">{{trans('common.or')}}</span>

                                                    <div class="clear" style="margin-top: 10px">


                                                        <div style="height: 10px;" class="clear"></div>

                                                        <input onclick="hideAlerts()" data-show-remove="false"
                                                               data-show-preview="false"
                                                               data-button-label-class="ok"
                                                               data-browse-label="{{trans('common.upload_cv')}}"
                                                               data-show-caption="false" type="file"
                                                               data-browse-class="btn btn-md dark-button upload-cv-manual btn-block"
                                                               data-size="xs" data-style="slide-up"
                                                               class="upload-cv-manual">

                                                    </div>
                                                    <div class="clear" style="height : 25px"></div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="display: none;" class="col col-md-8 text-center modal-column"
                                     id="apply_phase_3">
                                    <div class="row">

                                        <div class="text-center">
                                            <p style="margin-top: 0; font-size: 16px;"
                                               class="title-modal">{{trans('common.verify_mail')}}</p>

                                            <input style="" class="decorative-input application-email"
                                                   placeholder="{{trans('form.email')}}" id="email" name="email" type="email" required>
                                            <input style="" class="decorative-input application-name"
                                                   placeholder="{{trans('form.name')}}" id="name" name="name" type="text" required>
                                            <input style="" class="decorative-input application-surname"
                                                   placeholder="{{trans('form.last_name')}}" id="surname" name="surname" type="text" required>
                                            <input style="" class="decorative-input application-password"
                                                   placeholder="Password" id="password" name="password" type="password" required>


                                        @if(App::getLocale()=="it")
                                                <div class="row hide">
                                                    <div class="col col-md-16">
                                                        <div class="form-group">
                                                            <input type="text" class="decorative-input datepicker"
                                                                   id="birthdate_parsing"
                                                                   name="config[profile][birthdate]"
                                                                   placeholder="{{trans('form.birthdate')}}" required>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif


                                            <label style="font-size: 12px; font-weight:normal!important; color: white;"
                                                   class="margin-top-20"
                                                   for="checkboxAuthTos">
                                                <input style="margin-right: 5px;" required class="" value="0"
                                                       name="checkboxAuthTos"
                                                       type="checkbox" id="checkboxAuthTos" checked>{!! trans('common.tos')  !!} </label>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="text-center">

                                            <!-- <button style="margin-top: 20px;"
                                                    class="application-video btn white-button btn-big">{{trans('common.upload_video')}}</button>!-->




                                            @if(!empty(\Illuminate\Support\Facades\Auth::user()->attachments))

                                                @foreach(\Illuminate\Support\Facades\Auth::user()->attachments as $i=>$attachment)
                                                    @if($attachment['active']==true)
                                                        <input type="radio" id="radio_{{$i}}" name="attachment"
                                                               value="{{$attachment['id']}}">
                                                        <label for="radio_{{$i}}">{{$attachment['name']}}</label>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <button style="margin-top: 20px;"
                                                    class="application-coverletter btn white-button btn-big">{{trans('common.upload_coverletter')}}</button>
                                            <p style="display: none;"
                                               class="title-modal-cvl-done">{{trans('common.appl_title_right_logged_done')}}</p>



                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div style="display: none;" class="alert alert-danger application-error animated fadeIn"
                                 role="alert"></div>

                            @if(!Auth::check())


                            @else
                                <div onclick="hideAlerts(this)"
                                     class="col col-md-16 text-center bordered-top-white application-div-button">

                                    @if(isset($redirectUrl) && strlen($redirectUrl)> 1)
                                    <h4 style="color: white; margin-bottom: 15px;">{{trans('common.vacancy_redirect_advise')}}</h4>
                                    @endif
                                    <button data-size="l" data-style="zoom-in" type="submit" style="font-size:21px"
                                            class="btn dark-button application-button ladda-button"><span class="ladda-label">{{trans('common.apply_now_button')}}</span></button>
                                </div>
                            @endif
                            <div style="display: none;" onclick="hideAlerts(this)"
                                 class="col col-md-16 text-center bordered-top-white application-div-button">
                                @if(isset($redirectUrl) && strlen($redirectUrl)> 1)
                                    <h4 style="color: white; margin-bottom: 15px;">{{trans('common.vacancy_redirect_advise')}}</h4>
                                @endif
                                    <button data-size="l" data-style="zoom-in" style="font-size:21px"
                                        class="btn dark-button application-button ladda-button"><span class="ladda-label">{{trans('common.apply_now_button')}}</span></button>
                            </div>

                        </div>

                        <div style="display: none;" class="application-parsing-animation text-center animated fadeIn">
                            <img style="max-width: 350px; max-height: 350px;" class="" src="/img/analyzing.gif">
                            <div class="clear" style="height: 30px"></div>
                            <div class="col col-md-16 text-center bordered-top-white">
                                <span style="font-size: 27px;font-weight: 200; color: white;">{{ trans('common.analyzing_cv') }}</span>
                            </div>
                        </div>


                        <div style="display: none;" class="register-form">
                            <form autocomplete="off" method="post" id="registration-form">
                                <p class="fail-cv-analysis-msg" style="color: white; margin-bottom: 20px; font-size: 17px; display: none;">{!! trans('common.signup_manually_desc_fail') !!}</p>
                                <h6 class="standard-reg-msg" style="color: white; margin-bottom: 20px; font-size: 14px;">{{trans('common.signup_manually_desc')}}</h6>

                                <div class="row">
                                    <div class="col col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control decorative-input inspectletIgnore"
                                                   id="name"
                                                   name="name"
                                                   placeholder="{{trans('form.name')}}" required>
                                        </div>
                                    </div>
                                    <div class="col col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control decorative-input inspectletIgnore"
                                                   id="last_name"
                                                   name="familyName"
                                                   placeholder="{{trans('form.last_name')}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-md-16">
                                        <div class="form-group">
                                            <input autocomplete="off" type="email"
                                                   class="form-control decorative-input inspectletIgnore"
                                                   id="exampleInputEmail1"
                                                   name="email" placeholder="{{trans('form.email')}}" required>
                                        </div>
                                    </div>

                                    <div class="col col-md-16">
                                        <div class="form-group">
                                            <input autocomplete="off" type="password"
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
                                            <button class="load-cv-registration  btn bordered-white-button btn-red btn-big">{{trans('form.carica_cv')}}</button>
                                        </div>
                                    </div>


                                    <div class="col col-md-16">
                                        <div class="checkbox">
                                            <label style="color: white;">
                                                <input type="checkbox" required>{!! trans('form.autorizzazione') !!}
                                            </label>
                                        </div>
                                    </div>
                                    <div style="color: white; margin-left: 20px;" class="col col-md-16">
                                        {!!trans('form.detail_message')!!}
                                    </div>

                                    <div class="col col-md-16">
                                        <button data-loading-text="{{ trans('common.signin_up')}}"
                                                style="margin-left:0px;margin-top:25px" type="submit"
                                                class="btn dark-button btn-big btn-block register-button-apply">{{trans('form.registrati')}}</button>

                                    </div>


                                </div>


                            </form>


                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<input id="error-apply" type="hidden" value="{!! trans('common.unable_signup') !!}">