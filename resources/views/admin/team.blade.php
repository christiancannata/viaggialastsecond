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
            <div class="col s9 m9 l9">
                <h5 class="breadcrumbs-title">HR Dashboard</h5>

            </div>
            <div class="col s3 m3 l3">

                <div class="file-field input-field ">
                    <div class="btn insert-member-team right"
                         data-id-company="@if(isset($company['id'])){{$company['id']}}@endif"
                    >
                        <span>Insert New Member Team</span>
                    </div>
                </div>
            </div>
            <div class="col s12" style="margin-top:20px">
                <ol class="breadcrumbs">
                    <li>Here you can upload pictures of your team members. They will appear at the bottom of your Branding Page.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

    <div class="section">
        <div class="col s12 m12 l6">
            <div class="col col-md-16">


                <div class="row team-container" id="team">
                    @foreach($company['team'] as $team)
                        <div class="col m2 l2 s8 sortable">
                            <div class="profile">
                                <a style="position: relative;margin-top:20px"
                                   data-href="/elimina/member-team/{{$team['id']}}"
                                   data-method="GET" href="#"
                                   class="action-button btn-floating waves-effect waves-light close-small-button"><i
                                            class="mdi-content-clear"></i></a>


                                <a style="position: relative;margin-top:20px" data-id="{{$team['id']}}"
                                   href="#"
                                   class=" modify-member-team btn-floating waves-effect waves-light close-small-button"><i
                                            class="mdi-editor-mode-edit"></i></a>


                                <img src="{{$team["photo"]}}" class="image" style="width:100%">

                                <p class="name">{{$team["name"]}}</p>

                                <p class="role">{{$team["role"]}}</p>

                                <div class="social">
                                    <ul class="soc-no-action">
                                        <li><a target="_blank" class="soc-linkedin"
                                               href="{{$team["linkedin_url"]}}">Linkedin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>






    <!-- Compose Email Structure -->
    <div id="modal-new-team" class="modal std-modal">
        <div class="modal-content">
            <nav class="red color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>

                            <li><a lang="en" href="#!" class="email-type">Add a new member team</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result">
            <div class="row">


                <form id="new-member" class="col s12" method="POST" action="">

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
                                <input name="name" id="vacancyAddName" type="text" class="validate">
                                <label lang="en" for="vacancyAddName">Name</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input name="role" id="vacancyAddName" type="text" class="validate">
                                <label lang="en" for="vacancyAddName">Role</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input name="linkedin_url" id="vacancyAddName" type="text" class="validate">
                                <label lang="en" for="vacancyAddName">Linkedin Url</label>
                            </div>
                        </div>
                        <input type="hidden" name="photo" id="photo_src">

                        <div class="row">
                            <div class="input-field col s6">

                                <div class="btn load-photos left" data-img-source="#photo_src"
                                     data-id-company="@if(isset($company['id'])){{$company['id']}}@endif"
                                     data-destination-url="#member-photo">
                                    <span>Upload a photo</span>
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <img id="member-photo" style="width:60%" src="">
                            </div>
                        </div>

                        <div class="input-field col s12">
                            <button lang="en" class="btn waves-effect waves-light right red submit btn-add-vacancy"
                                    type="submit"
                                    name="action">Add Member<i class="mdi-content-add right"></i>
                            </button>
                        </div>

                    </div>

                    <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                         class="center form-result animated fadeIn">
                        <div class="white-text">
                            <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Member created
                            </h4>
                            <h6 lang="en">The member team has been created succesfully.<br></h6>
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
                            <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to add member
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

                    <input type="hidden" name="company[id]" value="{{Auth::user()->company['id']}}"

                </form>
            </div>
        </div>


    </div>







    <!-- Compose Email Structure -->
    <div id="modal-modify-team" class="modal std-modal">
        <div class="modal-content">
            <nav class="red color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>

                            <li><a lang="en" href="#!" class="email-type">Modify new member team</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result">
            <div class="row">

                <input type="hidden" value="" id="id_member">

                <form id="modify-member" class="col s12" method="POST" action="">


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
                                <input name="name" id="vacancyAddName" type="text" class="validate">
                                <label lang="en" for="vacancyAddName">Name</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input name="role" id="vacancyAddName" type="text" class="validate">
                                <label lang="en" for="vacancyAddName">Role</label>
                            </div>
                        </div>
                        <input type="hidden" name="company[id]" value="{{Auth::user()->company['id']}}"
                        <div class="row">
                            <div class="input-field col s12">
                                <input name="linkedin_url" id="vacancyAddName" type="text" class="validate">
                                <label lang="en" for="vacancyAddName">Linkedin Url</label>
                            </div>
                        </div>
                        <input type="hidden" name="photo" id="photo_src">

                        <div class="row">
                            <div class="input-field col s6">

                                <div class="btn load-photos left" data-img-source="#modify-member #photo_src"
                                     data-id-company="@if(isset($company['id'])){{$company['id']}}@endif"
                                     data-destination-url="#modify-member #member-photo">
                                    <span>Upload a photo</span>
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <img id="member-photo" style="width:60%" src="">
                            </div>
                        </div>

                        <div class="input-field col s12">
                            <button lang="en" class="btn waves-effect waves-light right red submit btn-add-vacancy"
                                    type="submit"
                                    name="action">Modify Member<i class="mdi-content-add right"></i>
                            </button>
                        </div>

                    </div>

                    <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                         class="center form-result animated fadeIn">
                        <div class="white-text">
                            <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Member modified
                            </h4>
                            <h6 lang="en">The member team has been modified succesfully.<br></h6>
                        </div>
                        <div class="button-action">
                            <button type="button" lang="en"
                                    class="waves-effect waves-light green darken-2 btn modal-close">
                                Close
                            </button>
                        </div>

                    </div>

                    <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                         class="center form-result-error animated fadeIn">
                        <div class="white-text">
                            <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to modify member
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


            $(".modify-member-team").click(function (e) {

                e.preventDefault();

                $("#id_member").val($(this).attr("data-id"));


                $("#modal-modify-team input[name=name]").val($(this).parent().find(".name").text());
                $("#modal-modify-team input[name=role]").val($(this).parent().find(".role").text());
                $("#modal-modify-team input[name=photo]").val($(this).parent().find(".image").attr("src"));
                $("#modal-modify-team img").attr("src", $(this).parent().find(".image").attr("src"));
                $("#modal-modify-team input[name=linkedin_url]").val($(this).parent().find(".soc-linkedin").attr("href"));

                $("#modal-modify-team .form-content label").addClass("active");

                $("#modal-modify-team").openModal({
                    ready: function () {


                    },
                    complete: function () {
                    }
                });


            });


            $(".insert-member-team").click(function (e) {

                $("#modal-new-team").openModal({
                    ready: function () {


                    },
                    complete: function () {
                    }
                });


            });


            $(".load-photos").click(function (e) {
                var button = $(this);
                filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");


                filepicker.pick(
                        {
                            maxFiles: 1,
                            container: 'window',
                            services: ['COMPUTER', 'GMAIL', 'DROPBOX', 'GOOGLE_DRIVE', 'SKYDRIVE', 'BOX', 'CLOUDDRIVE'],
                            extensions: ['.png', '.tiff', '.jpg', '.jpeg', '.gif'],
                            language: $("html").attr("lang"),
                            customText: 'https://app.meritocracy.is/includes/filepicker-meritocracy-translations'
                        },
                        function (Blobs) {
                            $(button.attr("data-destination-url")).attr("src", Blobs.url);
                            $(button.attr("data-img-source")).attr("value", Blobs.url);


                        },
                        function (FPError) {
                        }
                );
            });


            $("#new-member").submit(function (e) {
                e.preventDefault();

                var params = $("#new-member").find("input").serialize();

                $("#new-member input[type=submit]").button('loading');

                $.ajax({
                    type: "POST",
                    url: "/company/{{$company['id']}}/add-member",
                    data: params,
                    success: function (data, textStatus, xhr) {
                        if (xhr.status == 201 || xhr.status == 204) {
                            location.href = '';
                        } else {
                            $("#new-member input[type=submit]").button('reset');
                            alert(data.responseJSON.message);
                        }
                    },
                    error: function (data, textStatus, xhr) {
                        $("#new-member input[type=submit]").button('reset');
                        alert(data.responseJSON.message);
                    },
                    dataType: "json"
                });
            });


            $("#modify-member").submit(function (e) {
                e.preventDefault();

                var params = $("#modify-member").find("input").serialize();

                $("#modify-member input[type=submit]").button('loading');

                $.ajax({
                    type: "PATCH",
                    url: "/company/member/" + $("#id_member").val(),
                    data: params,
                    success: function (data, textStatus, xhr) {
                        if (xhr.status == 201 || xhr.status == 204) {
                            location.href = '';
                        } else {
                            $("#modify-member input[type=submit]").button('reset');
                        }
                    },
                    error: function (data, textStatus, xhr) {
                        $("#modify-member input[type=submit]").button('reset');
                    },
                    dataType: "json"
                });
            });


        });


    </script>
@endsection