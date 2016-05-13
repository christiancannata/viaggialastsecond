@extends('template.admin_layout')

@yield('header')

@section('page-css')
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/css/jquery-ui.min.css" rel="stylesheet">
<link href="/css/jquery-ui.theme.min.css" rel="stylesheet">
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
                <h5 class="breadcrumbs-title">Archive Vacancies</h5>
                <ol class="breadcrumbs">
                    <li><a href="/hr">Dashboard</a></li>
                    <li>Archive Vacancies</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

    <div class="section">

        <div data-count="" data-other="" id="vacancies">
            <div class="col s12 m8 l9">

                @foreach($vacancies as $vacancy)
                    @if($vacancy["is_visible"]==false)
                    <div data-vacancy-id="{{$vacancy["id"]}}" id="vacancy-{{$vacancy["id"]}}" class="card">
                            <input type="hidden" value="{{json_encode($vacancy)}}" id="vacancy-data-{{$vacancy["id"]}}">
                            <div class="card-content">
                                <div class="card-title activator grey-text text-darken-4 bold">
                                    <span>{{$vacancy["name"]}}</span>
                                    <ul style="display: inline-block; margin-left: 20px;" class="card-subtitle">
                                        <li>
                                            <div class="chip2 red white-text">Closed</div>
                                        </li>
                                        @if(isset($vacancy["city_plain_text"]))
                                            <li>
                                                <div class="chip2">{{ $vacancy["city_plain_text"] }} </div>
                                            </li>
                                        @endif
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
                                                <div class="chip2">{{ $vacancy["industry"]["name"] }} <i
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
                                                        class="mdi-action-thumb-up  material-icons "></i> {{$vacancy['total_application']['liked']}}</div>
                                        </li>

                                        <li> <div class="chip2 red white-text"><i
                                                        class="mdi-action-thumb-down  material-icons "></i> {{$vacancy['total_application']['disliked']}}</div>
                                        </li>


                                    </ul>

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
                                   <li>
                                        <a data-name="{{$vacancy["name"]}}" data-id="{{$vacancy["id"]}}"
                                           class="red-text vacancy-open"><i class="mdi-navigation-open"></i>&nbsp;Reopen</a>
                                    </li>
                                    <li><a class="vacancy-sort red-text"><i class="mdi-editor-wrap-text"></i>&nbsp;Order</a>
                                    </li>

                                </ul>
                                <a style="position: absolute;top: 40px;right: 10px; font-size: 30px;" href="#!"
                                   class="dropdown-button waves-effect waves-light black-text"
                                   data-activates="dropdown-vacancy-{{$vacancy["id"]}}">
                                    <i class="mdi-navigation-more-vert right"></i>
                                </a>




                            </div>
                            <div class="card-action">
                                <a href="/hr/{{$vacancy["permalink"]}}?company-id={{\Illuminate\Support\Facades\Auth::user()->company['id']}}" class="btn waves waves-light waves-effect red"
                                   lang="en" target="_blank">View candidates (<span class="total-application"
                                                                                    data-id-vacancy="{{$vacancy['id']}}">{{$vacancy['total_application']['total']}}</span>)</a>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>


        <!--card stats end-->
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>

    @if(!empty($vacancies))
            <!-- Floating Action Button -->
    <div class="fixed-action-btn default-action-btn" style="bottom: 50px; right: 19px;">
        <a class="btn-floating btn-large red">
            <i class="mdi-content-add"></i>
        </a>
        <ul>
            <li><a href="#modal-new-vacancy" class="btn-floating red modal-trigger"><i
                            class="large mdi-action-work"></i></a></li>
            <li><a href="#modal-" class="btn-floating blue   darken-1"><i
                            class="large mdi-content-create"></i></a></li>

        </ul>
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




    <!-- Edit vacancy -->
    <div id="modal-edit-vacancy" class="modal std-modal">
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
                        <p class="">
                            You can edit your vacancy here. If you need to add or change the preferred languages for
                            this vacancy, please contact us
                        </p>
                        <div class="row">
                            <div class="input-field col s12">
                                <input placeholder="iOs Developer" name="vacancyEditName" id="vacancyEditName"
                                       type="text" class="validate">
                                <label lang="en" for="vacancyEditName">Name</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <textarea placeholder="For our headquarter, we are looking for..."
                                          name="vacancyEditDescription" id="vacancyEditDescription"
                                          class="materialize-textarea"
                                          length="9000"></textarea>
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


                        <div class="row">

                            <div class="input-field col s12 m12">
                                <input type="hidden" name="city[id]" class="address_city_id"
                                       value="@if(isset($company['city'])){{$company['city']['id']}}@endif" id="work_city_id">
                                <input  id="luogo_lavoro_1" name="city_plain_text" type="text"
                                        class="required validate address_city" value="@if(isset($company['city'])){{$company['city']['name']}}@endif" required>
                                <label for="luogo_lavoro_1">{{ trans('company-page.citta') }}</label>
                            </div>

                        </div>


                        <div class="row">
                            <div class="input-field col s12">
                                <input placeholder="2016-01-01" class="date-input-format" name="vacancyEditDate"
                                       id="vacancyEditDate" type="text">
                                <label lang="en" for="vacancyEditDate">Opening date</label>
                            </div>
                        </div>


                        <div class="input-field col s12">
                            <button lang="en" class="btn waves-effect waves-light right red submit" type="submit"
                                    name="action">Save changes
                                <i class="mdi-content-save right"></i>
                            </button>
                        </div>

                    </div>


                </form>
            </div>
        </div>

    </div>
    @endif


@endsection

@section('page-scripts')
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript" src="/admin/js/hr.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/formatter/jquery.formatter.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            HR.init();
        });


    </script>
@endsection