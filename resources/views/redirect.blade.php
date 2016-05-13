@extends('template.admin_layout')

@yield('header')

@section('page-css')
        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="/admin/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
<style>
    html{
        background: white!important;
    }
    #main {
        padding-left: 0!important;
    }
    @media only screen
    and (min-device-width: 1024px){
        #redirect-page {
            position: fixed;
            top: 50%;
            left: 50%;
            /* bring your own prefixes */
            transform: translate(-50%, -50%);
        }
    }
    #left-sidebar-nav{
        display: none;
    }
    #site-layout-example-right{
        height: 315px!important;
    }
    .header-search-wrapper{
        display: none;
    }
    .text{
        margin-top: 60px!important;
    }
    h5{
        font-size: 15px;
        text-align:center;
    }
    h1{
        font-size: 30px;
        text-align:center;
    }
    img.company-logo{
        max-width: 200px;
        max-height: 200px;
    }
    @-webkit-keyframes opacity {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }
    @-moz-keyframes opacity {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }



</style>
@endsection



@section('content')



    <div class="" id="redirect-page">

        <div class="row">
            <div class="col s12">

                        <img src="{{$logo or "/img/logos/black-full-logo.png"}}" class="img-responsive center-block company-logo">
                <div class="text">
                    <h1>{!! str_replace("%c",$company,trans("common.redirect_title")) !!} <span id="dots"></span></h1>

                    <h5>{!! str_replace("%c",$vacancy,trans("common.redirect_desc")) !!}</h5>

                    <input id="url" type="hidden" value="{{$redirectUrl}}">
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
       setTimeout(function(){
           window.location.href = $("#url").val();
       },4000);
       var dots = 0;
       function type()
       {
           if(dots < 3)
           {
               $('#dots').append('.');
               dots++;
           }
           else
           {
               $('#dots').html('');
               dots = 0;
           }
       }
       setInterval (type, 500);

    </script>

@endsection

@section('custom-js')

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
