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
                    <div class="btn load-photos right red" data-img-source="#logo_src"
                         data-id-company="@if(isset($company['id'])){{$company['id']}}@endif"
                         data-destination-url="#logo">
                        <span>Upload company photos</span>
                    </div>
                </div>
            </div>
            <div class="col s9" style="margin-top:20px">
                <ol class="breadcrumbs">
                    <blockquote><b>Please upload a minimum of 3 photos of your
                        company's workspaces and your team (at least 1600x900)</b><br>
                        They will be used as cover of your Branding Page, to boost users’ engagement.<br>
                        You can drag and drop the photos to reorder them in your slider.
                    </blockquote>
                </ol>
            </div>
            <div class="col s9 photo-required <?php
            if( isset($company['sliders']) && count($company['sliders']) >= 3){
            ?>
                    hide            <?php } ?>">
                <div id="card-alert" class="card red">
                    <div class="card-content white-text">
                        <span class="count-photo">{{3-count($company['sliders'])}}</span>
                        photos required to activate your branding page
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

    <div class="section">
        <div class="col s12 m12 l6">
            <form method="POST" id="photogallery-form">
                <div style="width:100%" class="center">
                    <div class="preloader-wrapper big active loading center" style="margin-top:100px;display:none">
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


                <div class="row" id="sortable-wrapper">

                    @foreach($sliders as $key=>$slide)
                        @if($slide['visible']==true)
                            <div class="col m3 sortable ">
                                <a style="position: relative; margin-bottom: -70px;margin-left: 7px;"
                                   data-href="/elimina/slider/{{$slide['id']}}"
                                   data-method="GET" href="#"
                                   class="action-button btn-floating waves-effect waves-light"><i style="font-size: 1.3rem!important;"
                                            class="mdi-content-clear"></i></a>
                                <input type="hidden" name="id[]" value="{{$slide['id']}}">
                                <input class="order" type="hidden" name="order[]" value="{{$slide['ordering']}}">
                                <img src="{{$slide['link']}}" width="100%">
                            </div>
                        @endif
                    @endforeach
                </div>

            </form>


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


            $(".load-photos").click(function (e) {
                var button = $(this);
                filepicker.setKey("A8gsh1avRW6BM45L8W9tqz");


                filepicker.pickMultiple(
                        {
                            maxFiles: 50,
                            container: 'modal',
                            services: ['COMPUTER', 'GMAIL', 'DROPBOX', 'GOOGLE_DRIVE', 'SKYDRIVE', 'BOX', 'CLOUDDRIVE',"URL","WEBCAM","INSTAGRAM"],
                            mimetype: "image/*",
                            language: $("html").attr("lang")

                        },
                        function (Blobs) {

                            var dataToSend = {};
                            var dataindex = 0;

                            var validUpload = true;

                            $("#sortable-wrapper").hide();
                            $(".loading").show();

                            $.each(Blobs, function (key, value) {


                                filepicker.stat(
                                        value,
                                        {
                                            width: true,
                                            height: true
                                        },
                                        function (metadata) {
                                            if (metadata.width < 1600) {

                                                swal("Resolution minimum error", value.filename + " should be at least 1600x900 pixel to upload in your branding page.", "error");
                                                validUpload = false;

                                                $("#sortable-wrapper").show();
                                                $(".loading").hide();

                                                return false;
                                            } else {

                                                dataToSend = [{
                                                    "link": value.url,
                                                    "name": value.filename,
                                                    "visible": 1,
                                                    "status": 1,
                                                    "ordering": key + 1,
                                                    "company": {
                                                        "id": $(".load-photos").attr("data-id-company")
                                                    }
                                                }];

                                                $.ajax({
                                                    method: "POST",
                                                    url: "/sliders",
                                                    data: JSON.stringify(dataToSend),
                                                    contentType: 'application/json',
                                                    success: function (data, textStatus, xhr) {

                                                        if (xhr.status == 200) {


                                                            $("#sortable-wrapper").show();
                                                            $(".loading").hide();

                                                            $("#sortable-wrapper").prepend(data);
                                                            $('#sortable-wrapper').sortable("refresh");
                                                            var countPhoto = parseInt($(".count-photo").html());

                                                            if (countPhoto - 1 <= 0) {
                                                                $(".photo-required").remove();
                                                            }
                                                            $(".count-photo").html(countPhoto - 1);
                                                        } else {


                                                        }

                                                    }
                                                });

                                            }
                                        }
                                );


                            });

                        },
                        function (FPError) {
                        }
                );
            });

            @if(isset($company['id']))
                        $('#sortable-wrapper').sortable({
                        placeholder: 'blank',
                        item: 'div.sortable',
                        opacity: 0.5,
                        forcePlaceholderSize: true,
                        stop: function (event, ui) {


                            $.each($('#sortable-wrapper .sortable'), function (index, value) {
                                $(this).find(".order").val(index + 1);
                            });


                            var params = $("#photogallery-form").serialize();

                            $.ajax({
                                method: "PATCH",
                                url: "/company/{{$company['id']}}/sliders",
                                data: params,
                                success: function (data, textStatus, xhr) {

                                    if (xhr.status == 204) {
                                        $('#sortable-wrapper').sortable("refresh");
                                    } else {


                                    }

                                }
                            });

                        }
                    }
            );
            @endif

        });


    </script>
@endsection