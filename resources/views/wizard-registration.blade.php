@extends('template.layout')

@yield('header')

@section('content')




    <input type="hidden" id="id_application" value="{{$application['id'] or ''}}">

    <div class="container-fluid" style="padding-bottom: 20px;background:white !important;">

        <div class="container padded">

            <div class="row">
                <div class="col col-md-16"><p class="red-label"
                                              data-translate="">{{ trans('wizard-registration.title_text_2') }}</p>
                </div>

            </div>

            <div class="row">
                <div class="col col-md-offset-0 col-md-16">


                    <form id="wizard" action="#">
                        <h3>{{ trans($route.'.esperienze_lavorative') }}</h3>


                        <fieldset data-route="">
                            <div class="nano nano-work">

                                <input type="hidden" name="id_work_experience" id="id_work_experience">

                                <div class="nano-content">
                                    <legend>{{ trans($route.'.ultima_esperienza') }}</legend>
                                    <div class="row">

                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="prefix fa fa-briefcase"></i>
                                            <input type="hidden" name="role_id" id="role_id">

                                            <input id="role" name="role" class="required validate" type="text"
                                                   required="">
                                            <label class="" for="role">{{ trans($route.'.ruolo') }}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="material-icons prefix">store</i>
                                            <input type="hidden" name="azienda_id" id="azienda_id">
                                            <input id="azienda" name="nome_azienda" type="text"
                                                   class="required validate" required>
                                            <label for="azienda">{{ trans($route.'.nome_azienda') }}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="material-icons prefix">work</i>


                                            <select id="job_function" name="job_function"
                                                    class="select2-jobFunctions" required>
                                                <option value="" disabled selected>Choose your option</option>
                                            </select>



                                            <label for="job_function">{{ trans('profile.scegli_job')}}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="material-icons prefix">location_on</i>
                                            <input type="hidden" name="work_city_id" id="work_city_id">
                                            <input id="luogo_lavoro" name="luogo_lavoro" type="text"
                                                   class="required validate" required>
                                            <label for="luogo_lavoro">{{ trans($route.'.luogo_lavoro') }}</label>
                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="material-icons prefix">work</i>


                                            <select id="industry" name="industry"
                                                    class="select2-industry" required>
                                                <option value="" disabled selected>Choose your option</option>
                                            </select>
                                            <label for="job_function">{{ trans('wizard-application.industry') }}</label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="fa fa-calendar prefix"></i>
                                            <label for="data_inizio">{{ trans($route.'.data_inizio') }}</label>
                                            <input type="text" name="data_inizio" id="data_inizio"
                                                   class="datepicker required" required>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="input-field col col-md-10 col-xs-16">
                                            <i class="fa fa-calendar prefix"></i>
                                            <label for="data_fine">{{ trans($route.'.data_fine') }}</label>
                                            <input type="text" name="data_fine" id="data_fine"
                                                   class="datepicker required" required>

                                        </div>

                                        <div class="input-field col col-md-5 col-xs-16">
                                            <p>
                                                <input type="checkbox" name="lavoro_attuale" id="lavoro_attuale"/>
                                                <label for="lavoro_attuale">{{ trans($route.'.attualmente_lavoro_qui') }}</label>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="material-icons prefix">comment</i>
                                            <textarea id="comment" name="comment"
                                                      class="materialize-textarea"></textarea>
                                            <label for="comment">{{ trans($route.'.raccontaci_esperienza') }}</label>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </fieldset>

                        <h3>{{ trans($route.'.istruzione') }}</h3>
                        <fieldset>
                            <div class="nano nano-education">

                                <input type="hidden" name="id_education" id="id_education">

                                <div class="nano-content">

                                    <legend>{{ trans($route.'.istruzione_subtitle') }}</legend>
                                    <div class="row">

                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="material-icons prefix">grade</i>

                                            <select  class="select2-degrees" required id="titolo_studio" name="titolo_studio">
                                                <option value="" disabled
                                                        selected>{{ trans($route.'.titolo_studio') }}</option>

                                            </select>
                                            <label for="titolo_studio">{{ trans($route.'.titolo_studio') }}</label>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="prefix fa fa-university"></i>
                                            <input type="hidden" name="school_id" id="school_id">
                                            <input id="school" type="text" name="school" class="required" required>
                                            <label for="school">{{ trans($route.'.luogo_studio') }}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col col-md-15 col-xs-16">

                                            <i class="material-icons prefix">grade</i>

                                            <select id="education" name="education_id"
                                                    class="select2-studyField" required>
                                                <option value="" disabled selected>Choose your option</option>
                                            </select>
                                            <label for="education">{{ trans($route.'.facolta') }}</label>


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col col-md-15 col-xs-16">
                                            <i class="fa fa-calendar prefix"></i>
                                            <label for="data_inizio_education">{{ trans($route.'.data_inizio') }}</label>
                                            <input type="text" name="data_inizio_education" id="data_inizio_education"
                                                   class="datepicker required" required>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="input-field col col-md-10 col-xs-16">
                                            <i class="fa fa-calendar prefix"></i>
                                            <label for="data_fine_education">{{ trans($route.'.data_fine') }}</label>
                                            <input type="text" name="data_fine_education" id="data_fine_education"
                                                   class="datepicker required" required>

                                        </div>
                                        <div class="input-field col col-md-5 col-xs-16">
                                            <p>
                                                <input type="checkbox" name="studio_attuale" id="studio_attuale"/>
                                                <label for="studio_attuale">{{ trans($route.'.attualmente_studio_qui') }}</label>
                                            </p>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col col-md-3">
                                            <input name="grade_min" placeholder="{{ trans($route.'.your_grade') }}" id="grade_min" type="text"
                                                   class="validate">
                                            <label for="grade_min">{{ trans($route.'.voto') }}</label>
                                        </div>
                                        <div class="input-field col col-md-1">
                                            <p style="font-size: 2.5rem;">/</p>
                                        </div>
                                        <div class="input-field col col-md-3">

                                            <input id="grade_max" name="grade_max" placeholder="max" type="text"
                                                   class="required validate" maxlength="3"  required>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </fieldset>

                        <h3>{{ trans($route.'.lingue') }}</h3>
                        <fieldset>
                            <div class="nano nano-language">


                                <div class="nano-content">

                                    <legend>{{ trans($route.'.lingue_subtitle') }}</legend>

                                    <div class="row">
                                        <div class="col col-md-5">
                                            <b>{{ trans($route.'.lingua') }}</b>
                                        </div>
                                        <div class="col col-md-3 col-md-offset-1">
                                            <b>{{ trans($route.'.lettura') }}</b>
                                        </div>
                                        <div class="col col-md-3">
                                            <b>{{ trans($route.'.scrittura') }}</b>
                                        </div>
                                        <div class="col col-md-3">
                                            <b>{{ trans($route.'.dialogo') }}</b>
                                        </div>
                                        <div class="col col-md-1">
                                        </div>
                                    </div>


                                    <div class="row">
                                        <input class="id_language_user" type="hidden" value="2">

                                        <div class="input-field col-md-5 col-sm-5 col-lg-5">
                                            <i class="fa fa-language prefix"></i>
                                            <input class="lingua_id" name="lingua[]" type="hidden" value="2">
                                            <select id="lingua_id" name="lingua_id[]"
                                                    class="select2-languages required input-language" required>
                                                <option value="" disabled selected>{{trans("common.first_language")}}</option>
                                            </select>

                                        </div>
                                        <div class="input-field col col-md-3 col-md-offset-1 rating-col">
                                            <input type="number" name="lettura[]" value="2" id="some_id"
                                                   class="rating"/>
                                        </div>
                                        <div class="input-field col col-md-3 rating-col">
                                            <input type="number" name="scrittura[]" value="2" id="some_id"
                                                   class="rating"/>
                                        </div>
                                        <div class="input-field col col-md-3 rating-col">
                                            <input type="number" name="dialogo[]" value="2" id="some_id"
                                                   class="rating"/>
                                        </div>
                                        <div class="input-field col col-md-1">
                                            <a class="btn-floating btn-small waves-effect waves-light remove"><i
                                                        class="tiny material-icons">delete</i></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input class="id_language_user" type="hidden" value="2">

                                        <div class="input-field col-md-5 col-sm-5 col-lg-5">
                                            <i class="fa fa-language prefix"></i>
                                            <input class="lingua_id" name="lingua[]" type="hidden" value="2">
                                            <select id="lingua_id" name="lingua_id[]"
                                                    class="select2-languages required input-language" required>
                                                <option value="" disabled selected>{{trans("common.other_language")}}</option>
                                            </select>

                                        </div>
                                        <div class="input-field col col-md-3 col-md-offset-1 rating-col">
                                            <input type="number" name="lettura[]" value="2" id="some_id"
                                                   class="rating"/>
                                        </div>
                                        <div class="input-field col col-md-3 rating-col">
                                            <input type="number" name="scrittura[]" value="2" id="some_id"
                                                   class="rating"/>
                                        </div>
                                        <div class="input-field col col-md-3 rating-col">
                                            <input type="number" name="dialogo[]" value="2" id="some_id"
                                                   class="rating"/>
                                        </div>
                                        <div class="input-field col col-md-1">
                                            <a class="btn-floating btn-small waves-effect waves-light remove"><i
                                                        class="tiny material-icons">delete</i></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>

                        <h3>{{ trans('wizard-registration.registrazione_completata') }}</h3>
                        <fieldset>
                            <legend id="summary-legend">
                                {{ trans('wizard-registration.registrazione_completata_subtitle') }}
                            </legend>

                            <div class="row">
                                <div class="col col-md-16">
                                    <div class="box-summary-wizard" id="work-box">

                                        <div class="preloader-wrapper active">
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


                                        <div class="content-summary hide">
                                            <i class="prefix fa fa-briefcase"></i>
                                            <b class="title"></b>
                                            <div class="location">
                                                <i class="material-icons prefix">location_on</i>
                                                <span class="title"></span>
                                            </div>
                                            <p> {{ trans($route.'.dal') }}
                                                <b class="data-from"></b> {{ trans($route.'.al') }} <b
                                                        class="data-to"></b></p>
                                        </div>
                                    </div>

                                    <div class="box-summary-wizard" id="education-box">


                                        <div class="preloader-wrapper active">
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


                                        <div class="content-summary hide">
                                            <i class="prefix fa fa-university"></i>
                                            <b class="title"></b>
                                            <div class="location">
                                                <i class="material-icons prefix">location_on</i>
                                                <span class="title"></span>
                                            </div>
                                            <p>{{ trans($route.'.dal') }} <b
                                                        class="data-from"></b> {{ trans($route.'.al') }} <b
                                                        class="data-to"></b></p>
                                        </div>
                                    </div>
                                    <div class="box-summary-wizard" id="language-box">
                                        <div class="preloader-wrapper active">
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

                                        <div class="content-summary hide">

                                            <i class="fa fa-language prefix"></i>
                                        </div>

                                    </div>
                                </div>


                                <div class="col col-md-16 hide" id="thank-you-box">
                                    <h4>{{trans("wizard-registration.thankyou_message")}}</h4>

                                    <div class="row">
                                        <div class="col col-md-16">
                                            <a href="/user">

                                                <div class="box-summary-wizard first" id="work-box">

                                                    <div class="content-summary ">
                                                        <h3 class="title">{{trans('thankyou-application.completa_profilo')}}</h3>
                                                        <i class="prefix fa fa-user"></i>
                                                        <div class="location">
                                                            <span class="title">{{trans('thankyou-application.completa_profilo_text')}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </a>

                                            <a href="/jobs">

                                                <div class="box-summary-wizard" id="education-box">


                                                    <div class="content-summary ">
                                                        <h3 class="title">{{trans('thankyou-application.altre_posizioni')}}</h3>
                                                        <i class="prefix fa fa-search"></i>
                                                        <div class="location">
                                                            <span class="title">{{trans('thankyou-application.altre_posizioni_text')}}</span>
                                                        </div>

                                                    </div>
                                                </div>

                                            </a>

                                            <a href="/">

                                                <div class="box-summary-wizard" id="language-box">


                                                    <div class="content-summary ">
                                                        <h3 class="title">{{trans('thankyou-application.homepage')}}</h3>
                                                        <i class="prefix fa fa-home"></i>
                                                        <div class="location">
                                                            <span class="title">{{trans('thankyou-application.homepage_text')}}</span>
                                                        </div>

                                                    </div>

                                                </div>
                                            </a>

                                        </div>

                                        <div class="col col-md-8 col-md-offset-4 center">
                                            <a href="/user">
                                             <button class="btn btn-red btn-block btn-big" >
                                                <span>{{ trans('common.continue') }}</span>
                                            </button></a>
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </fieldset>
                    </form>


                </div>
            </div>


        </div>

    </div>

    </div>
    @include('jolly')
@endsection

@section('page-scripts')
    <script type="text/javascript" src="/js/nanoScroll.js"></script>
    <script type="text/javascript" src="/js/bootstrap-rating-input.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
    <script type="text/javascript" src="/js/jquery.steps.min.js"></script>
    <script type="text/javascript" src="/js/pages/wizard-application.js?v=1"></script>
    <script src="/js/MonthPicker.min.js" type="text/javascript"></script>
    <script>WizardApplication.init();</script>

@endsection

@section('page-css')

    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.theme.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/css/materialize.css" rel="stylesheet">
    <link href="/css/wizard-application.css" rel="stylesheet">
@endsection