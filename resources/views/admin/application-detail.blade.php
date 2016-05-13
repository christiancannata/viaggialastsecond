@extends('template.admin_layout')

@yield('header')


@section('content')

    <div id="profile-page" class="section">
        <!-- profile-page-header -->
        <div id="profile-page-header " class="card hide-on-small-only">
            <div class="card-image waves-effect waves-block waves-light">
                @if(isset($application['vacancy']['company']["sliders"][0]["link"]))
                    <img class="activator company-background"
                         src="{{$application['vacancy']['company']["sliders"][0]["link"]}}" alt="user background">
                @endif
            </div>
            <figure class="card-profile-image" style="height:250px">
                <img src="{{$application['vacancy']['company']['logo_small']}}" alt="profile image"
                     class=" z-depth-2 responsive-img activator">
            </figure>
            <div class="card-content">
                <div class="row">
                    <div class="col s9 offset-s3">
                        <h4 class="card-title grey-text text-darken-4">{{$application['vacancy']['name']}}</h4>
                    </div>

                </div>
            </div>
            <div class="card-reveal">
                <p>
                    <span class="card-title grey-text text-darken-4">
                        {{$application['vacancy']['company']['name']}}<i
                                class="mdi-navigation-close right"></i></span>
                    @if(isset($application['vacancy']['company']['industry']))
                        <span>Industry: {{$application['vacancy']['company']['industry']['name']}}</span>
                    @endif
                </p>
                @if(isset($application['vacancy']['company']['vision']))
                    <p>{{substr($application['vacancy']['company']['vision'],0,70)}}</p>
                @endif
                @if(isset($application['vacancy']['company']['foundation_date']))
                    <p><i class="mdi-social-cake cyan-text text-darken-2"></i>{{trans('profile.fondata_nel')}}
                        <b>{{$application['vacancy']['company']['foundation_date']}}</b></p>
                @endif
            </div>
        </div>
        <div class="row hide-on-med-and-up">
            <div class="col s12">
                <h1>{{$application['vacancy']['name']}}</h1>
                <h2> {{$application['vacancy']['company']['name']}}
                   </h2>
                </div>
            </div>
        <!--/ profile-page-header -->

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
                            <div class="col s5 "><i
                                        class="mdi-social-domain"></i> {{trans('profile.luogo')}}</div>
                            <div class="col s7 grey-text text-darken-1 right-align">@if(isset($application['vacancy']['city_plain_text'])){{$application['vacancy']['city_plain_text']}}@endif
                            </div>
                        </div>

                    </li>
                    <li class="collection-item">
                        @if(isset($application['vacancy']['seniority']))
                            <div class="row">
                                <div class="col s5"><i
                                            class="mdi-social-domain"></i> {{trans('profile.seniority')}}</div>
                                <div class="col s7 grey-text text-darken-1 right-align">{{$application['vacancy']['seniority']}}
                                </div>
                            </div>
                        @endif
                    </li>

                    <?php

                    $link = null;
                    ?>
                    @if(isset($user["attachments"]) && !empty(end($user["attachments"])["link"]))
                        <?php
                        $cv = end($user["attachments"]);
                        $link = "/cv/" . base64_encode($cv["link"]);
                        ?>
                    @endif


                    @if(isset($application["cv"]["link"]) && $application["cv"]["link"]!="")
                        <?php

                        $link = "/cv/" . base64_encode($application["cv"]["link"]);
                        ?>
                    @endif

                    @if($link)
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s12">
                                    <a style="width:100%" target="_blank" class="download-cv" href="{{$link}}">
                                        <i class="mdi-file-file-download left"></i>
                                        <div class="grey-text text-darken-2 bold">Download CV</div>

                                    </a>
                                </div>
                            </div>
                        </li>
                    @endif

                    @if($application['cover_letter']!="")
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s12">

                                    <a target="_blank" class="download-cover-letter" style="margin-top:20px"
                                       href="{{$application['cover_letter']}}">
                                        <i class="mdi-file-file-download left"></i>
                                        <div class="grey-text text-darken-2 bold">Download Cover Letter</div>
                                    </a>
                                </div>
                            </div>
                        </li>

                    @else
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s12">

                                    <a href="javascript:;" style="width:100%" class="upload-cover-letter">
                                        <i class="mdi-file-file-download left"></i>
                                        <div class="grey-text text-darken-2 bold">Upload Cover Letter</div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>


                <!--/ Profile About Details  -->

                <!-- Profile About  -->

                @if($application['status']=="SENT")

                    <?php
                    $isRead=false;
                    foreach($application['events'] as $event){
                        if($event['status']=="READ"){
                            $isRead=true;
                        }
                        ?>

                               <?php } ?>
                @if($isRead)
                    <div class="card amber darken-4"
                     >
                        <div class="card-content white-text center-align">
                            <i class="mdi-image-remove-red-eye "></i>
                            <p>{{trans('profile.candidatura_letta')}}</p>
                        </div>
                    </div>
                @else
                            <div class="card amber darken-2 simple-tooltip" title="{{trans('profile.tooltip_inviata')}}" data-delay="50"
                                 data-position="bottom">
                                <div class="card-content white-text center-align">
                                    <i class="mdi-content-send "></i>
                                    <p>{{trans('profile.candidatura_inviata')}}<i class="mdi-action-help white-text" style="margin-left:10px"></i></p>
                                </div>
                            </div>

                    @endif
                    <div class="row">
                        <div class="col m12">
                            <a class="waves-effect waves-light red btn-large confirm-button" style="width:100%"
                               data-redirect="/user/applications"
                               data-href="/elimina/application/{{$application['id']}}"
                               data-method="GET"><i
                                        class="mdi-action-delete  left white-text"></i>{{trans('profile.elimina_candidatura')}}
                            </a>
                        </div>

                    </div>



                @elseif($application['status']=="STARRED")
                    <div class="card green darken-2 simple-tooltip" data-tipped-options="size: 'large'"
                         title="{!! trans('profile.tooltip_accettato') !!}"
                        >
                        <div class="card-content white-text center-align">
                            <i class="mdi-action-thumb-up white-text"></i>
                            <p>{{trans('profile.candidatura_positiva')}}<i class="mdi-action-help white-text" style="margin-left:10px"></i></p>


                        </div>
                    </div>
                @elseif($application['status']=="SENT" && $application['active']==false)
                    <div class="card red darken-2 simple-tooltip" title="{{trans('profile.tooltip_uncompleted')}}"
                         >
                        <div class="card-content white-text center-align">
                            <i class="mdi-action-report-problem white-text"></i>
                            <p>{{trans('profile.candidatura_non_completa')}}<i class="mdi-action-help white-text" style="margin-left:10px"></i></p>
                            <i class="mdi-action-help white-text"></i>
                        </div>
                    </div>
                @elseif($application['status']=="REJECTED")
                    <div class="card red darken-2 simple-tooltip" title="{{trans('profile.tooltip_rifiutato')}}" data-delay="50"
                         data-position="bottom">
                        <div class="card-content white-text center-align">
                            <i class="mdi-action-thumb-down white-text"></i>
                            <p>{{trans('profile.candidatura_ko')}}<i class="mdi-action-help white-text" style="margin-left:10px"></i></p>
                        </div>
                    </div>

                    @endif

                            <!--Avatar Content-->
                    <div class="row" style="margin-top:20px">
                        <div class="col s12 m12 l12">
                            <p class="header">{{trans('profile.storico')}}</p>
                        </div>
                        <div class="col s12 m12 l12">

                            <ul class="collection">
                                @foreach(array_reverse($application['events']) as $event)
                                    @if(!empty($event['author']))
                                        <li class="collection-item avatar">

                                            <span class="title">{{$event['comment']}}</span>
                                            <p><!--{{$event['author']['first_name'] }} {{$event['author']['last_name'] }}
                                                <br>-->
                                            <span class="ultra-small">{{trans('profile.inserito_il')}}
                                                <b>{{date('d-m-Y', strtotime($event['created_at']))}}</b></span>
                                            </p>
                                            <a href="#!" class="secondary-content"><i class="mdi-action-grade"></i></a>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>

                        </div>
                    </div>


            </div>
            <!-- profile-page-sidebar-->

            <!-- profile-page-wall -->
            <div id="profile-page-wall" class="col s12 m8">

                <!--work collections start-->
                <div id="work-collections" class="seaction">

                    <div class="row">
                        <div class="col s12 m12 l12">

                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card light">
                                        <div class="card-content black-text">
                                            <p>
                                                {!!  $application['vacancy']['description']!!}
                                            </p>


                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Floating Action Button -->
                </div>
            </div>
            <!--/ profile-page-wall -->

        </div>
    </div>
    </div>

@endsection




@section('custom-js')


    <script type="text/javascript">


        $(document).ready(function () {


            $(".confirm-button").click(function () {
                var button = $(this);

                swal({
                            title: "Remove Application",
                            text: "Click on \"Ok\" to remove your application",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "",
                            closeOnConfirm: false
                        },
                        function () {
                            $("button").attr("disabled",true);
                            $.ajax({
                                url: button.attr("data-href"),
                                dataType: 'json',
                                type: button.attr("data-method"),
                                success: function (data, jqXHR) {
                                    $("button").attr("disabled",false);

                                    Materialize.toast('Deleted Successfully!', 2000, '', button.attr("callback"));
                                    if (button.closest("tr").length) {
                                        button.closest("tr").fadeOut();
                                    }
                                    if (button.closest("li").length) {
                                        button.closest("li").fadeOut();
                                    }

                                    if (button.closest(".row[data-update-route]").length) {
                                        button.closest(".row[data-update-route]").fadeOut();
                                    }



                                    swal("Item deleted!", "", "success");

                                    location.href = "/user";

                                },
                                error: function (data, jqXHR) {
                                    $("button").attr("disabled",false);

                                }
                            });


                        });
            });



            //  $('.darken-2').tooltip({delay: 50});
            Tipped.create('.simple-tooltip',{
                size:"large"
            });

            $(".upload-cover-letter").click(function (e) {
                var button = $(this);
                filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");


                filepicker.pick(
                        {
                            maxFiles: 1,
                            container: 'modal',
                            services: ['COMPUTER', 'GMAIL', 'DROPBOX', 'GOOGLE_DRIVE', 'SKYDRIVE', 'BOX', 'CLOUDDRIVE'],
                            extensions: ['.png', '.tiff', '.jpg', '.jpeg', '.gif', '.doc', '.docx', '.pdf', '.ods'],
                            language: $("html").attr("lang"),
                            customText: 'https://app.meritocracy.is/includes/filepicker-meritocracy-translations'
                        },
                        function (Blobs) {


                            $.ajax({
                                type: "POST",
                                url: "/application/{{$application['id']}}",
                                data: {"cover_letter": Blobs.url},
                                success: function (data, textStatus, xhr) {
                                    location.href = '';
                                },
                                error: function (data, textStatus, xhr) {

                                },
                                dataType: "json"
                            });


                        },
                        function (FPError) {
                        }
                );
            });


        });


    </script>
@endsection
