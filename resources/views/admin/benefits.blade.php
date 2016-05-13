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
                    <a href="#modal-benefit" class="btn red right modal-trigger"
                         data-id-company="@if(isset($company['id'])){{$company['id']}}@endif">
                        <span>Add Benefit</span>
                    </a>
                </div>
            </div>
            <div class="col s12" style="margin-top:20px">
                <ol class="breadcrumbs">
                    <li>Here you can add or manage your benefits. They will appear at the bottom of your Branding Page.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

    <div class="section">


                <div class="row benefits-container">
                    <div style="margin-top: 50px; margin-bottom: 50px;"
                         class="col s12 m12 l12 center benefits-loader">
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
                    <div id="benefits"></div>
                </div>
    </div>






    <!-- Compose Benefit Structure -->
    <div id="modal-benefit" class="modal std-modal">
        <div class="modal-content">
            <nav class="red color-result darken-1">
                <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>

                            <li><a lang="en" href="#!" class="email-type">Add a new benefit</a>
                            </li>
                        </ul>
                    </div>


                </div>
            </nav>
        </div>
        <div class="model-email-content color-result">
            <div class="row">

                <div style="height: 20px;" class="clear"></div>

                <form id="new-benefit" class="col s12" method="POST" action="">

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
                                <input name="name" id="addBenefit" type="text" class="validate">
                                <label lang="en" for="addBenefit">Name</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <select id="iconBenefit" name="icon" class="icons">
                                    <option value="" disabled selected>Choose your option</option>
                                    <option value="bar.png" data-icon="/img/bar.png" class="left circle">For Restaurant, Bar or Canteen</option>
                                    <option value="birthday.png" data-icon="/img/birthday.png" class="left circle">For Birthday, parties</option>
                                    <option value="blackLanguage.png" data-icon="/img/blackLanguage.png" class="left circle">For languages & cultural opportunities</option>
                                    <option value="children.png" data-icon="/img/children.png" class="left circle">For Children</option>
                                    <option value="entertaiment.png" data-icon="/img/entertaiment.png" class="left circle">For Entertainment purpose</option>
                                    <option value="flexible.png" data-icon="/img/flexible.png" class="left circle">For Gym & Fitness</option>
                                    <option value="games.png" data-icon="/img/games.png" class="left circle">For VideoGames & Games</option>
                                    <option value="health.png" data-icon="/img/health.png" class="left circle">For Healthcare</option>
                                    <option value="performance_bonus.png" data-icon="/img/performance_bonus.png" class="left circle">For Company and Performance Bonus</option>
                                    <option value="phone.png" data-icon="/img/phone.png" class="left circle">For Company Phone</option>
                                </select>
                                <label for="iconBenefit">Icon</label>
                            </div>
                        </div>

                        <div style="height: 80px;" class="clear"></div>



                        <div class="input-field col s12">
                            <button lang="en" class="btn waves-effect waves-light right red submit btn-add-vacancy"
                                    type="submit"
                                    name="action">Add Benefit<i class="mdi-content-add right"></i>
                            </button>
                        </div>


                    </div>

                    <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                         class="center form-result animated fadeIn">
                        <div class="white-text">
                            <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Benefit created
                            </h4>
                            <h6 lang="en">The benefit has been added succesfully.<br></h6>
                        </div>
                        <div class="button-action">
                            <button type="button" data-form="new-benefit" lang="en"
                                    class="waves-effect waves-light green darken-2 btn form-recreate-modal-benefit">Add
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
                            <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to add benefit
                            </h4>
                            <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                        </div>
                        <div class="button-action">
                            <button type="button" data-form="new-benefit" lang="en"
                                    class="waves-effect waves-light red darken-2 btn form-recreate-modal-benefit">Edit data
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

        function getBenefits(){
            $(".benefits-loader").show();
            $("#benefits").hide();

            $.get("/hr/benefits/list", function (data) {
                $("#benefits").html(data).show();
                $(".benefits-loader").hide();
            });
        }

        $(document).ready(function () {
            HR.init();
            getBenefits();


            $(".modify-benefit").click(function (e) {

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


            $("#new-benefit").submit(function (e) {
                e.preventDefault();

                var form =  $("#new-benefit");
                var params = $("#new-benefit").serialize();

                $("#modal-benefit").find(".color-result").removeClass("red").removeClass("green");

                $(form).find(".form-result-error,.form-result,.form-result-clone,.form-result-error-clone,.form-content").hide();

                $(form).find(".form-loader").show();


                $.ajax({
                    type: "POST",
                    url: "/company/{{$company['id']}}/add-benefit",
                    data: params,
                    success: function (data, textStatus, xhr) {
                        $(form).find(".form-loader").hide();

                        if (xhr.status == 201 || xhr.status == 204) {
                            $(form).find(".form-result").show();
                            $("#modal-benefit").find(".color-result").removeClass("red").addClass("green");
                            getBenefits();
                        } else {
                            Raven.captureMessage("[HR] Unable to add a Benefit");
                            Raven.setExtraContext({
                                "Ajax data": data,
                                "Ajax ajaxOptions": textStatus,
                                "Ajax thrownError": xhr
                            });
                            Raven.showReportDialog();
                        }
                    },
                    error: function (data, textStatus, xhr) {
                        $(form).find(".form-loader").hide();

                        $(form).find(".form-result-error").show();
                        $("#modal-benefit").find(".color-result").addClass("red");
                        Raven.captureMessage("[HR] Unable to add a Benefit");
                        Raven.setExtraContext({
                            "Ajax data": data,
                            "Ajax xhr": xhr,
                            "Ajax textStatus": textStatus
                        });
                        Raven.showReportDialog();
                    },
                    dataType: "json"
                });
            });



            $(".form-recreate-modal-benefit").on("click", function () {
                var form = $(this).attr("data-form");
                form = $("#" + form);
                form.find(".form-loader,.form-result,.form-result-error").hide();
                form.find(".form-content").fadeIn().find("input,textarea,select").removeClass("valid");
                $("#modal-benefit").find(".color-result").removeClass("green").removeClass("red");
                $('.modal').animate({scrollTop: 0}, 'slow');
            });


        });


    </script>
@endsection