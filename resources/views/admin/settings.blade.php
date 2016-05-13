@extends('template.admin_layout')

@section('breadcrumbs')

        <!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <!-- Search for small screen -->
    <div class="header-search-wrapper grey hide">
        <i class="mdi-action-search active"></i>
        <input type="text" name="Search" class="header-search-input z-depth-2 "
               placeholder="Search for candidates">
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">{{trans('profile.settings')}}</h5>
                <ol class="breadcrumbs">
                    @if(\Illuminate\Support\Facades\Auth::user()->type=="COMPANY" || \Illuminate\Support\Facades\Auth::user()->type=="ANALYTICS")

                        <li><a href="/hr">Dashboard</a></li>
                    @else
                        <li><a href="/user/profile">User Profile</a></li>

                    @endif
                    <li>Settings</li>

                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

        <!-- START CONTENT -->
<section id="content">


    <!--start container-->
    <div class="container">
        <div id="basic-form" class="section">

            <div class="row">
                <h4 class="header">{{trans('settings.preferences')}}</h4>

                <div class="col s12 m4 l3">
                     <span class="col s11 m11 l11">{{trans('settings.password_description')}}</span>
                </div>
                <div class="col s12 m8 l9">
                    <form  id="change-password-form">

                        <div class="row">
                            <div class="input-field col s3 ">
                                <input id="vecchia_password" name="vecchia_password" type="password"
                                       class="validate" required>
                                <label for="vecchia_password">{{trans('settings.old_password')}}</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="nuova_password" name="nuova_password" type="password" class="validate"
                                       required>
                                <label for="nuova_password">{{trans('settings.new_password')}}</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="conferma_nuova_password" name="conferma_nuova_password" type="password"
                                       class="validate" required>
                                <label for="conferma_nuova_password">{{trans('settings.conferma_nuova_password')}}</label>
                            </div>
                            <div class="input-field col s3">
                                <button class="btn cyan waves-effect waves-light" type="submit"
                                        name="action">{{trans('settings.modify_password')}}
                                </button>
                            </div>
                            <div class="col s12 message">
                                </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
        <div class="divider"></div>

        @if(\Illuminate\Support\Facades\Auth::user()->type=="USER")
            <div class="section">
                <div class="row">

                    <h4 class="header">{{trans('settings.account_settings')}}</h4>
                    <div class="col s12 m3 l3">
                        <span class="col s11 m11 l11">{{trans('settings.account_settings_description')}}</span>
                    </div>
                    <div class="col s12 m8 l9">
                        <div class="">
                            <div class="row">

                                <!-- Switch -->
                                <div  class="switch">
                                    <span style="margin-right: 65px;">{{trans('settings.push_notif')}}</span>


                                    <label>
                                        {{trans('settings.push_notif_not_active')}}
                                        <input type="checkbox" class="active-push">
                                        <span class="lever"></span> {{trans('settings.push_notif_active')}}
                                    </label>
                                    <div class="clear"></div><br>
                                    <label style="font-size: 0.9rem!important;" class="col s6 m6 l6">{{trans('settings.notif_little')}}</label>
                                </div>

                                <br><br><br>

                                <form class="col s12" id="delete-account-form">

                                    <div class="row">
                                        {{trans('settings.title_cancel_profile')}}

                                                <button style="margin-left: 30px;" class="btn cyan waves-effect waves-light" type="submit"
                                                        name="action"> {{trans('settings.delete_profile')}}
                                                </button>
                                    </div>
                                </form>

                                <div class="clear"></div><br>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Auth::user()->type=="ANALYTICS" || \Illuminate\Support\Facades\Auth::user()->type=="ADMINISTRATOR")
            <div class="section">
                <div class="row">
                    <h4 class="header">{{trans('settings.visibility_title')}}</h4>
                    <div class="col s12 m4 l3">
                        <p>{{trans('settings.visibility_description')}}</p>
                    </div>
                    <div class="col s12 m8 l9">
                        <div id="input-switches" class="section">
                            <div class="row">
                                <div class="col s12 m8 l9">
                                    <!-- Switch -->
                                    <div class="switch">
                                        {{trans('settings.visibility_enabled')}}
                                        <label>
                                            {{trans('settings.not_publish')}}<input type="checkbox"
                                                                                    id-company="{{\Illuminate\Support\Facades\Auth::user()->company['id']}}"
                                                                                    class="active-company"
                                                                                    @if(\Illuminate\Support\Facades\Auth::user()->company['is_visible']==true) checked @endif>
                                            <span class="lever"></span> {{trans('settings.publish')}}
                                        </label>
                                    </div>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

            @if(\Illuminate\Support\Facades\Auth::user()->type=="COMPANY" || \Illuminate\Support\Facades\Auth::user()->type=="ANALYTICS")
                    <!-- Inline form with placeholder -->

            <div class="divider"></div>

            <div class="section">
                <div class="row">

                    <h4 class="header">{{trans('settings.feedback_template_title')}}</h4>
                    <div class="col s12 m4 l3">
                        <p>{{trans('settings.feedback_template_description')}}</p>
                    </div>
                    <div class="col s12 m8 l9">
                        <div class="row">
                            <div class="col s12 m8 l9">
                                @if(isset($user["feedback"]) && count($user["feedback"]) > 0)
                                    <ul class="collapsible popout feedbacks" data-collapsible="accordion">
                                        @foreach ($user["feedback"] as $singleFeedback)
                                            <li id="feedback-{{$singleFeedback["id"]}}">

                                                <div class="collapsible-header ">

                                                    @if($singleFeedback["type"] == "LIKED")
                                                        <i class="mdi-action-thumb-up"></i>
                                                    @elseif($singleFeedback["type"] == "DISLIKED")
                                                        <i class="mdi-action-thumb-down"></i>
                                                    @elseif($singleFeedback["type"] == "HIRED")
                                                        <i class="mdi-action-alarm-on"></i>
                                                    @endif
                                                    {{$singleFeedback["title"]}}
                                                </div>
                                                <div style="background-color: #fafafa;"
                                                     class="collapsible-body">
                                                    <p>{{$singleFeedback["description"]}}
                                                        <br><br>
                                                        <button data-id="{{$singleFeedback["id"]}}"
                                                                class="btn  waves-effect waves-light left red remove-feedback">
                                                            Remove
                                                        </button>
                                                        <br>
                                                    </p>

                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                    <a href="#modal-new-feedback"
                                       class="btn-floating btn-large waves-effect waves-light red right modal-trigger"><i
                                                class="mdi-content-add "></i></a>
                                @else

                                    <div id="card-alert" class="card white lighten-1">
                                        <div class="card-content black-text ">
                                            <span class="card-title black-text ">{{trans('settings.feedback_empty_title')}}</span>
                                            <p>{{trans('settings.feedback_empty_description')}}</p>
                                        </div>
                                        <div class="card-action white darken-1">
                                            <a href="#modal-new-feedback"
                                               class="waves-effect waves-light red btn white-text modal-trigger">{{trans('settings.feedback_empty_add')}}</a>
                                        </div>
                                    </div>

                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL NEW FEEDBACK !-->

            <div id="modal-new-feedback" class="modal std-modal">
                <div class="modal-content">
                    <nav class="red color-result darken-1">
                        <div class="nav-wrapper">
                            <div class="left col s12 m5 l5">
                                <ul>

                                    <li><a lang="en" href="#!" class="email-type">Add a feedback for your candidates</a>
                                    </li>
                                </ul>
                            </div>


                        </div>
                    </nav>
                </div>
                <div class="model-email-content color-result">
                    <div class="row">


                        <form id="new-feedback" class="col s12" method="POST" action="">

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
                                    <div class="input-field col  l12 m12 s12">
                                        <input required name="feedbackTitle" id="feedbackTitle" type="text" class="validate">
                                        <label lang="en" for="feedbackTitle">Title</label>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="input-field col  l12 m12 s12">
                                     <textarea class="materialize-textarea" name="feedbackDescription"
                                               id="feedbackDescription"
                                               length="9000" required></textarea>
                                        <label lang="en" for="feedbackDescription">Text (i.e. the body of your mail feedback)</label>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="input-field col l12 m12 s12">
                                        <select id="feedbackType" name="feedbackType" required>
                                            <option value="" disabled>Choose your option</option>
                                            <option lang="en" value="LIKED">Positive</option>
                                            <option lang="en" value="DISLIKED">Negative</option>
                                            <option lang="en" value="HIRED">Hire</option>
                                        </select>
                                        <label for="feedbackType" lang="en">Type</label>

                                    </div>
                                </div>


                                <div class="input-field col s12">
                                    <button lang="en"
                                            class="btn waves-effect waves-light right red submit btn-add-feedback"
                                            type="submit"
                                            name="action">Add feedback<i class="mdi-content-add right"></i>
                                    </button>
                                </div>

                            </div>

                            <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                                 class="center form-result animated fadeIn">
                                <div class="white-text">
                                    <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Feedback
                                        added
                                    </h4>
                                    <h6 lang="en">The feedback has been added succesfully.<br></h6>
                                </div>
                                <div class="button-action">
                                    <button type="button" data-form="new-feedback" lang="en"
                                            class="waves-effect waves-light green darken-2 btn form-recreate-modal">Add
                                        another
                                    </button>
                                    <button onclick="location.reload();" type="button" lang="en"
                                            class="waves-effect waves-light green darken-2 btn modal-close">
                                        Close
                                    </button>
                                </div>

                            </div>

                            <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                                 class="center form-result-error animated fadeIn">
                                <div class="white-text">
                                    <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to add
                                        feedback
                                    </h4>
                                    <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                                </div>
                                <div class="button-action">
                                    <button type="button" data-form="new-feedback" lang="en"
                                            class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit
                                        data
                                    </button>
                                    <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again
                                    </button>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>


            </div>
            <!-- END MODAL NEW FEEDBACK !-->


        @endif
    </div>

    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->


@endsection

@section('page-scripts')
    <script type="text/javascript" src="/js/main.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript" src="{{auto_version("/admin/js/settings.js")}}"></script>
    <script type="text/javascript" src="/admin/js/plugins/formatter/jquery.formatter.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            Settings.init();
        });


    </script>
@endsection