@extends('template.admin_layout')

@yield('header')

@section('page-css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css"
          rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

@endsection


@section("custom-js")

    <script type="text/javascript" src="{{auto_version("/js/profile.js")}}"></script>


    <!-- Begin INDEED conversion code -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var indeed_conversion_id = '5367084519431629';
        var indeed_conversion_label = '';
        /* ]]> */
    </script>
    <script type="text/javascript" src="//conv.indeed.com/pagead/conversion.js">
    </script>
    <noscript>
        <img height=1 width=1 border=0 src="//conv.indeed.com/pagead/conv/5367084519431629/?script=0">
    </noscript>
    <!-- End INDEED conversion code -->

@endsection
@section('content')

    <div id="profile-page" class="section">
        <!-- profile-page-header -->
        <div id="profile-page-header" class="card profile-header hide-on-small-only">

            <figure class="card-profile-image">
                @if($user['avatar']!="")
                    <img src="{{$user['avatar']}}" alt=""
                         class="circle z-depth-2 responsive-img activator avatar-image">

                @else
                    <img src="https://cdn0.vox-cdn.com/images/verge/default-avatar.v9899025.gif" alt=""
                         class="circle z-depth-2 responsive-img activator avatar-image">

                @endif
                <div class="modify-avatar"><i class="mdi-editor-mode-edit " style="color:black"></i></div>
            </figure>
            <div class="card-content ">
                <div class="row">
                    <div class="col s12 m4 l4 offset-m2 offset-l2">
                        <h4 class="card-title grey-text text-darken-4 center">
                            <a href="#" id="name" data-type="address" data-pk="{{$user['id']}}" class="editable"
                               data-title="Enter username">{{$user['first_name']}} {{$user['last_name']}}</a>
                        </h4>

                        @if($user['short_bio']!="")
                            <a href="#" id="short_bio" data-pk="{{$user['id']}}" class="medium-small grey-text editable"
                               data-title="Enter username">{{$user['short_bio']}}</a>
                        @else
                            {{--*/ $lastWork=end($user['work_experiences']) /*--}}

                            @if(is_array($lastWork))
                                <a href="#" id="short_bio" data-pk="{{$user['id']}}"
                                   class="medium-small grey-text editable"
                                   data-title="Enter username">{{$lastWork['role']}} {{ trans('profile.presso') }} {{$lastWork['company_plain_text']}}</a>
                            @else
                                <p class="medium-small grey-text">
                                    <i class="mdi-alert-error red-text tiny"></i>
                                    <a href="#" id="short_bio" data-pk="{{$user['id']}}"
                                       class="medium-small grey-text editable"
                                       data-title="Enter username">{{ trans('profile.aggiungi_prima_esperienze') }}</a>
                                </p>

                            @endif

                        @endif
                    </div>
                    <div class="col m2 center-align hide-on-small-only">
                        <h4 class="card-title grey-text text-darken-4"
                            id="contatore-work">{{count($user['work_experiences'])}}</h4>
                        <p class="medium-small grey-text">{{ trans('profile.esperienze_lavorative') }}</p>
                    </div>
                    <div class="col m2 center-align hide-on-small-only">
                        <h4 class="card-title grey-text text-darken-4"
                            id="contatore-education">{{count($user['educations'])}}</h4>
                        <p class="medium-small grey-text">{{ trans('profile.educations') }}</p>
                    </div>
                    <div class="col m2 center-align hide-on-small-only">
                        <h4 class="card-title grey-text text-darken-4"
                            id="contatore-lingue">{{count($user['languages'])}}</h4>
                        <p class="medium-small grey-text">{{ trans('profile.lingue_parlate') }}</p>
                    </div>

                </div>
            </div>


        </div>
        <!--/ profile-page-header -->


        <div class="row hide-on-med-and-up">
            <div class="col s12 center">
                @if($user['avatar']!="")
                    <img src="{{$user['avatar']}}" alt=""
                         class="circle z-depth-2 responsive-img activator avatar-image">

                @else
                    <img src="https://cdn0.vox-cdn.com/images/verge/default-avatar.v9899025.gif" alt=""
                         class="circle z-depth-2 responsive-img activator avatar-image">

                @endif
                <div class="modify-avatar"><i class="mdi-editor-mode-edit " style="color:black"></i></div>

            </div>

            <div class="col s12 m4 l4 offset-m2">
                <h4 class="card-title grey-text text-darken-4">
                    <a href="#" id="name" data-type="address" data-pk="{{$user['id']}}" class="editable"
                       data-title="Enter username">{{$user['first_name']}} {{$user['last_name']}}</a>
                </h4>
                {{--*/ $lastWork=end($user['work_experiences']) /*--}}

                @if(is_array($lastWork))
                    <p class="medium-small grey-text">{{$lastWork['role']}}
                        {{ trans('profile.presso') }} {{$lastWork['company_plain_text']}}</p>
                @else
                    <p class="medium-small grey-text">
                        <i class="mdi-alert-error red-text tiny"></i>
                        <i class="placeholder-text">{{ trans('profile.aggiungi_prima_esperienze') }}</i>
                    </p>

                @endif
            </div>
            <div class="col m2 center-align hide-on-small-only">
                <h4 class="card-title grey-text text-darken-4"
                    id="contatore-work">{{count($user['work_experiences'])}}</h4>
                <p class="medium-small grey-text">{{ trans('profile.esperienze_lavorative') }}</p>
            </div>
            <div class="col m2 center-align hide-on-small-only">
                <h4 class="card-title grey-text text-darken-4"
                    id="contatore-education">{{count($user['educations'])}}</h4>
                <p class="medium-small grey-text">{{ trans('profile.educations') }}</p>
            </div>
            <div class="col m2 center-align hide-on-small-only">
                <h4 class="card-title grey-text text-darken-4"
                    id="contatore-lingue">{{count($user['languages'])}}</h4>
                <p class="medium-small grey-text">{{ trans('profile.lingue_parlate') }}</p>
            </div>

        </div>


        <!-- profile-page-content -->
        <div id="profile-page-content" class="row">
            <!-- profile-page-sidebar-->
            <div id="profile-page-sidebar" class="col s12 m4">
                <!-- Profile About  -->
                <div class="card light-blue hide">
                    <div class="card-content white-text">
                        <span class="card-title">About Me!</span>
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient
                            because I require little markup to use effectively.</p>
                    </div>
                </div>
                <!-- Profile About  -->

                <!-- Profile About Details  -->
                <ul id="profile-page-about-details" class="collection z-depth-1">

                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i
                                        class="mdi-social-domain"></i>&nbsp;{{ trans('profile.vivi_a') }}</div>
                            <div class="col s8 grey-text text-darken-4 right-align">
                                <a style="font-size: 15px;float:right" id="city" name="city" data-name="city_plain_text"
                                   data-pk="{{$user['id']}}" class="editable">
                                    @if($user['city_plain_text']!="")
                                        {{$user['city_plain_text']}}
                                    @else
                                        {{ trans('profile.insert_city') }}
                                    @endif</a>
                            </div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i
                                        class="mdi-social-cake"></i>&nbsp;{{ trans('profile.data_nascita') }}</div>

                            <div class="col s8 grey-text text-darken-4 right-align">
                                <a style="font-size: 15px;float:right" id="birthdate" name="birthdate"
                                   data-name="birthdate"
                                   data-pk="{{$user['id']}}" data-type="combodate" class="editable">
                                    @if($user['birthdate']!="")
                                        {{--*/  $date=new \DateTime($user['birthdate']) /*--}}
                                        {{$date->format("d/m/Y")}}
                                    @else
                                        {{trans('profile.insert_date')}}
                                    @endif</a>
                            </div>


                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i
                                        class="mdi-hardware-phone-iphone "></i>&nbsp;{{ trans('profile.telefono') }}
                            </div>
                            <div class="col s8 grey-text text-darken-4 right-align">
                                <a style="font-size: 15px;" id="telefono" name="mobile_phone"
                                   data-name="mobile_phone" data-pk="{{$user['id']}}" class="editable">
                                    @if($user['mobile_phone']!="")
                                        {{$user['mobile_phone']}}
                                    @else
                                        {{trans('profile.inserisci_telefono')}}
                                    @endif</a>
                            </div>
                        </div>
                    </li>

                    <li class="collection-item">
                        <div class="row">
                            <div class="col s4 grey-text darken-1"><i
                                        class="mdi-communication-email  "></i>&nbsp;{{ trans('profile.email') }}</div>
                            <div class="col s8 grey-text text-darken-4 right-align">
                                <a style="font-size: 15px;" id="email" name="email"
                                   data-name="email" data-pk="{{$user['id']}}">
                                    {{$user['email']}}
                                </a>
                            </div>
                        </div>
                    </li>


                </ul>
                <!--/ Profile About Details  -->


                <!-- languages -->
                <ul id="task-card" class="collection z-depth-1">
                    <li class="collection-header red">
                        <h4 class="task-card-title">{{ trans('profile.candidature') }}</h4>
                    </li>

                    @foreach($user['applications'] as $application)

                        <li class="collection-item link-item">
                            <a href="/user/application/{{$application['id']}}">
                                <div class="row">
                                    <div class="col m2">
                                        <img width="50" src="{{$application['vacancy']['company']['logo_small']}}">

                                    </div>
                                    <div class="col m9">
                                    <span class="title"
                                          style="width:100%;vertical-align:top;display:inline;font-size:18px;font-weight: bold;">
                                @if(isset($application['vacancy']))
                                            {{$application['vacancy']['name']}}<br>

                                        @endif
                            </span>
                                        <p style="font-size:12px;margin-top:0px;"><i
                                                    class="mdi-communication-location-on"
                                                    style="font-size: 14px;"></i>
                                            {{$application['vacancy']['company']['name']}}
                                            | {{$application['vacancy']['company']['city_plain_text']}}<br>
                                            {{ trans('profile.candidatura_fatta') }}
                                            <b>{{date('d-m-Y', strtotime($application['created_at']))}}</b></p>

                                    </div>
                                </div>
                            </a>
                        </li>

                    @endforeach

                </ul>
                <!-- languages -->


            </div>
            <!-- profile-page-sidebar-->

            <!-- profile-page-wall -->
            <div id="profile-page-wall" class="col s12 m8">
                <!-- profile-page-wall-share -->
                <div id="profile-page-wall-share" class="row">
                    <div class="col s12">
                        <ul class="tabs tab-profile z-depth-1">
                            <li class="tab col s3">
                                <a class="waves-effect black-text waves-light active"
                                   href="#UpdateStatus">
                                    <i class="prefix fa fa-briefcase"></i>
                                    {{ trans('profile.esperienze_lavorative') }}</a>
                            </li>
                            <li class="tab col s3"><a class=" waves-effect black-text waves-light" href="#AddPhotos">
                                    <i class="prefix fa fa-graduation-cap"></i>{{ trans('profile.educations') }}</a>
                            </li>
                            <li class="tab col s3"><a class=" waves-effect black-text waves-light" href="#CreateAlbum">
                                    <i class="fa fa-language prefix"></i> {{ trans('profile.lingue') }}</a>
                            </li>
                        </ul>
                        <!-- Add Work Experiences-->
                        <div id="UpdateStatus" class="tab-content col s12 card">

                            <div class="card-content">
                                <div class="card-title">
                                    <span>{{trans('common.new_work_experience')}}</span>
                                </div>
                                <div class="card-description">
                                    <span class="grey-text">
                                    @if(!isset($user['work_experiences']) || count($user['work_experiences']) <= 0)
                                            {{trans('profile.no_work_experience')}}
                                        @elseif (isset($user['work_experiences']) && count($user['work_experiences']) === 1)
                                            {{trans('profile.one_work_experience')}}
                                        @elseif (isset($user['work_experiences']) && count($user['work_experiences']) > 1)
                                            {{str_replace("%c",count($user['work_experiences']),trans('profile.more_work_experiences'))}}
                                        @endif
                                    </span>
                                </div>


                            </div>
                            <div class="card-action">
                                <a class="btn waves-effect waves-light red show-tab">{{trans('profile.add')}}</a>
                            </div>

                            <form class="profile-form" id="work-experience-form" method="POST" action="#">

                                <div class="row">

                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-work"></i>
                                        <input id="role" aria-required="true" name="role" class="required"
                                               type="text"
                                               required>
                                        <input type="hidden" id="role_id" name="role_id"/>
                                        <label class="" for="role">{{ trans('wizard-application.ruolo') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-work"></i>

                                        <select id="job_function_first" required name="job_function">

                                            <option value="" disabled
                                                    selected>{{ trans('profile.scegli_job') }}</option>
                                            @foreach($jobFunctions as $function)
                                                <option value="{{$function['id']}}">{{$function['name']}}</option>
                                            @endforeach
                                        </select>

                                        <label for="job_function_first">{{ trans('wizard-application.job_function') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-store prefix"></i>
                                        <input type="hidden" id="azienda_id" name="azienda_id"/>
                                        <input id="azienda" aria-required="true" name="nome_azienda" type="text"
                                               class="required validate" required>
                                        <label for="azienda">{{ trans('wizard-application.nome_azienda') }}</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-store prefix"></i>

                                        <select name="industry">
                                            <option value="" disabled
                                                    selected>{{ trans('profile.scegli_industry') }}</option>
                                            @foreach($industries as $function)
                                                <option value="{{$function['id']}}">{{$function['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label for="job_function">{{ trans('wizard-application.industry') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="mdi-communication-location-on prefix"></i>
                                        <input type="hidden" name="work_city_id" id="work_city_id">
                                        <input id="luogo_lavoro" name="luogo_lavoro" type="text"
                                               class="required validate" required>
                                        <label for="luogo_lavoro">{{ trans('wizard-application.luogo_lavoro') }}</label>

                                    </div>
                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-event prefix"></i>
                                        <label for="data_inizio">{{ trans('wizard-application.data_inizio') }}</label>
                                        <input onkeydown="return false" aria-required="true" type="text"
                                               name="data_inizio" id="data_inizio"
                                               class="datepicker required" required>

                                    </div>

                                    <div class="input-field col s12 m6 data-fine-box">
                                        <i class="mdi-action-event prefix"></i>
                                        <label for="data_fine">{{ trans('wizard-application.data_fine') }}</label>
                                        <input onkeydown="return false" aria-required="true" type="text"
                                               name="data_fine" id="data_fine"
                                               class="datepicker required" required>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input  type="checkbox" name="lavoro_attuale" id="lavoro_attuale"/>
                                        <label style="margin-bottom: 20px;" for="lavoro_attuale">{{ trans('wizard-application.attualmente_lavoro_qui') }}</label>
                                    </div>

                                    <div class="input-field col s12 m12">
                                        <i class="mdi-communication-comment prefix"></i>
                                                <textarea id="comment" name="comment"
                                                          class="materialize-textarea"></textarea>
                                        <label for="comment">{{ trans('wizard-application.raccontaci_esperienza') }}</label>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col s12 m12 right-align">
                                        <!-- Dropdown Trigger -->
                                        <button name="action" type="submit"
                                                class="waves-effect waves-light btn add-work-experience red"><i
                                                    class="mdi-maps-rate-review left "></i>{{ trans('profile.aggiungi') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- Add Educations -->
                        <div id="AddPhotos" class="tab-content col s12 card">


                            <div class="card-content">
                                <div class="card-title">
                                    <span>{{trans('common.new_education')}}</span>
                                </div>
                                <div class="card-description">
                                    <span class="grey-text">
                                    @if(!isset($user['educations']) || count($user['educations']) <= 0)
                                            {{trans('profile.no_education')}}
                                        @elseif (isset($user['educations']) && count($user['educations']) === 1)
                                            {{trans('profile.one_education')}}
                                        @elseif (isset($user['educations']) && count($user['educations']) > 1)
                                            {{str_replace("%c",count($user['educations']),trans('profile.more_education'))}}
                                        @endif
                                    </span>
                                </div>


                            </div>
                            <div class="card-action">
                                <a class="btn waves-effect waves-light red show-tab">{{trans('profile.add')}}</a>
                            </div>

                            <form class="profile-form" id="education-form" method="POST" action="#">

                                <div class="row">

                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-account-balance"></i>

                                        <select required id="comment" name="titolo_studio">
                                            <option value="" disabled
                                                    selected>{{ trans('profile.titolo_studio') }}</option>
                                            @foreach($degrees as $function)
                                                <option value="{{$function['name']}}">{{$function['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label for="titolo_studio">{{ trans('wizard-application.titolo_studio') }}</label>
                                    </div>


                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-account-balance"></i>
                                        <input type="hidden" name="school_id" id="school_id">
                                        <input id="school" type="text" name="school" class="required" required>
                                        <label for="school">{{ trans('wizard-application.luogo_studio') }}</label>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <i class="prefix mdi-action-account-balance"></i>

                                        <select required id="education_id" name="education_id">
                                            <option value="" disabled
                                                    selected>{{ trans('profile.facolta') }}</option>
                                            @foreach($studyFields as $function)
                                                <option value="{{$function['id']}}">{{$function['name']}}</option>
                                            @endforeach
                                        </select>
                                        <label for="education_id">{{ trans('wizard-application.facolta') }}</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-event prefix"></i>
                                        <label for="data_inizio_education">{{ trans('wizard-application.data_inizio') }}</label>
                                        <input onkeydown="return false" type="text" name="data_inizio_education"
                                               id="data_inizio_education"
                                               class="datepicker required" required>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-event prefix"></i>
                                        <label for="data_fine_education">{{ trans('wizard-application.data_fine') }}</label>
                                        <input onkeydown="return false" type="text" name="data_fine_education"
                                               id="data_fine_education"
                                               class="datepicker required">

                                    </div>
                                    <div class="input-field col s12 m6">
                                        <input type="checkbox" name="studio_attuale" id="studio_attuale"/>
                                        <label for="studio_attuale">{{ trans('wizard-application.attualmente_studio_qui') }}</label>
                                    </div>
                                </div>

                                <div class="row" style="margin-top:15px">
                                    <div class="input-field col s5 m2">
                                        <input min="1" name="grade_min" placeholder="100" id="grade_min"
                                               type="text"
                                               class="validate">
                                        <label for="grade_min">{{ trans('wizard-application.voto') }}</label>
                                    </div>
                                    <div class="input-field col s1 m1">
                                        <p style="margin-top: 0px;font-size: 2.5rem;">/</p>
                                    </div>
                                    <div class="input-field col s5 m2">
                                        <input min="1" id="grade_max" name="grade_max"
                                               placeholder="{{ trans('wizard-application.your_grade') }}"
                                               type="text"
                                               class="required validate" maxlength="3" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12 m12 right-align">
                                        <!-- Dropdown Trigger -->
                                        <button name="action" type="submit"
                                                class="waves-effect waves-light btn add-work-experience red"><i
                                                    class="mdi-maps-rate-review left "></i>{{ trans('profile.aggiungi') }}
                                        </button>

                                    </div>
                                </div>

                            </form>
                        </div>


                        <!-- Create Languages -->
                        <div id="CreateAlbum" class="tab-content col s12 card">
                            <div class="card-content">
                                <div class="card-title">
                                    <span>{{trans('common.new_language')}}</span>
                                </div>
                                <div class="card-description">
                                    <span class="grey-text">
                                    @if(!isset($user['languages']) || count($user['languages']) <= 0)
                                            {{trans('profile.no_language')}}
                                        @elseif (isset($user['languages']) && count($user['languages']) === 1)
                                            {{trans('profile.one_language')}}
                                        @elseif (isset($user['languages']) && count($user['languages']) > 1)
                                            {{str_replace("%c",count($user['languages']),trans('profile.more_languages'))}}
                                        @endif
                                    </span>
                                </div>


                            </div>
                            <div class="card-action">
                                <a class="btn waves-effect waves-light red show-tab">{{trans('profile.add')}}</a>
                            </div>

                            <form id="language-form" method="POST" action="#">
                                <div class="row">
                                    <div class="input-field col s12 m12 l12">
                                        <i class="prefix fa fa-language "></i>
                                        <input class="lingua_id" name="lingua[]" type="hidden" value="2">
                                        <select id="lingua_id" name="lingua_id[]"
                                                class="select2-languages required input-language" required>
                                            <option value="" disabled
                                                    selected>{{trans("common.language_generic")}}</option>

                                        </select>

                                    </div>
                                    <div style="height: 10px;" class="clearfix"></div>
                                    <div style=" margin-left: 40px;" class="col s4 m3">
                                        {{ trans('profile.lettura') }}<br>
                                        <select name="lettura[]" id="lettura" class="rating-star hide-rating-start">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="col s4 m3">
                                        {{ trans('profile.scrittura') }}<br>
                                        <select name="scrittura[]" id="scrittura" class="rating-star hide-rating-start">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="col s4 m3">
                                        {{ trans('profile.dialogo') }}<br>
                                        <select name="dialogo[]" id="dialogo" class="rating-star hide-rating-start">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="row" style="margin-top:20px">
                                    <div class="col s12 m12 right-align">
                                        <!-- Dropdown Trigger -->


                                        <button name="action" type="submit"
                                                class="waves-effect waves-light btn add-work-experience red">
                                            <i class="mdi-maps-rate-review left "></i>{{ trans('profile.aggiungi') }}
                                        </button>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!--/ profile-page-wall-share -->


                <!--work collections start-->
                <div id="work-collections" class="section">

                    <div class="row">
                        <div class="col s12 m12 l12">


                            @if(!empty($user['work_experiences']))
                                <h4 class="header">{{ trans('profile.esperienze_lavorative') }}</h4>
                            @endif
                            <div data-type="meritocracy-load-template" data-delay="0" data-url="/user/work-experiences" id="profileWorkExperiences">
                                <div style="margin-top: 50px; margin-bottom: 50px;"
                                     class="col s12 m12 l12 center loader">
                                    <div class="preloader-wrapper big active">
                                        <div class="spinner-layer spinner-red-only">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="gap-patch">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Floating Action Button -->
                </div>

                <!--work collections start-->
                <div id="education-collections" class="section">

                    <div class="row">
                        <div class="col s12 m12 l12">

                            <h4 class="header  @if(empty($user['educations'])) hide @endif">{{ trans('profile.percorso_scolastico') }}</h4>
                            <div data-type="meritocracy-load-template" data-delay="0" data-url="/user/education" id="profileEducation">
                                <div style="margin-top: 50px; margin-bottom: 50px;"
                                     class="col s12 m12 l12 center loader">
                                    <div class="preloader-wrapper big active">
                                        <div class="spinner-layer spinner-red-only">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="gap-patch">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                    <!-- Floating Action Button -->
                </div>
                <div id="language-collections" class="section">

                    <div class="row">
                        <div class="col s12 m12 l12">


                            @if(!empty($user['languages']))
                                <h4 class="header">{{ trans('profile.lingue') }}</h4>
                                <div data-type="meritocracy-load-template" data-delay="0" data-url="/user/languages" id="profileLanguages">
                                    <div style="margin-top: 50px; margin-bottom: 50px;"
                                         class="col s12 m12 l12 center loader">
                                        <div class="preloader-wrapper big active">
                                            <div class="spinner-layer spinner-red-only">
                                                <div class="circle-clipper left">
                                                    <div class="circle"></div>
                                                </div>
                                                <div class="gap-patch">
                                                    <div class="circle"></div>
                                                </div>
                                                <div class="circle-clipper right">
                                                    <div class="circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
            <!--/ profile-page-wall -->

        </div>
        <!--work collections start-->

    </div>
@endsection

