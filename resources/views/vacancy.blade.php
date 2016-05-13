@extends('template.layout')

@yield('header')

@section('page-css')

    <link rel="stylesheet" href="/vendors/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="/vendors/photoswipe/default-skin/default-skin.css">

    <link rel="stylesheet" href="/vendors/bootstrap-fileinput/css/fileinput.min.css">

    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jquery-ui.theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda-themeless.min.css" rel="stylesheet">
    <link href="https://meritocracy.is/<?php echo \Illuminate\Support\Facades\App::getLocale() ?>/{{$vacancy['company']['permalink']}}/{{$vacancy['permalink']}}" rel="canonical" />

    @if(\Illuminate\Support\Facades\Input::get("__ats"))
        <style>
            .header-menu {
                display: none !important;
            }
        </style>
    @endif


    <style>
        .company-title:hover{
            color: inherit !important;
        }

        .company-title:hover{
            background: #20BAD1 !important;
            color:white !important;
        }

        .mosaicflow__column {
            float: left;
        }

        .mosaicflow__item img {
            display: block;
            width: 100%;
            height: auto;
        }


    </style>
@endsection

@section('content')
    <script type="text/javascript">

    </script>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "JobPosting",
      "baseSalary": "100000",
      "jobBenefits": "{{$benefitArray}}",
      "datePosted": "{{$vacancy['open_date']}}",
      "description": "{{$vacancy['description']}}",
      "educationRequirements": "",
      "employmentType": "Full-time",
      "experienceRequirements": "",
      "incentiveCompensation": "",
      "industry": "",
      "jobLocation": {
        "@type": "Place",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "{{$vacancy['city_plain_text']}}",
          "addressRegion": "{{$vacancy['city_plain_text']}}"
        }
      },
      "occupationalCategory": "",
      "qualifications": "",
      "responsibilities": "",
      "salaryCurrency": "EUR",
      "skills": "",
      "specialCommitments": "",
      "title": "{{$vacancy['name']}}",
      "workHours": ""
    }







    </script>



    <div class="container-fluid company-container vacancy-container">

        <div class="row">
            <div class="col col-xs-16 block-width hidden-md hidden-lg">

                <div class="block block-violet">


                    <div class="block-content-title-parent animated">

                        <div class="col-md-16 block-content-title background-red title">
                            <h2 class="company-title"
                            >{{$company['name']}}</h2>
                        </div>

                    </div>

                    <div class="hide">
                        <div class="col-md-16 block-content">

                            @if (isset($vacancy["city_plain_text"]))
                                <div class="map" id="map2"></div>
                                <input type="hidden" id="address"
                                       value="{{$vacancy["city_plain_text"]}}, {{$vacancy["city_plain_text"]}}">
                                <h4 class="content">{{ $vacancy["city_plain_text"] }}</h4>
                            @endif

                            @if (isset($company["employees"]))
                                <div class="clear"></div>
                                <h3 class="title">{{ trans('common.employees') }}</h3>
                                <h3 class="content">{{ $company["employees"] }}</h3>

                                @endif

                                        <!--<div class="tag">
                    <h3 class="title">Tag</h3>

                </div>!-->
                                @if (isset($company["industry"]))
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.industry') }}</h3>
                                    <h3 class="content">{{$company["industry"]['name']}}</h3>
                                @endif
                                @if (isset($company["foundationDate"]) && $company["foundationDate"]!="")
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.foundation_date') }}</h3>
                                    <h3 class="content">{{$company["foundationDate"]}}</h3>
                                @endif

                                @if (isset($company["ageRange"]))
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.age_range') }}</h3>
                                    <h3 class="content">{{$company["ageRange"]}}</h3>
                                @endif

                                <div class="clear"></div>

                                <h5 class="share-company text-uppercase red">{{ trans('common.share_this_page') }}</h5>
                                <ul class="soc soc-red">
                                    <li><a class="soc-linkedin" href="#"></a></li>
                                    <li><a class="soc-facebook" href="#"></a></li>
                                    <li><a class="soc-twitter" href="#"></a></li>

                                    <li><a class="" href="mailto:?Subject="><i class="fa fa-envelope"></i></a></li>
                                    <div style="margin-top: 15px;" class="fb-save" data-uri="{{Request::url()}}" data-size="large"></div>

                                </ul>

                        </div>
                    </div>


                </div>

            </div>
        </div>


        <div class="container">

            <div class="row">


                <div class="col col-md-5 block-width hidden-xs">

                    <div id="sticky-2" class="block block-company block-violet">


                        <div class="block-content-title-parent animated">

                            <div class="col-md-16 block-content-title background-red title company-title">

                                <a class="company-title" href="/{{App::getLocale()}}/{{$company["permalink"]}}@if(\Illuminate\Support\Facades\Input::get("__ats")){{"?__ats=1"}} @endif">
                                    <h2 style="color: white;" class="company-title"
                                    >{{$company['name']}}</h2></a>
                            </div>

                        </div>

                        <div class="">
                            <div class="col-md-16 block-content">
                                <div style="top: 2px;position: absolute;"></div>

                                @if (isset($vacancy["city_plain_text"]))
                                    <div class="map" id="map"></div>
                                    <h4  style="color: white;" class="content">{{ $vacancy["city_plain_text"] }}</h4>
                                    <input type="hidden" id="address" value="{{$vacancy["city_plain_text"]}}">
                                @endif

                                @if (isset($company["employees"]))
                                    <div class="clear"></div>
                                    <h3 class="title">{{ trans('common.employees') }}</h3>
                                    <h3 class="content">{{ $company["employees"] }}</h3>

                                    @endif

                                            <!--<div class="tag">
                    <h3 class="title">Tag</h3>

                </div>!-->

                                    @if (isset($company["industry"]))
                                        <div class="clear"></div>
                                        <h3 class="title">{{ trans('common.industry') }}</h3>
                                        <h3 class="content">{{$company["industry"]['name']}}</h3>
                                    @endif

                                    @if (isset($company["foundation_date"]) && $company["foundation_date"]!="")
                                        <div class="clear"></div>
                                        <h3 class="title">{{ trans('common.foundation_date') }}</h3>
                                        <h3 class="content">{{$company["foundation_date"]}}</h3>
                                    @endif

                                    @if (isset($company["age_range"]))
                                        <div class="clear"></div>
                                        <h3 class="title">{{ trans('common.age_range') }}</h3>
                                        <h3 class="content">{{$company["age_range"]}}</h3>
                                    @endif

                                    <div class="clear"></div>

                                    <h5 class="share-company text-uppercase red">{{ trans('common.share_this_page') }}</h5>
                                    <ul class="soc soc-red">
                                        <li><a class="soc-linkedin" href="#"></a></li>
                                        <li><a class="soc-facebook" href="#"></a></li>
                                        <li><a class="soc-twitter" href="#"></a></li>

                                        <li><a class="" href="mailto:?Subject="><i class="fa fa-envelope"></i></a></li>
                                        <div style="margin-top: 15px;" class="fb-save" data-uri="{{Request::url()}}" data-size="large"></div>

                                    </ul>

                            </div>
                        </div>


                    </div>

                </div>


                <div class="information-container col-md-10 ">
                    <div class="top" id="sticky-anchor-2"></div>
                    <div class="row">

                        <div class="col col-md-16">
                            <div class="row">
                                <div class="col col-md-16">

                                    <div class="top" id="sticky-anchor"></div>
                                    <div style="margin-top: 30px;" class="title">
                                        <h1 style="float: left; margin-top: 0px; padding-left: 0"
                                            class="bold red-label col-md-11">
                                            @if(\Illuminate\Support\Facades\App::getLocale()!="it")
                                            <font style="font-size:16px;color:#1D1236">Job:</font><br>
                                            @endif
                                            {{$vacancy['name']}}</h1>

                                        <a style="margin-top: -5px;"
                                           class="btn btn-red pull-right hidden-xs apply-button {{$applied  ? "disabled" : ''}} {{App::getLocale()}}">
                                            <h5 class="{{App::getLocale()}} {{$applied  ? "hide" : ''}}">{{trans('common.application_call_to_action')}}</h5>
                                            <h5 class="{{App::getLocale()}} {{$applied  ? "" : "hide"}}">{{trans('common.applied')}}</h5>
                                        </a>
                                    </div>


                                </div>
                                @if(isset($redirectUrl) && strlen($redirectUrl) > 1)
                                <div class="col col-md-12 margin-top-10 hidden-xs ">
                                    <div class="alert alert-warning fade in" role="alert">{{ trans("common.vacancy_redirect_advise_1") }}</div>
                                </div>
                                @endif

                                <div class="clearfix"></div>



                                @if (isset($vacancy['video']['link']) )
                                    <div class="col col-md-12 margin-top-10 ">

                                        <div class="row " id="video">
                                            <div class="col col-md-16">

                                                <div class="video-container">
                                                    <div class="embed-responsive embed-responsive-4by3">

                                                        <?php $agent=new \Jenssegers\Agent\Agent(); ?>
                                                        @if($agent->isMobile())
                                                        <iframe width="100%" height="315"
                                                                src="{{$vacancy['video']['link']}}?autoplay=0&modestbranding=0&autohide=1&showinfo=0&controls=0">
                                                        </iframe>
                                                            @else
                                                                <iframe width="100%" height="315"
                                                                        src="{{$vacancy['video']['link']}}?autoplay=1&modestbranding=0&autohide=1&showinfo=0&controls=0">
                                                                </iframe>
                                                            @endif


                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                @endif

                                @if(!isset($vacancy['video']['link']))
                                <div class="col col-md-16 margin-top-10">


                                    <div class="row">


                                    <div itemscope itemtype="http://schema.org/ImageGallery" class="clearfix my-gallery" style="margin-top:20px">
                                        @if(isset($vacancy['company']["sliders"][0]))
                                            <div class="col col-md-8 col-sm-8 col-xs-8" >
                                                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                    <a  itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][0]["link"]}}"
                                                        data-size="1620x1080">
                                                        <img width="100%" itemprop="thumbnail"src="{{$vacancy['company']["sliders"][0]["link"]}}" alt=""/>
                                                    </a>
                                                    <figcaption itemprop="caption description"></figcaption>

                                                </figure>
                                            </div>
                                        @endif
                                        <div class="col col-md-8 col-sm-8 col-xs-8" >
                                            <div class="row">
                                                @if(isset($vacancy['company']["sliders"][1]))
                                                    <div class="col col-md-8 col-sm-8 col-xs-8">
                                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                            <a data-pswp-uid="1" itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][1]["link"]}}"
                                                               data-size="1620x1080">
                                                                <img width="100%" itemprop="thumbnail" src="{{$vacancy['company']["sliders"][1]["link"]}}" alt=""/>
                                                            </a>
                                                            <figcaption itemprop="caption description"></figcaption>

                                                        </figure>
                                                    </div>
                                                @endif
                                                @if(isset($vacancy['company']["sliders"][2]))
                                                    <div class="col col-md-8 col-sm-8 col-xs-8">
                                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                            <a  data-pswp-uid="2" itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][2]["link"]}}"
                                                                data-size="1620x1080">
                                                                <img itemprop="thumbnail" width="100%" src="{{$vacancy['company']["sliders"][2]["link"]}}" alt=""/>
                                                            </a>
                                                            <figcaption itemprop="caption description"></figcaption>

                                                        </figure>

                                                    </div>
                                                @endif
                                                @if(isset($vacancy['company']["sliders"][3]))
                                                    <div class="col col-md-8 col-sm-8 col-xs-8" style="margin-top:20px">
                                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                            <a  itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][3]["link"]}}"
                                                                data-size="1620x1080">
                                                                <img itemprop="thumbnail" width="100%" src="{{$vacancy['company']["sliders"][3]["link"]}}" alt=""/>
                                                            </a>
                                                            <figcaption itemprop="caption description"></figcaption>

                                                        </figure>

                                                    </div>
                                                @endif
                                                @if(isset($vacancy['company']["sliders"][4]))
                                                    <div class="col col-md-8 col-sm-8 col-xs-8" style="margin-top:20px">
                                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                            <a  data-pswp-uid="3" itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][4]["link"]}}"
                                                                data-size="1620x1080">
                                                                <img itemprop="thumbnail" width="100%" src="{{$vacancy['company']["sliders"][4]["link"]}}" alt=""/>
                                                            </a>
                                                            <figcaption itemprop="caption description"></figcaption>
                                                        </figure>

                                                    </div>
                                                @endif


                                                @foreach(array_slice($vacancy['company']["sliders"],5) as $slide)
                                                    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="hide">
                                                        <a  itemprop="contentUrl"  href="{{$slide["link"]}}"
                                                            data-size="1620x1080" data-index="4">
                                                            <img itemprop="thumbnail" width="100%" src="{{$slide["link"]}}" alt=""/>
                                                        </a>
                                                        <figcaption itemprop="caption description"></figcaption>

                                                    </figure>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                                        <!-- Background of PhotoSwipe.
                                             It's a separate element, as animating opacity is faster than rgba(). -->
                                        <div class="pswp__bg"></div>

                                        <!-- Slides wrapper with overflow:hidden. -->
                                        <div class="pswp__scroll-wrap">

                                            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                                            <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                                            <div class="pswp__container">
                                                <div class="pswp__item"></div>
                                                <div class="pswp__item"></div>
                                                <div class="pswp__item"></div>
                                            </div>

                                            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                            <div class="pswp__ui pswp__ui--hidden">

                                                <div class="pswp__top-bar">

                                                    <!--  Controls are self-explanatory. Order can be changed. -->

                                                    <div class="pswp__counter"></div>

                                                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                                                    <button class="pswp__button pswp__button--share" title="Share"></button>

                                                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                                                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                                                    <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                                                    <!-- element will get class pswp__preloader--active when preloader is running -->
                                                    <div class="pswp__preloader">
                                                        <div class="pswp__preloader__icn">
                                                            <div class="pswp__preloader__cut">
                                                                <div class="pswp__preloader__donut"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                                    <div class="pswp__share-tooltip"></div>
                                                </div>

                                                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                                                </button>

                                                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                                                </button>

                                                <div class="pswp__caption">
                                                    <div class="pswp__caption__center"></div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    </div>
                                </div>
                            @endif




                                <div class="col col-md-16 margin-top-20">
                                    <div style="padding-left: 0;" class="col-md-6 col-xs-16">
                                        <h4 class="job-info">{{trans('common.location')}}</h4>
                                        <span style="font-size: 16px;">{{$vacancy["city_plain_text"] or ''}}</span>

                                    </div>
                                    <div style="padding-left: 0;"
                                         class="col-md-6 col-xs-16 col-md-offset-1 col-xs-offset-1">
                                        <h4 class="job-info">{{trans('common.vacancy_opened_on')}}</h4>
                                    <span style="font-size: 16px;">
                                        {{--*/  $m =  (new \Moment\Moment($vacancy['open_date']))->fromNow();
                                         /*--}}
                                        {{
                                       $m->getRelative()  }}</span>

                                    </div>

                                </div>
                                <div class="col col-md-16 jobs-container margin-top-20" id="description">


                                    <p>
                                        <?php echo strip_tags($vacancy['description'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?></p>
                                </div>



                                @if(isset($vacancy['video']['link']))
                                    <div class="col col-md-16 margin-top-20">


                                        <div class="row">


                                            <div itemscope itemtype="http://schema.org/ImageGallery" class="clearfix my-gallery" style="margin-top:20px">
                                                @if(isset($vacancy['company']["sliders"][0]))
                                                    <div class="col col-md-8 col-sm-8 col-xs-8" >
                                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                            <a  itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][0]["link"]}}"
                                                                data-size="1620x1080">
                                                                <img width="100%" itemprop="thumbnail"src="{{$vacancy['company']["sliders"][0]["link"]}}" alt=""/>
                                                            </a>
                                                            <figcaption itemprop="caption description"></figcaption>

                                                        </figure>
                                                    </div>
                                                @endif
                                                <div class="col col-md-8 col-sm-8 col-xs-8" >
                                                    <div class="row">
                                                        @if(isset($vacancy['company']["sliders"][1]))
                                                            <div class="col col-md-8 col-sm-8 col-xs-8">
                                                                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                                    <a data-pswp-uid="1" itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][1]["link"]}}"
                                                                       data-size="1620x1080">
                                                                        <img width="100%" itemprop="thumbnail" src="{{$vacancy['company']["sliders"][1]["link"]}}" alt=""/>
                                                                    </a>
                                                                    <figcaption itemprop="caption description"></figcaption>

                                                                </figure>
                                                            </div>
                                                        @endif
                                                        @if(isset($vacancy['company']["sliders"][2]))
                                                            <div class="col col-md-8 col-sm-8 col-xs-8">
                                                                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                                    <a  data-pswp-uid="2" itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][2]["link"]}}"
                                                                        data-size="1620x1080">
                                                                        <img itemprop="thumbnail" width="100%" src="{{$vacancy['company']["sliders"][2]["link"]}}" alt=""/>
                                                                    </a>
                                                                    <figcaption itemprop="caption description"></figcaption>

                                                                </figure>

                                                            </div>
                                                        @endif
                                                        @if(isset($vacancy['company']["sliders"][3]))
                                                            <div class="col col-md-8 col-sm-8 col-xs-8" style="margin-top:20px">
                                                                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                                    <a  itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][3]["link"]}}"
                                                                        data-size="1620x1080">
                                                                        <img itemprop="thumbnail" width="100%" src="{{$vacancy['company']["sliders"][3]["link"]}}" alt=""/>
                                                                    </a>
                                                                    <figcaption itemprop="caption description"></figcaption>

                                                                </figure>

                                                            </div>
                                                        @endif
                                                        @if(isset($vacancy['company']["sliders"][4]))
                                                            <div class="col col-md-8 col-sm-8 col-xs-8" style="margin-top:20px">
                                                                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                                    <a  data-pswp-uid="3" itemprop="contentUrl"  href="{{$vacancy['company']["sliders"][4]["link"]}}"
                                                                        data-size="1620x1080">
                                                                        <img itemprop="thumbnail" width="100%" src="{{$vacancy['company']["sliders"][4]["link"]}}" alt=""/>
                                                                    </a>
                                                                    <figcaption itemprop="caption description"></figcaption>
                                                                </figure>

                                                            </div>
                                                        @endif


                                                        @foreach(array_slice($vacancy['company']["sliders"],5) as $slide)
                                                            <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="hide">
                                                                <a  itemprop="contentUrl"  href="{{$slide["link"]}}"
                                                                    data-size="1620x1080" data-index="4">
                                                                    <img itemprop="thumbnail" width="100%" src="{{$slide["link"]}}" alt=""/>
                                                                </a>
                                                                <figcaption itemprop="caption description"></figcaption>

                                                            </figure>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                                                <!-- Background of PhotoSwipe.
                                                     It's a separate element, as animating opacity is faster than rgba(). -->
                                                <div class="pswp__bg"></div>

                                                <!-- Slides wrapper with overflow:hidden. -->
                                                <div class="pswp__scroll-wrap">

                                                    <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                                                    <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                                                    <div class="pswp__container">
                                                        <div class="pswp__item"></div>
                                                        <div class="pswp__item"></div>
                                                        <div class="pswp__item"></div>
                                                    </div>

                                                    <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                                    <div class="pswp__ui pswp__ui--hidden">

                                                        <div class="pswp__top-bar">

                                                            <!--  Controls are self-explanatory. Order can be changed. -->

                                                            <div class="pswp__counter"></div>

                                                            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                                                            <button class="pswp__button pswp__button--share" title="Share"></button>

                                                            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                                                            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                                                            <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                                                            <!-- element will get class pswp__preloader--active when preloader is running -->
                                                            <div class="pswp__preloader">
                                                                <div class="pswp__preloader__icn">
                                                                    <div class="pswp__preloader__cut">
                                                                        <div class="pswp__preloader__donut"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                                            <div class="pswp__share-tooltip"></div>
                                                        </div>

                                                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                                                        </button>

                                                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                                                        </button>

                                                        <div class="pswp__caption">
                                                            <div class="pswp__caption__center"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif



                            </div>
                        </div>

                    </div>

                    <div class="row" id="sticky-2">
                        <div class="col col-md-16 hide">
                            <h4 class="bold red-label" id="workspaces">{{trans("common.workspaces")}}</h4>
                        </div>

                        <div class="col col-md-16">


                        </div>
                        @if (isset($company['vision']) && $company['vision']!="")
                            <div class="row">
                                <div id="vision" class="col col-md-13">
                                    <div class="row">
                                        <div class="col col-md-16">
                                            <h4 class="bold red-label">{{ trans('common.vision') }}</h4>
                                        </div>

                                        <div class="col col-md-16 jobs-container">

                                            <p>
                                                <?php echo strip_tags($company['vision'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"); ?>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif


                        @if(isset($company['benefits']) && count($company['benefits'])>0)
                            <div class="row" id="benefit">
                                <div class="col col-md-16">
                                    <h4 class="bold red-label" id="benefit">Benefits</h4>
                                </div>

                                <div class="col col-md-16 benefit-container">
                                    <div class="row">


                                        @foreach ($company['benefits'] as $benefit)
                                            <div class="col col-md-8 col-xs-8 col-sm-8 benefit-container">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="benefit-std" style="display: inline;">
                                                            <img style="display: inline;margin-right: 10px;"
                                                                 class="img-responsive"
                                                                 src="https://meritocracy.is/img/{{$benefit["icon"]}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10"><span
                                                                style="display: inline;">{{$benefit["name"]}}</span>

                                                    </div>
                                                </div>


                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @endif
                            </div>


                            <div class="col col-md-16 hidden-xs margin-top-50">

                                <div class="row">


                                    <div class="col col-md-7">
                                        <a href="/{{App::getLocale()}}/{{$company['permalink']}}@if(\Illuminate\Support\Facades\Input::get("__ats")){{"?__ats=1"}} @endif">
                                            <div class="dark-box-application">
                                                <p>{{trans('common.torna_alla_pagina')}} {{$company['name']}} {{trans("common.scoprire_altre")}}
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col col-md-9">
                                        <button style="text-transform: none;"
                                                class="btn red-box-application apply-button {{$applied ? "disabled" : ''}} {{App::getLocale()}}">
                                            <h5 class="{{App::getLocale()}} {{$applied  ? "hide" : ''}}">{{strtoupper(trans('common.application_call_to_action'))}}</h5>
                                            <h5 class="{{App::getLocale()}} {{$applied  ? "" : "hide"}}">{{trans('common.applied')}}</h5>
                                        </button>
                                    </div>
                                </div>


                            </div>



                            <div class="col col-md-16 hidden-md hidden-lg margin-top-50">
                                <div class="row">

                                    <div class="col col-md-16">
                                        <a href="/{{App::getLocale()}}/{{$company['permalink']}}">
                                            <div class="dark-box-application">
                                                <p>{{trans('common.torna_alla_pagina')}} {{$company['name']}} {{trans("common.scoprire_altre")}}
                                                </p>
                                            </div>
                                        </a>
                                    </div>


                                    <div class="col col-md-16">
                                        <button style="text-transform: none;"
                                                class="btn red-box-application apply-button {{$applied ? "disabled" : ''}} {{App::getLocale()}}">
                                            <h5 class="{{App::getLocale()}} {{$applied  ? "hide" : ''}}">{{strtoupper(trans('common.application_call_to_action'))}}</h5>
                                            <h5 class="{{App::getLocale()}} {{$applied  ? "" : "hide"}}">{{trans('common.applied')}}</h5>
                                        </button>
                                    </div>



                                </div>


                            </div>


                    </div>

                </div>


            </div>

        </div>
    </div>


    <div class="navbar navbar-fixed-bottom hidden-lg hidden-md bottom-bar call-to-action-container {{$applied ? "hide" : ''}}">
        <div class="navbar-inner">
            <div class="container">
                <button class="btn-transparent call-to-action-application apply-button ">
                    <span class="{{App::getLocale()}} {{$applied  ? "hide" : ''}}">{{trans('common.application_call_to_action')}}</span>
                    <span class="{{App::getLocale()}} {{$applied  ? "" : 'hide'}}">{{trans('common.applied')}}</span>
                    <i class="fa fa-arrow-right pull-right" style="line-height: 45px;"></i></button>
            </div><!-- /.container -->
        </div><!-- /.navbar-inner -->
    </div><!-- /.navbar -->


    <input value="{{$company["facebookPixel"] or '' }}" type="hidden" id="vacancyFbPixel">
    <input value="{{$vacancy["facebook_pixel"] or '' }}" type="hidden" id="vacancyFbPixelSpecific">
    <input value="{{$vacancy["twitter_pixel"] or '' }}" type="hidden" id="vacancyTwitterPixel">

    <input value="{{$company["logo_small"] or '' }}" type="hidden" id="companyLogoUrl">

    <input value="{{$vacancy["id"] }}" type="hidden" id="vacancyId">
    <input value="{{$vacancy["name"] }}" type="hidden" id="vacancyName">
    <input value="{{$company["name"] }}" type="hidden" id="companyName">

    <input value="{{$vacancy["description"] or '' }}" type="hidden" id="vacancyDescription">
    <input value="{{$company['id'] }}" type="hidden" id="companyId">
    <input value="{{$redirectUrl or '' }}" type="hidden" id="redirectUrl">


    @include('template.sticky-menu-vacancy')
    @if ($applied == false)
        @include('template.modal-application')
    @endif

    @if(\Illuminate\Support\Facades\Auth::check())
        <input id="userId" type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
    @endif

@endsection


@section('page-scripts')

    <script>
        var enforceModalFocusFn = $.fn.modal.Constructor.prototype.enforceFocus;
        $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    </script>
    <script type="text/javascript" src="{{auto_version("/js/pages/vacancy.js")}}"></script>
    <script type="text/javascript" src="{{auto_version("/js/utils/regUtils.js")}}"></script>
    <script type="text/javascript" src="/vendors/photoswipe/photoswipe-ui-default.min.js"></script>
    <script type="text/javascript" src="/vendors/photoswipe/photoswipe.js"></script>

    <!-- Job Rapido Tracking Pixel !-->
    <script>
        (function() {var jets = document.createElement('script');jets.async = true;jets.type = 'text/javascript';
            var useSSL = 'https:' == document.location.protocol;jets.src = (useSSL ? 'https:' : 'http:') + '//static.jobrapido.com/public/tracking/v2/jrpt.min.js';
            var node = document.getElementsByTagName('script')[0];node.parentNode.insertBefore(jets, node);} )();
    </script>
<script>
    var initPhotoSwipeFromDOM = function(gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = $(".my-gallery figure"),
                    numNodes = thumbElements.length,
                    items = [],
                    figureEl,
                    linkEl,
                    size,
                    item;


            for(var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes
                if(figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element

                size = linkEl.getAttribute('data-size').split('x');

                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };



                if(figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if(linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && ( fn(el) ? el : closest(el.parentNode, fn) );
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {

            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide


            var clickedListItem = $(eTarget).closest("figure")



            if(!clickedListItem) {
                return;
            }


            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = $(".my-gallery"),
                    childNodes = $(".my-gallery figure"),
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;



            if(clickedListItem.attr("data-pswp-uid") >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe( clickedListItem.attr("data-pswp-uid")-1, clickedGallery );
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
                    params = {};

            if(hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if(!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if(pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if(params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                    gallery,
                    options,
                    items;

            items = parseThumbnailElements(galleryElement);




            // define options (if needed)
            options = {

                // define gallery index (for URL)
                galleryUID: 0,

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect();

                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                }

            };

            // PhotoSwipe opened from URL
            if(fromURL) {
                if(options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for(var j = 0; j < items.length; j++) {
                        if(items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if( isNaN(options.index) ) {
                return;
            }

            if(disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll( ".my-gallery figure" );

        for(var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i+1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if(hashData.pid && hashData.gid) {
            openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
        }
    };

    // execute above function
    initPhotoSwipeFromDOM('.my-gallery');

</script>
    <script type="text/javascript" src="/vendors/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/spin.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.js"></script>

    <script>Vacancy.init();</script>

@endsection