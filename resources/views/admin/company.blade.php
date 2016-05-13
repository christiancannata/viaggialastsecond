@extends('template.admin_layout')

@yield('header')

@section('page-css')
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">


<link href="/admin/js/plugins/xcharts/xcharts.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<link href="/admin/js/plugins/jsgrid/css/jsgrid.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/jsgrid/css/jsgrid-theme.min.css" type="text/css" rel="stylesheet"
      media="screen,projection">

@endsection

@section('breadcrumbs')

        <!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <!-- Search for small screen -->
    <div class="header-search-wrapper grey hide">
        <i class="mdi-action-search active"></i>
        <input type="text" name="Search" class="header-search-input z-depth-2"
               placeholder="Search for candidates">
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">{{$company['name']}} Dashboard</h5>
                <ol class="breadcrumbs">
                    <li><a href="/admin/dashboard">Dashboard</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')


    <div class="section">

        <!--card stats start-->
        <div id="card-stats ">
            <div class="row">
                <div class="col s6 m6 l6 ">
                  <a href="/admin/{{$company['permalink']}}/statistics" target="_blank"> <button style="height:60px" class="btn wave red"
                            >
                        <h5 class="card-stats-number center">Statistiche</h5>
                    </button></a>
                </div>
                @if(!$user->company['is_complete'])
                    <div style="margin-bottom: 20px;" class="col s6 m6 l6 offset-m3 offset-l3 center">
                        <button class="btn wave red" onclick="location.href='/hr/company-page'">

                            @if(!isset($_COOKIE['first_view_message_hr']))
                                <?php
                                setcookie("first_view_message_hr", "1", time() + 360000);  /* expire in 1 hour */
                                ?>
                                <span style="font-size: 1.35rem" class="">Start building your branding page</span>
                            @else
                                <span style="font-size: 1.35rem" class="">Complete your Branding Page HERE</span>
                            @endif

                        </button>
                    </div>

                @elseif($user->company['is_complete'] && empty($vacancies))
                    <div class="col s6 m6 l6 offset-m3 offset-l3">
                        <button style="height:60px" class="btn wave red"
                                onclick="$('#modal-new-vacancy').openModal()">
                            <h5 class="card-stats-number center">Open your first vacancy</h5>
                        </button>
                    </div>
                @endif


            </div>
        </div>

        <div class="divider"></div>
        <div style="height: 10px;" class="clearfix"></div>

        <input type="hidden" id="company-videos" value="{{json_encode($videos)}}">

        <div data-count="" data-other="" id="vacancies">
            <div class="col s12 m8 l9">
                <?php
                $applicationTotali = 0;

                ?>


                @foreach($vacancies as $vacancy)

                    <?php
                    $applicationTotali += $vacancy['total_application']['total_referral'];

                    ?>
                    @if($vacancy["is_visible_hr"]==true)
                            <div data-vacancy-id="{{$vacancy["id"]}}" id="vacancy-{{$vacancy["id"]}}"
                                 class="card vacancies-hr">
                                <input type="hidden" value="{{json_encode($vacancy)}}" id="vacancy-data-{{$vacancy["id"]}}">
                                <div class="card-content">
                                    <div class="card-title activator grey-text text-darken-4 bold">
                                        <span>{{$vacancy["name"]}}</span>
                                        <ul style="display: inline-block; margin-left: 20px;" class="card-subtitle">

                                            @if($vacancy['is_sponsored'])
                                                <li class="sponsored ">
                                                    <div class="chip2 light-blue white-text">Sponsored</div>
                                                </li>
                                            @endif
                                            <li class="edited hide">
                                                <div class="chip2 green white-text">Recently edited</div>
                                            </li>

                                            @if(isset($vacancy["job_function"]["name"]))
                                                <li>
                                                    <div class="chip2">{{ $vacancy["job_function"]["name"] }} <i
                                                                class="mdi-action-work material-icons"></i></div>
                                                </li>
                                            @endif

                                            @if(isset($vacancy["study_field"]["name"]))
                                                <li>
                                                    <div class="chip2">{{ $vacancy["study_field"]["name"] }} <i
                                                                class="mdi-social-school material-icons"></i></div>
                                                </li>
                                            @endif

                                            @if(isset($vacancy["industry"]["name"]))
                                                <li>
                                                    <div class="chip2  ">{{ $vacancy["industry"]["name"] }} <i
                                                                class="mdi-communication-business material-icons"></i></div>
                                                </li>
                                            @endif
                                            <li>
                                                <div class="chip2 grey white-text"><i
                                                            class="mdi-file-folder-shared   material-icons "></i> {{$vacancy['total_application']['incoming']}}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="chip2 green white-text"><i
                                                            class="mdi-action-thumb-up  material-icons "></i> {{$vacancy['total_application']['liked']}}
                                                </div>
                                            </li>

                                            <li>
                                                <div class="chip2 red white-text"><i
                                                            class="mdi-action-thumb-down  material-icons "></i> {{$vacancy['total_application']['disliked']}}
                                                </div>
                                            </li>


                                        </ul>
                                        <h6>@if(isset($vacancy['city_plain_text'])) {{$vacancy['city_plain_text']}} @endif</h6>

                                    </div>

                                    <div class="card-description">
                                        <span class="grey-text">Description: </span> {!! strip_tags($vacancy["description"],"<br><br />")  !!}
                                    </div>

                                <span style="position: absolute; top: 10px; right: 20px;"
                                      class="grey-text ultra-small">{{date('d F Y', strtotime($vacancy["created_at"])) }}</span>

                                    <ul id="dropdown-vacancy-{{$vacancy["id"]}}" class="dropdown-content">
                                        <li><a data-name="{{$vacancy["name"]}}" data-id="{{$vacancy["id"]}}"
                                               class="red-text vacancy-edit"><i class="mdi-editor-mode-edit"></i>&nbsp;Edit</a>
                                        </li>
                                        <li class=""><a data-name="{{$vacancy["name"]}}" data-id="{{$vacancy["id"]}}"
                                                        class="red-text vacancy-clone"><i
                                                        class="mdi-content-content-copy"></i>&nbsp;Clone</a>
                                        </li>
                                        <li>
                                            <a data-name="{{$vacancy["name"]}}" data-id="{{$vacancy["id"]}}"
                                               class="red-text vacancy-close"><i class="mdi-navigation-close"></i>&nbsp;Close</a>
                                        </li>
                                        <li><a class="vacancy-sort red-text"><i class="mdi-editor-wrap-text"></i>&nbsp;Order</a>
                                        </li>

                                    </ul>


                                </div>
                                <div class="card-action">
                                    <a href="/admin/{{$vacancy["company"]['permalink']}}/{{$vacancy["permalink"]}}" class="btn waves waves-light waves-effect red"
                                       lang="en" target="_blank">View candidates (<span class="total-application"
                                                                                        data-id-vacancy="{{$vacancy['id']}}">{{$vacancy['total_application']['total']}}</span>)</a>

                                    <a class="btn dropdown-button waves-effect waves-light red" href="#!"
                                       data-activates="dropdown-vacancy-{{$vacancy["id"]}}">Options<i
                                                class="mdi-navigation-arrow-drop-down right"></i></a>

                                    @if(Auth::user()->type=="ANALYTICS")

                                        <div class="ctr-vacancy right btn light-blue" data-id-vacancy="{{$vacancy['id']}}"
                                             data-permalink-vacancy="/{{$company['permalink']}}/{{$vacancy['permalink']}}"
                                             data-open-date="{{date('Y-m-d', strtotime($vacancy["created_at"])) }}"
                                             data-applications="{{$vacancy['total_application']['total']}}"></div>

                                    @endif
                                </div>
                            </div>
                    @endif
                @endforeach
            </div>
        </div>



        <!-- Compose Email Structure -->
        <div id="modal-new-vacancy" class="modal std-modal" style="width:80%">
            <div class="modal-content">
                <nav class="red color-result darken-1">
                    <div class="nav-wrapper">
                        <div class="left col s12 m5 l5">
                            <ul>

                                <li><a lang="en" href="#!" class="email-type">Add a new vacancy</a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </nav>
            </div>
            <div class="model-email-content color-result">
                <div class="row">


                    <form id="new-vacancy" class="col s12" method="POST" action="">

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="col s12 m12 l12 center form-loader">
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


                        <div class="form-content">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input name="vacancyAddName" id="vacancyAddName" type="text" class="validate">
                                    <label lang="en" for="vacancyAddName">Title</label>
                                </div>
                            </div>
                            <input type="hidden" name="company[id]" value="{{Auth::user()->company['id']}}">

                            <div class="row">
                                <div class="input-field col s12">
                                <textarea name="vacancyAddDescription" id="vacancyAddDescription"
                                          length="9000" required></textarea>
                                    <label lang="en" for="vacancyAddDescription">Description</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="vacancyAddJobFunction" name="vacancyAddJobFunction"
                                            class="select2-jobFunctions" required>
                                        <option value="" disabled selected>Choose your option</option>
                                    </select>
                                    <label for="vacancyAddJobFunction" lang="en">Job Function</label>

                                </div>
                                <div class="input-field col s6">

                                    <select id="vacancyAddStudyField" name="vacancyAddStudyField"
                                            class="select2-studyFields" required>
                                        <option value="" disabled selected>Choose your option</option>

                                    </select>
                                    <label lang="en">Preferred Study Field</label>
                                </div>
                            </div>


                            <div class="row">

                                <div class="input-field col s6">
                                    <select id="vacancyAddIndustry" name="vacancyAddIndustry" required>
                                        <option value="" disabled selected>Choose your option</option>
                                        @foreach($industries as $industry)
                                            <option @if($industry["id"] === $companyIndustry) selected
                                                    @endif value="{{$industry['id']}}">{{$industry['name']}}</option>
                                        @endforeach
                                    </select>
                                    <label lang="en">Industry</label>

                                </div>

                                <div class="input-field col s6">
                                    <select id="vacancyAddSeniority" name="vacancyAddSeniority" required class="">
                                        <option value="" disabled selected>Choose your option</option>
                                        <option lang="en" value="INTERN_STAGE">Intern / Stage</option>
                                        <option lang="en" value="JUNIOR">Junior</option>
                                        <option lang="en" value="MIDDLE">Middle</option>
                                        <option lang="en" value="SENIOR">Senior</option>
                                    </select>
                                    <label lang="en">Seniority</label>

                                </div>

                            </div>

                            <div class="row">

                                <div class="input-field col s12">
                                    <select multiple id="vacancyAddLanguages" required name="vacancyAddLanguages"
                                            class="select2-languages">
                                        <option value="" disabled selected>Choose your options</option>


                                        @foreach($languages as $language)
                                            <option @if( isset($language['id']) && $language["id"] === $companyLanguage) selected
                                                    @endif value="{{$language['id']}}">{{$language['name']}}</option>
                                        @endforeach

                                    </select>
                                    <label lang="en">Required Languages</label>

                                </div>

                            </div>


                            @if(!empty($videos))
                                <div class="row">

                                    <div class="input-field col s12">

                                        <select multiple id="vacancyAddVideo" required name="video[id]"
                                                class="select2-video">
                                            <option value="" disabled selected>Choose your video</option>

                                            @foreach($videos as $video)
                                                <option value="{{$video['id']}}">{{$video['name']}}</option>
                                            @endforeach

                                        </select>
                                        <label lang="en">Vacancy Video</label>

                                    </div>

                                </div>
                            @endif


                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="hidden" name="city[id]" class="address_city_id"
                                           value="@if(isset($company['city']['id'])){{$company['city']['id']}}@endif"
                                           id="work_city_id">
                                    <input id="luogo_lavoro" name="city_plain_text" type="text"
                                           class="required validate"
                                           value="@if(isset($company['city'])){{$company['city_plain_text']}}@endif"
                                           required>
                                    <label for="luogo_lavoro">{{ trans('company-page.citta') }}</label>
                                </div>
                            </div>

                            @if(Auth::user()->type=="COMPANY")
                                <?php
                                $now = new \DateTime();
                                ?>
                                <input
                                        name="vacancyAddDate"
                                        id="vacancyAddDate" type="hidden"
                                        value="<?php echo $now->format("Y-m-d H:i") ?>">
                            @else
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <input class="datepicker"
                                               name="vacancyAddDate"
                                               id="vacancyAddDate" type="text">
                                        <label lang="en" for="vacancyAddDate">Opening date</label>

                                    </div>
                                </div>
                            @endif


                            <div class="row">
                                <div class="col s12 m8 l9">
                                    <h5 style="font-size: 1.30rem;" class="title">{{trans('hr.sponsored_title')}}</h5>
                                    <p>
                                        <input name="sponsored_yes" type="radio" id="sponsored_yes" value="on"/>
                                        <label for="sponsored_yes">{{trans('hr.sponsored_yes_title')}}<br>
                                            <span style="font-size:0.8rem"> {{trans('hr.sponsored_yes_text')}}</span>
                                        </label>
                                    </p>
                                    <p>
                                        <input name="sponsored_yes" type="radio" id="sponsored_no" value="off"/>
                                        <label for="sponsored_no">{{trans('hr.sponsored_no_title')}}<br>
                                            <span style="font-size:0.8rem"> {{trans('hr.sponsored_no_text')}}</span></label>
                                    </p>

                                </div>
                            </div>
                            <div class="input-field col s12">
                                <button lang="en" class="btn waves-effect waves-light right red submit btn-add-vacancy"
                                        type="submit"
                                >Add vacancy<i class="mdi-content-add right"></i>
                                </button>
                            </div>

                        </div>

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Vacancy created
                                </h4>
                                <h6 lang="en">The vacancy has been created succesfully.<br></h6>
                            </div>
                            <div class="button-action">
                                <button type="button" data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light green darken-2 btn form-recreate-modal">Add
                                    another
                                </button>
                                <button type="button" lang="en"
                                        class="waves-effect waves-light green darken-2 btn modal-close">
                                    Close
                                </button>
                            </div>

                        </div>

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-error animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to add vacancy
                                </h4>
                                <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                            </div>
                            <div class="button-action">
                                <button type="button" data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit data
                                </button>
                                <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again</button>
                            </div>

                        </div>


                    </form>
                </div>
            </div>


        </div>
        <!-- Edit vacancy -->
        <div id="modal-edit-vacancy" class="modal std-modal" style="width:80%">
            <div class="modal-content">
                <nav class="red color-result darken-1">
                    <div class="nav-wrapper">
                        <div class="left col s12 m5 l5">
                            <ul>
                                <li><a lang="en" href="#!" class="vacancy-name"></a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </nav>
            </div>
            <div class="model-email-content color-result">
                <div class="row">


                    <form data-vacancy-id="" id="edit-vacancy" class="col s12" method="POST" action="">
                        <input type="hidden" name="action" id="action-edit" value="">

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="col s12 m12 l12 center form-loader">
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

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Vacancy updated
                                </h4>
                                <h6 lang="en">The vacancy has been update succesfully.</h6>
                            </div>
                            <div class="button-action">

                                <button lang="en" class="waves-effect waves-light green darken-2 btn modal-close">
                                    Close
                                </button>
                            </div>

                        </div>


                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-clone animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Vacancy added
                                </h4>
                                <h6 lang="en">The vacancy has been cloned succesfully.</h6>
                            </div>
                            <div class="button-action">

                                <button lang="en" class="waves-effect waves-light green darken-2 btn modal-close">
                                    Close
                                </button>
                            </div>

                        </div>

                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-error-clone animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to clone
                                    vacancy
                                </h4>
                                <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                            </div>
                            <div class="button-action">
                                <button data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit data
                                </button>
                                <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again</button>
                            </div>

                        </div>
                        <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                             class="center form-result-error animated fadeIn">
                            <div class="white-text">
                                <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to edit
                                    vacancy
                                </h4>
                                <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                            </div>
                            <div class="button-action">
                                <button data-form="new-vacancy" lang="en"
                                        class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit data
                                </button>
                                <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again</button>
                            </div>

                        </div>


                        <div class="form-content">

                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="iOs Developer" name="vacancyEditName" id="vacancyEditName"
                                           type="text" class="validate">
                                    <label lang="en" for="vacancyEditName">Name</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12">
                                <textarea
                                        name="vacancyEditDescription" id="vacancyEditDescription"
                                ></textarea>
                                    <label lang="en" for="vacancyEditDescription">Description</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="vacancyEditJobFunction" name="vacancyEditJobFunction"
                                            class="select2-jobFunctions" required>
                                        <option value="" disabled selected>Choose your option</option>
                                    </select>
                                    <label for="vacancyEditJobFunction" lang="en">Job Function</label>

                                </div>
                                <div class="input-field col s6">

                                    <select id="vacancyEditStudyField" name="vacancyEditStudyField"
                                            class="select2-studyFields" required>
                                        <option value="" disabled selected>Choose your option</option>

                                    </select>
                                    <label lang="en">Study Field</label>
                                </div>
                            </div>


                            <div class="row">

                                <div class="input-field col s6">
                                    <select id="vacancyEditIndustry" name="vacancyEditIndustry"
                                            class="select2-industries" required>
                                        <option value="" disabled selected>Choose your option</option>
                                    </select>
                                    <label lang="en">Industry</label>

                                </div>

                                <div class="input-field col s6">
                                    <select id="vacancyEditSeniority" name="vacancyEditSeniority" required class="">
                                        <option value="" disabled selected>Choose your option</option>
                                        <option lang="en" value="INTERN_STAGE">Intern / Stage</option>
                                        <option lang="en" value="JUNIOR">Junior</option>
                                        <option lang="en" value="MIDDLE">Middle</option>
                                        <option lang="en" value="SENIOR">Senior</option>
                                    </select>
                                    <label lang="en">Seniority</label>

                                </div>

                            </div>

                            <input type="hidden" name="is_active" class=""
                                   value="" id="is_active_edit">
                            <input type="hidden" name="is_sponsored" class=""
                                   value="" id="is_sponsored_edit">


                            <input type="hidden" name="company[id]" value="{{Auth::user()->company['id']}}">


                            <div class="row">
                                <div class="input-field col s12 m12">
                                    <input type="hidden" name="city[id]" class="address_city_id"
                                           value="" id="work_city_id_1">
                                    <input id="luogo_lavoro_1" name="city_plain_text" type="text"
                                           class="required validate address_city" value="" required>
                                    <label class="active" for="luogo_lavoro_1">{{ trans('company-page.citta') }}</label>
                                </div>

                                @if(!empty($videos))
                                    <div class="input-field col s12 m12">
                                        <select id="vacancyEditVideo" name="video[id]"
                                                class="select2-videos">
                                            <option value="" disabled selected>Choose your video</option>
                                        </select>
                                        <label lang="en">Video</label>

                                    </div>
                                @endif
                            </div>


                            @if(Auth::user()->type=="COMPANY")
                                <input
                                        name="vacancyEditDate"
                                        id="vacancyEditDate" type="hidden" value="">
                            @else
                                <div class="row ">
                                    <div class="input-field col s12">
                                        <input class="datepicker"
                                               name="vacancyEditDate"
                                               id="vacancyEditDate" type="text">
                                        <label lang="en" for="vacancyEditDate">Opening date</label>

                                    </div>
                                </div>
                            @endif


                            <div class="row">

                                <div class="input-field col s12">
                                    <select multiple id="vacancyEditLanguages" required name="vacancyEditLanguages[]"
                                    >
                                        <option value="" disabled selected>Choose your options</option>
                                        @foreach($languages as $language)
                                            <option value="{{$language['id']}}">{{$language['name']}}</option>
                                        @endforeach
                                    </select>


                                    <label lang="en">Required Languages</label>

                                </div>

                            </div>


                            <div class="input-field col s12">
                                <button lang="en"
                                        class="btn waves-effect waves-light right red submit save-edit-vacancy"
                                        type="submit"
                                >Save changes
                                </button>
                            </div>

                        </div>


                    </form>
                </div>
            </div>

        </div>


    </div>

    @if(!empty($vacancies))
            <!-- Floating Action Button -->
    <div class="fixed-action-btn default-action-btn" style="bottom: 50px; right: 19px;">
        <a href="#modal-new-vacancy" class="btn-floating btn-large red modal-trigger">
            <i class="mdi-content-add"></i>
        </a>

    </div>
    <!-- Floating Action Button -->


    <!-- Floating Sort Button -->
    <div class="fixed-action-btn sort-action-btn" style="bottom: 50px; right: 19px; display: none;">
        <a class="btn-floating btn-large red">

            <div class="preloader-wrapper small active" style="display: none;">
                <div class="spinner-layer spinner-white" style="">
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

            <i class="mdi-action-done"></i>
        </a>


    </div>
    <!-- Floating Sort Button -->

    @endif


@endsection


@section('page-scripts')


    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript"
            src="{{auto_version("/admin/js/hr.js")}}"></script>
    <script type="text/javascript" src="/admin/js/plugins/formatter/jquery.formatter.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/db.js"></script> <!--data-->
    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/jsgrid.min.js"></script>


    <script type="text/javascript" src="/admin/js/plugins/d3/d3.min.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/xcharts/xcharts.min.js"></script>
    <!-- morris -->
    <script type="text/javascript" src="/admin/js/plugins/chartist-js/chartist.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/chartjs/chart.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/raphael/raphael-min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/morris-chart/morris.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/morris-chart/morris-script.js"></script>

    <script src="//www.paypalobjects.com/api/checkout.js"></script>

    <?php
    $dal = new \DateTime();
    $al = new \DateTime();
    $dal->sub(new \DateInterval("P8D"));
    $al->sub(new \DateInterval("P1D"));
    $cookie = 0;
    if (!isset($_COOKIE['count_visit'])) {
        setcookie("count_visit", "1", time() + (10 * 365 * 24 * 60 * 60));
        $cookie = 1;
    } else {
        $cookie = intval($_COOKIE['count_visit']) + 1;
        setcookie("count_visit", $cookie, time() + (10 * 365 * 24 * 60 * 60));
    }

    $env = "production";
    if (getenv('APP_ENV') == "local") {
        $env = "sandbox";
    }

    ?>
    <style>
        #doughnut-chart-sample-legend li span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
        }
    </style>
    <script type="text/javascript">

        $(document).ready(function () {
            HR.init();
            window.statisticsRequest = [];
            <?php

            if($cookie==2 && \Illuminate\Support\Facades\Auth::user()->company['is_complete']==false){ ?>
            swal({
                        title: "{{trans("hr.title_popup_complete_page")}}",
                        text: "{{trans("hr.text_popup_complete_page")}}",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "{{trans("hr.button_cancel_popup_complete_page")}}",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans("hr.button_confirm_popup_complete_page")}}",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                    },
                    function () {
                        setTimeout(function () {
                            $.post("/hr/enqueue/complete-page", [], function (data, status, xhr) {
                                swal("{{trans("hr.confirm_message_popup_complete_page")}}");
                            }).fail(function () {

                            });
                        }, 2000);

                    });
            <?php }


                    ?>

            if ($("#morris-line").length) {


                $("#jsGrid-basic").jsGrid({
                    height: "auto",
                    width: "100%",
                    sorting: false,
                    paging: true,
                    pageSize: 4,
                    autoload: true,
                    controller: {
                        loadData: function () {
                            var d = $.Deferred();
                            var req = $.ajax({
                                url: "/company/{{$company['id']}}/topScoreReferral?total={{$applicationTotali}}",
                                dataType: "json"
                            }).done(function (response) {
                                d.resolve(response);
                            });
                            window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits
                            return d.promise();
                        }
                    },
                    fields: [
                        {name: "Referral", type: "text"},
                        {name: "Count", type: "number"},
                        {name: "Score", type: "number"}
                    ]
                });


                var req = $.ajax({
                            type: "GET",
                            dataType: 'json',
                            url: "/company/{{$company['id']}}/referral?total={{$applicationTotali}}", // This is the URL to the API
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data
                            window.DoughnutChartSample = new Chart(document.getElementById("doughnut-chart-sample").getContext("2d")).Pie(data, {
                                responsive: true,
                                segmentShowStroke: false,
                                tooltipTemplate: "<?php echo "<%= label %> <%= value %>%" ?>",
                            });

                            document.getElementById('doughnut-chart-sample-legend').innerHTML = window.DoughnutChartSample.generateLegend();


                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            //  alert("error occured");
                        });
                window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits


                var visitsArray = [];
                // Fire off an AJAX request to load the data
                var req = $.ajax({
                            type: "GET",
                            dataType: 'json',

                            url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/{{$company['permalink']}}&dimensions=ga:date&from=P7D&to=yesterday", // This is the URL to the API
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data

                            visitsArray = data;

                            $.ajax({
                                        type: "GET",
                                        dataType: 'json',
                                        url: "/company/{{$company['id']}}/applications?from={{$dal->format("d-m-Y")}}&to={{$al->format("d-m-Y")}}", // This is the URL to the API
                                    })
                                    .done(function (data) {
                                        // When the response to the AJAX request comes back render the chart with new data
                                        var applicationsArray = data;

                                        var arrayStatistic = [];


                                        $(visitsArray).each(function (i, value) {
                                            var appo = [];
                                            appo["date"] = value["dimensions"];
                                            appo["pageView"] = parseInt(value["pageView"]);

                                            var applicationsDay = 0;
                                            for (var j = 0; j < applicationsArray.length; j++) {
                                                if (applicationsArray[j]["date"] == value["dimensions"]) {
                                                    applicationsDay = applicationsArray[j]["applications"];
                                                }
                                            }

                                            appo["applications"] = applicationsDay;


                                            arrayStatistic.push(appo);
                                        });

                                        // Line Chart
                                        var chart = Morris.Line({
                                            element: 'morris-line',
                                            xkey: 'date',
                                            ykeys: ['pageView', 'applications'],
                                            xLabels: "daily",
                                            labels: ["Visits", "Applications"],
                                            resize: true,
                                            xLabelAngle: 0
                                        });


                                        chart.setData(arrayStatistic);


                                    })
                                    .fail(function () {
                                        // If there is no communication between the server, show an error
                                        // alert("error occured");
                                    });


                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            // alert("error occured");
                        });
                window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits


                $(".component-statistic").each(function (i, ctr) {
                    var ctr = $(this);
                    var req = $.ajax({
                                type: "GET",
                                dataType: 'json',
                                url: "/analytics/" + ctr.attr("data-type") + "/compare?typeGroup=" + ctr.attr("data-type-group") + "&id=" + ctr.attr("data-id"), // This is the URL to the API
                            })
                            .done(function (data) {
                                // When the response to the AJAX request comes back render the chart with new data
                                var percentage = (data.period_1["total"] - data.period_2["total"]) / data.period_2["total"] * 100;
                                ctr.find(".difference").text(percentage.toFixed(1) + "%");
                                ctr.find(".value-a").text(data.period_1["total"]);
                                ctr.removeClass("disabled");
                            })
                            .fail(function () {
                                // If there is no communication between the server, show an error
                                //  alert("error occured");
                            });
                    window.statisticsRequest.push(req);                // adds a new element (Lemon) to fruits

                });


                $("input[name=visit_type]").click(function (e) {

                    $("#morris-line").toggleClass("disabled");
                    // Fire off an AJAX request to load the data
                    var from = $(this).val();
                    $.ajax({
                                type: "GET",
                                dataType: 'json',
                                url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/{{$company['permalink']}}&dimensions=ga:date&from=" + from + "&to=yesterday", // This is the URL to the API
                            })
                            .done(function (data) {
                                // When the response to the AJAX request comes back render the chart with new data

                                visitsArray = data;

                                $.ajax({
                                            type: "GET",
                                            dataType: 'json',
                                            url: "/company/{{$company['id']}}/applications?from=" + from + "&to=yesterday&dateGroup=" + $("select[name=group]").val(), // This is the URL to the API
                                        })
                                        .done(function (data) {
                                            // When the response to the AJAX request comes back render the chart with new data
                                            var applicationsArray = data;

                                            var arrayStatistic = [];


                                            $(visitsArray).each(function (i, value) {
                                                var appo = [];
                                                appo["date"] = value["dimensions"];
                                                appo["pageView"] = parseInt(value["pageView"]);

                                                var applicationsDay = 0;
                                                for (var j = 0; j < applicationsArray.length; j++) {
                                                    if (applicationsArray[j]["date"] == value["dimensions"]) {
                                                        applicationsDay = applicationsArray[j]["applications"];
                                                    }
                                                }

                                                appo["applications"] = applicationsDay;


                                                arrayStatistic.push(appo);
                                            });


                                            $("#morris-line").empty();

                                            // Line Chart
                                            var chart = Morris.Line({
                                                element: 'morris-line',
                                                xkey: 'date',
                                                ykeys: ['pageView', 'applications'],
                                                xLabels: "daily",
                                                labels: ["Visits", "Applications"],
                                                resize: true,
                                                xLabelAngle: 0
                                            });
                                            chart.setData(arrayStatistic);

                                            $("#morris-line").toggleClass("disabled");
                                        })
                                        .fail(function () {
                                            // If there is no communication between the server, show an error
                                            // alert("error occured");
                                        });


                            })
                            .fail(function () {
                                // If there is no communication between the server, show an error
                                // alert("error occured");
                            });


                });


                $(".ctr-vacancy").each(function (i, ctr) {
                    var ctr = $(this);

                    /*
                     var req = $.ajax({
                     type: "GET",
                     dataType: 'json',
                     url: "/analytics?metrics=ga:pageviews&filters=ga:pagePath=@" + ctr.attr("data-permalink-vacancy") + "&from=" + "2015-01-01" + "&to=today", // This is the URL to the API
                     })
                     .done(function (data) {
                     // When the response to the AJAX request comes back render the chart with new data
                     if (data.length > 0) {
                     var result = (ctr.attr("data-applications") / data[0].dimensions) * 100;
                     ctr.text("APPL. RATE " + result.toFixed(2) + "%");
                     } else {
                     ctr.text("APPL. RATE Not available");
                     }


                     })
                     .fail(function () {
                     // If there is no communication between the server, show an error
                     //  alert("error occured");
                     });
                     statisticsRequest.push(req);                // adds a new element (Lemon) to fruits
                     */

                });

            } else {


            }

            <?php
              if($hasCheckout!=false){
                        ?>
                      $("#modal-checkout-done").openModal();

            <?php }
            ?>

 <?php
              if($hasCancel!=false){
                        ?>
                      $("#modal-checkout-cancel").openModal();


            $(document).on("click", ".try-again-paypal", function (e) {
                paypal.checkout.initXO();
                var vacancy = JSON.parse($(this).attr("paypal-data-vacancy"));

                var action = $.post('/checkout/paypal?vacancyId=' + vacancy.id, vacancy);

                action.done(function (data) {
                    paypal.checkout.startFlow(data.token);
                });

                action.fail(function () {
                    paypal.checkout.closeFlow();
                });
            });


            <?php }
            ?>


        });


    </script>
@endsection