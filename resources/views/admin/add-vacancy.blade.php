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
<link href="/admin/js/plugins/jsgrid/css/jsgrid-theme.min.css" type="text/css" rel="stylesheet" media="screen,projection">
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
                    <li><a href="/hr">{{$title }}</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

    <div data-count="" data-other="" id="new-vacancy card">
        <div class="row">


            <form id="new-vacancy" class="col s8 m8 l8 offset-l2" method="POST" action="">

                <div style="display: none; margin-top: 50px; margin-bottom: 50px;" class="col s12 m12 l12 center form-loader">
                    <div class="preloader-wrapper big ">
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
                    <h5 class="gray-text">Add a new vacancy</h5>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="vacancyAddName" id="vacancyAddName" type="text" class="validate">
                            <label lang="en" for="vacancyAddName">Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                                <textarea name="vacancyAddDescription" id="vacancyAddDescription"
                                          class="materialize-textarea"
                                          length="9000"></textarea>
                            <label lang="en" for="vacancyAddDescription">Description</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <label for="vacancyAddJobFunction" lang="en">Job Function</label>
                            <select id="vacancyAddJobFunction" name="vacancyAddJobFunction"
                                    class="select2-jobFunctions">
                                <option value="" disabled selected>Choose your option</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col s12">
                            <label lang="en">Study Field</label>
                            <select id="vacancyAddStudyField" name="vacancyAddStudyField"
                                    class="select2-studyFields">
                                <option value="" disabled selected>Choose your option</option>

                            </select>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col s12">
                            <label lang="en">Industry</label>
                            <select id="vacancyAddIndustry" name="vacancyAddIndustry"
                                    class="select2-industries">
                                <option value="" disabled selected>Choose your option</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col s12">
                            <label lang="en">Seniority</label>
                            <select id="vacancyAddSeniority" name="vacancyAddSeniority" class="">
                                <option value="" disabled selected>Choose your option</option>
                                <option lang="en" value="INTERN_STAGE" >Intern / Stage</option>
                                <option lang="en" value="JUNIOR">Junior</option>
                                <option lang="en" value="MIDDLE" >Middle</option>
                                <option lang="en" value="SENIOR" >Senior</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col s12">
                            <label lang="en">Languages</label>
                            <select id="vacancyAddLanguages" name="vacancyAddLanguages"
                                     class="select2-languages">
                                <option value="" disabled selected>Choose your option</option>

                            </select>
                        </div>

                    </div>


                    <div class="row">
                        <div class="input-field col s12">
                            <input name="vacancyAddCity" type="hidden" id="vacancyAddCity">
                            <input data-input="#vacancyAddCity" data-source="http://meritocracy/search/city" class="autocomplete-source" type="text" >
                            <label lang="en" for="vacancyAddCity">City</label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="input-field col s12">
                            <input placeholder="2016-01-01" class="date-input-format" name="vacancyAddDate" id="vacancyAddDate" type="text" >
                            <label lang="en" for="vacancyAddDate">Opening date</label>
                        </div>
                    </div>


                    <div class="input-field col s12">
                        <button lang="en" class="btn waves-effect waves-light right red submit" type="submit" name="action">Add vacancy
                            <i class="mdi-content-add right"></i>
                        </button>
                    </div>

                </div>

                <div style="display: none; margin-top: 50px; margin-bottom: 50px;" class="center form-result animated fadeIn">
                    <div class="white-text">
                        <h4 lang="en" class=""><i class="mdi-navigation-check"></i>&nbsp;Vacancy added</h4>
                        <h6 lang="en">The vacancy has been added succesfully.</h6>
                    </div>
                    <div class="button-action">
                        <button data-form="new-vacancy" lang="en" class="waves-effect waves-light green darken-2 btn form-recreate">Add another</button>
                        <button lang="en" class="waves-effect waves-light green darken-2 btn">Close</button>
                    </div>

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
            initAutocomplete();

        });


    </script>
    @endsection