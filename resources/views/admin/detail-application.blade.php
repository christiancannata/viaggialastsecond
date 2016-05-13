@extends('template.admin_layout')

@yield('header')

@section('page-css')
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
      media="screen,projection">
<link href="/admin/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<!--jsgrid css-->
<link href="/admin/js/plugins/jsgrid/css/jsgrid.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="/admin/js/plugins/jsgrid/css/jsgrid-theme.min.css" type="text/css" rel="stylesheet"
      media="screen,projection">
<style>
    #main {
        padding-left: 0px !important;
    }

    .sidebar-collapse {
        display: block !important;
        margin-right: 20px !important;
        margin-top: -2px !important;
        background-color: transparent !important;
    }

    .brand-logo {
        margin-left: 45px !important;
    }

</style>
@endsection

@section('breadcrumbs')

        <!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <!-- Search for small screen -->
    <div class="header-search-wrapper grey hide">
        <i class="mdi-action-search active"></i>
        <input type="text" name="Search" class="header-search-input z-depth-2"
               placeholder="Search for candidates in {{$title}}">
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">HR Dashboard</h5>
                <ol class="breadcrumbs">
                    <li><a href="/hr">Dashboard</a></li>
                    <li>{{$title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')
    <input type="hidden" id="id_vacancy" value="{{$vacancy['id']}}">

    @if(!empty($vacancy['applications']))

        <div data-count="" data-other="" id="candidates">
            <div class="row">

                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs tab-demo-active z-depth-1 white">
                                <li class="tab col s3"><a lang="en" class="waves-effect active black-text"
                                                          href="#incoming"><b class="number"></b> Incoming</a>
                                </li>
                                <li class="tab col s3"><a lang="en" class="waves-effect black-text"
                                                          href="#liked"><b class="number"></b> Accepted</a>
                                </li>
                                <li class="tab col s3"><a lang="en" class="waves-effect black-text"
                                                          href="#disliked"><b class="number"></b> Rejected</a>
                                </li>
                                <li class="tab col s3"><a lang="en" class="waves-effect black-text"
                                                          href="#hired"><b class="number"></b> Hired</a>
                                </li>
                            </ul>
                        </div>
                        <div id="incoming" class="col s12 lighten-3">

                            <div class="col s2 m4 l4 card-panel z-depth-1">
                                <button class="btn  waves-effect waves-light right red btn-block date-order">Sort by
                                    date
                                </button>
                                <button style="display: none;"
                                        class="btn red  waves-effect waves-light right btn-block rank-order">Rank
                                    candidates
                                </button>

                                <div id="incoming-candidates-list" class="ajax-grid">

                                </div>
                            </div>

                            <div class="col s12 m8 l8">
                                <div id="incoming-candidate-detail">
                                    <h4>Select a candidate from the list</h4>
                                </div>
                            </div>
                        </div>


                        <div id="liked" class=" s12 lighten-3">
                            <div class="col s2 m4 l4 card-panel z-depth-1">
                                <div id="accepted-candidates-list" class="ajax-grid">
                                </div>
                            </div>

                            <div class="col s12 m8 l8">
                                <div id="accepted-candidate-detail">
                                    <h4>Select a candidate from the list</h4>
                                </div>
                            </div>
                        </div>


                        <div id="disliked"  class=" s12 lighten-3">
                            <div class="col s2 m4 l4 card-panel z-depth-1">
                                <div id="rejected-candidates-list" class="ajax-grid">
                                </div>
                            </div>

                            <div class="col s10 m8 l8">
                                <div id="rejected-candidate-detail">
                                    <h4>Select a candidate from the list</h4>

                                </div>
                            </div>
                        </div>


                        <div id="hired" class=" s12 lighten-3">
                            <div class="col s2 m4 l4 card-panel z-depth-1">
                                <div id="hired-candidates-list" class="ajax-grid">

                                </div>
                            </div>

                            <div class="col s10 m8 l8">
                                <div id="hired-candidate-detail">

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="col s6 m6 l6 offset-m3 offset-l3">
            <div class="card" style="cursor: pointer;">
                <div class="card-content grey lighten-1 white-text ">

                    <h5 class="card-stats-number center">No applications yet</h5>
                </div>

            </div>
        </div>
    @endif
    <input type="hidden" id="vacancy-id" value="{{  $vacancy['id'] }}">



    <!-- Compose Email Structure -->
    <div id="modal-request-cv" class="modal std-modal">
        <div class="modal-content">
            <nav class="red color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>
                            <li><a href="#!" class="email-menu"><i
                                            class="modal-action modal-close  mdi-hardware-keyboard-backspace"></i></a>
                            </li>
                            <li><a class="feedback-user-name" lang="{{App::getLocale()}}"
                                   class="email-type">Request CV to the candidate</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result">
            <div class="row">


                <form id="send-request-cv" data-id="" class="col s12">

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
                                <textarea name="comment" id="commentCv"
                                          class="materialize-textarea"
                                          length="1000">Dear candidate, please upload your CV to review your application</textarea>
                                <label lang="en" for="commentCv"></label>
                            </div>
                        </div>



                        <div class="input-field col s12">
                            <button lang="en" style="margin-right:15px;"
                                    class="btn waves-effect waves-light right green submit" type="submit"
                                    name="action">Send request
                                <i class="mdi-content-send right"></i>
                            </button>

                        </div>

                    </div>


                    <input class="id-application" value="" type="hidden">

                </form>
            </div>
        </div>


    </div>

    <!-- Compose Email Structure -->
    <div id="modal-application-event" class="modal std-modal">
        <div class="modal-content">
            <nav class="red color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>
                            <li><a href="#!" class="email-menu"><i
                                            class="modal-action modal-close  mdi-hardware-keyboard-backspace"></i></a>
                            </li>
                            <li><a class="feedback-user-name" lang="{{App::getLocale()}}"
                                   class="email-type">{{trans('hr.send_message_popup_subtitle')}}</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result">
            <div class="row">


                <form id="send-comment-application-event" data-id="" class="col s12">

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


                        @if(isset($feedback) && count($feedback) > 0)

                            <div class="row">
                                <div class="input-field col s12">
                                    <select id="_feedbackSelect" name="_feedbackSelect">
                                        <option value="" disabled
                                                selected>Select a template
                                        </option>
                                        @foreach($feedback as $singleFeedback )
                                            <option value="{{$singleFeedback['description']}}">{{$singleFeedback['title']}}</option>
                                        @endforeach
                                    </select>
                                    <label for="_feedbackSelect">Select a template for the feedback</label>

                                </div>
                            </div>
                        @else
                            <p>
                                <a href="/user/settings">
                                    You've not created your custom feedback templates yet. Start here.
                                </a>
                            </p>


                        @endif


                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="comment" id="commentApplication"
                                          class="materialize-textarea"
                                          length="1000"></textarea>
                                <label lang="en" for="commentApplication">Message</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <input type="checkbox" class="checkbox" id="feedbackSave" name="feedbackSave">
                                <label for="feedbackSave">Make this message as default feedback</label>
                            </div>
                        </div>

                        <input type="hidden" name="application_id" id="application_id" value="">


                        <div class="input-field col s12">
                            <button lang="en" class="btn waves-effect waves-light right red close-modal-application"
                                    onclick=''
                                    name="action">{{trans('hr.close_button_message')}}
                            </button>
                            <button lang="en" style="margin-right:15px;"
                                    class="btn waves-effect waves-light right green submit" type="submit"
                                    name="action">{{trans('hr.send_button_message')}}
                                <i class="mdi-content-send right"></i>
                            </button>

                        </div>

                    </div>

                    <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                         class="center form-result animated fadeIn">
                        <div class="white-text">
                            <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Message sent
                            </h4>
                            <h6 lang="en">The message was sent to the candidate</h6>
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
                            <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to send message
                            </h4>
                            <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                        </div>
                        <div class="button-action">

                            <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again</button>
                        </div>

                    </div>
                    <input class="id-application" value="" type="hidden">

                </form>
            </div>
        </div>


    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/jsgrid.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jsgrid/js/jsgrid-script.js"></script>
    <script type="text/javascript"
            src="{{auto_version("/admin/js/plugins/jsgrid/js/db.js")}}"></script>

    <script type="text/javascript"
            src="{{auto_version("/admin/js/vacancy-candidates.js")}}"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            VacancyCandidates.init();
        });


    </script>
@endsection