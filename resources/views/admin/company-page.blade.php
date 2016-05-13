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
                <h5 class="breadcrumbs-title">Complete Company data</h5>
                <ol class="breadcrumbs">
                    <li><a href="/hr">Dashboard</a></li>
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
            <div class="card-panel">

                <div class="row">
                    <form  data-swal-type="success" data-swal-title="{{trans('company-page.title_confirm_update')}}"
                          data-swal-confirm-button="{{trans('company-page.button_confirm_update')}}"
                          data-swal-text="{{trans('company-page.text_confirm_update')}}" enctype='multipart/form-data'
                          class="col s12" id="modify-company" data-id="@if(isset($company['id'])){{$company['id']}}@endif">
                        <h5 style="font-size: 1.1rem; font-weight: 200;" class="header2">{{trans('company-page.dati_azienda')}}</h5>

                        <div style="margin-top: 35px;" class="row">
                            <div class="input-field col s6">
                                <input class="validate" type="text" name="name" id="name" value="@if(isset($company['name'])){{$company['name']}}@endif" required>
                                <label for="name" class="active" data-error="This field is required" data-success="Ok">Name <span class="label-required">*</span></label>
                            </div>
                            <div class="input-field col s6">

                                <select id="industry" name="industry[id]"
                                        class="select2-industries" required>
                                    <option value="" disabled
                                            selected>{{trans('register-company.scegli_opzione')}}</option>
                                    @foreach($industries as $industry)
                                        <option value="{{$industry['id']}}"
                                                @if(isset($company['industry'])&&  $industry['id']==$company['industry']['id']) selected @endif >{{$industry['name']}}</option>
                                    @endforeach
                                </select>
                                <label lang="en">Industry <span class="label-required">*</span></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" name="foundation_date" id="foundation_date"
                                       value="@if(isset($company['foundation_date'])){{$company['foundation_date']}}@endif" required>
                                <label for="foundation_date" class="active">Foundation Date <span class="label-required">*</span></label>
                            </div>

                            <div id="input-select" class="">
                                <div class="input-field col s6">
                                     <select name="employees" id="dipendenti" required>
                                        <option value="" disabled
                                                selected>{{trans('company-page.scegli_dipendenti')}}</option>
                                        <option value="1-10" @if(isset($company['employees']) && $company['employees']=="1-10") selected @endif>1-10</option>
                                        <option value="10-50" @if(isset($company['employees']) && $company['employees']=="10-50") selected @endif>10-50</option>
                                        <option value="50-200" @if(isset($company['employees']) && $company['employees']=="50-200") selected @endif>50-200</option>
                                        <option value="200-1000" @if(isset($company['employees']) && $company['employees']=="200-1000") selected @endif>200-1000</option>
                                        <option value="1000-5000" @if(isset($company['employees']) && ($company['employees']=="+1000" || $company['employees']=="1000-5000")) selected @endif>1000-5000</option>
                                         <option value="5000-10000" @if(isset($company['employees']) && ($company['employees']=="+5000" || $company['employees']=="5000-10000")) selected @endif>5000-10000</option>
                                         <option value="+10000" @if(isset($company['employees']) && $company['employees']=="+10000") selected @endif>+10000</option>

                                     </select>
                                    <label for="dipendenti">{{trans('company-page.numero_dipendenti')}}</label>

                                </div>
                            </div>

                        </div>




                        <div class="row">
                            <div class="input-field col s6">
                                <input type="number" name="male" maxlength="3" id="male"
                                       value="@if(isset($company['male'])){{$company['male']}}@endif">
                                <label for="male" class="active">Male Percentage</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="number" name="female" maxlength="3" id="female"
                                       value="@if(isset($company['female'])){{$company['female']}}@endif">
                                <label for="female" class="active">Female Percentage</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="number" name="age_average" maxlength="3" id="age_average"
                                       value="@if(isset($company['age_average'])){{$company['age_average']}}@endif">
                                <label for="age_average" class="active">Age Average</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" name="website" id="website" value="@if(isset($company['website'])){{$company['website']}}@endif">
                                <label for="website" class="active">Website</label>
                            </div>
                        </div>

                        <div class="row">

                            <div class="input-field col m6 s6">
                                <input type="hidden" name="city[id]" class="address_city_id"
                                       value="@if(isset($company['city'])){{$company['city']['id']}}@endif" id="work_city_id">
                                <input id="luogo_lavoro" name="city_plain_text" type="text"
                                       class="required validate" value="@if(isset($company['city_plain_text'])){{$company['city_plain_text']}}@endif" required>
                                <label for="luogo_lavoro">{{ trans('company-page.citta') }}</label>
                            </div>
                            <div class="input-field col s6">
                                <select id="language_" name="language[id]" required>
                                    <option value="" disabled selected>Choose your language</option>
                                    @foreach($languages as $language)
                                        <option value="{{$language['id']}}"
                                                @if(isset($company['language']) && $language['id']==$company['language']['id']) selected @endif>{{$language['name']}}</option>
                                    @endforeach
                                </select>
                                <label for="language_" class="active" style="
    top: 10px !important;
">Language</label>

                            </div>
                        </div>



                        <div class="row hide">
                            <div class="input-field col s12 m12">
                                <select name="benefit[][id]" id="benefit_select" class="icons" multiple>
                                    <option value="" disabled >Choose your benefits (at least 3)</option>

                                    @foreach($benefits as $benefit)
                                        <option value="{{$benefit["id"]}}"
                                                data-icon="/img/{{$benefit["icon"]}}"
                                                class="left"
                                        {{$benefit['selected']}}
                                        >{{$benefit['name']}}</option>
                                    @endforeach

                                </select>
                                <label>Benefits</label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="story" class="materialize-textarea" id="story"
                                          placeholder="{{trans('company-page.story_placeholder')}}"
                                          required>@if(isset($company['story'])){!! $company['story']  !!}@endif</textarea>
                                <label for="story" class="active">Story <span class="label-required">*</span></label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="vision" class="materialize-textarea" id="vision"
                                          placeholder="{{trans('company-page.vision_placeholder')}}">@if(isset($company['vision'])){!! $company['vision'] !!}@endif</textarea>
                                <label for="vision" class="active">Vision <span class="label-required">*</span></label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="mission" class="materialize-textarea" id="mission"
                                          placeholder="{{trans('company-page.mission_placeholder')}}"
                                          >@if(isset($company['mission'])){!!$company['mission']!!}@endif</textarea>
                                <label for="mission" class="active">Mission</label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="our_values" class="materialize-textarea" id="our_values"
                                          placeholder="{{trans('company-page.our_values')}}"
                                >@if(isset($company['our_values'])){!!$company['our_values']!!}@endif</textarea>
                                <label for="our_values" class="active">Our Values</label>
                            </div>

                        </div>


                        <h4 class="header2">{{trans('company-page.indirizzi')}}</h4>
                        @if(isset($company['addresses']) && empty($company['addresses']))
                            <div class="row address-row">
                                <div class="input-field col m5">
                                    <i class="mdi-communication-business prefix"></i>
                                    <input type="text" class="address" id="indirizzo_0" name="address[name][]"
                                           placeholder="{{trans('company-page.address_placeholder')}}" required>
                                    <label for="indirizzo_0">{{ trans('company-page.indirizzo') }} <span class="label-required">*</span></label>
                                </div>
                                <div class="input-field col m3">
                                    <input type="text" class="cap" id="cap_0"
                                           name="address[postal_code][]"
                                           placeholder="{{trans('company-page.cap_placeholder')}}" required>
                                    <label for="cap_0">{{ trans('company-page.cap') }} <span class="label-required">*</span></label>
                                </div>
                                <div class="input-field col m3">
                                    <i class="mdi-communication-location-on prefix"></i>
                                    <input type="hidden" name="address[city_id][]" value="" class="address_city_id"
                                           id="work_city_id">
                                    <input id="luogo_lavoro_0" name="address[city_plain_text][]" type="text"
                                           class="required validate address_city" required>
                                    <label for="luogo_lavoro_0">{{ trans('company-page.citta') }} <span class="label-required">*</span></label>
                                </div>
                                <div class="col m1">
                                    <button class="btn-floating waves-effect waves-light delete-address">
                                        <i class="mdi-action-delete "></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if(isset($company['addresses']) )
                        @foreach( $company['addresses'] as $key=>$address)
                            <div class="row address-row">
                                <div class="input-field col m4">
                                    <i class="mdi-communication-business prefix"></i>
                                    <input type="text" class="address" id="indirizzo_{{$address['id']}}"
                                           name="address[name][]" value="{{$address['name']}}"
                                           placeholder="{{trans('company-page.address_placeholder')}}" required>
                                    <label for="indirizzo_{{$address['id']}}">{{ trans('company-page.indirizzo') }}</label>
                                </div>

                                <div class="input-field col m3">
                                    <input type="text" class="cap" id="cap_{{$address['id']}}"
                                           name="address[postal_code][]" @if(isset($address['postal_code']))value="{{$address['postal_code']}}"@endif
                                           placeholder="{{trans('company-page.cap_placeholder')}}" required>
                                    <label for="cap_{{$address['id']}}">{{ trans('company-page.cap') }}</label>
                                </div>

                                <div class="input-field col m3">
                                    <i class="mdi-communication-location-on prefix"></i>
                                    <input type="hidden" name="address[city_id][]" value="@if(isset($address['city']['id'])){{$address['city']['id']}}@endif"
                                           id="work_city_id">
                                    <input id="luogo_lavoro_{{$address['id']}}" name="address[city_plain_text][]"
                                           type="text"
                                           class="required validate address_city" value="@if(isset($address['city_plain_text'])) {{$address['city_plain_text']}} @elseif(isset($address['city']['id'])) {{$address['city']['name']}} @endif"
                                           required>
                                    <label for="luogo_lavoro_{{$address['id']}}">{{ trans('company-page.citta') }}</label>
                                </div>
                                <div class="input-field col m2">
                                    <button style="margin-right: 15px;" class="btn-floating waves-effect  waves-light green add-address">
                                        <i class="mdi-content-add "></i>
                                    </button>
                                    <button class="btn-floating waves-effect waves-light delete-address">
                                        <i class="mdi-action-delete "></i>
                                    </button>

                                </div>
                            </div>
                        @endforeach
                        @else
                            <button style="margin-right: 15px;" class="btn-floating waves-effect  waves-light green add-address">
                                <i class="mdi-content-add "></i>
                            </button>
                        @endif







                        <h4 class="header2">Logo</h4>

                        <div class="row">
                            <input type="hidden" id="logo" name="logo_small" value="@if(isset($company['logo_small'])){{$company['logo_small']}}@endif">
                            <div class="file-field input-field col m2">
                                @if(isset($company['logo_small']) && $company['logo_small']!="")
                                    <img src="{{$company['logo_small']}}" id="logo_src" width="120">
                                @else
                                    <img src="/img/logo_placeholder.jpg" id="logo_src" width="120">


                                @endif
                            </div>
                            <div style="margin-top: 30px;"  class="file-field input-field col m8">
                                <div class="btn load-file red" data-img-source="#logo_src" data-destination-url="#logo">
                                    <span>Upload new Logo</span>
                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="input-field col s12">
                                <button name="action" type="submit" class="btn cyan waves-effect waves-light right">
                                    {{trans('company-page.update_button')}}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('page-scripts')
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript" src="{{auto_version("/admin/js/hr.js")}}"></script>
    <script type="text/javascript" src="/admin/js/plugins/formatter/jquery.formatter.min.js"></script>


    <script type="text/javascript">


        $(document).ready(function () {
            HR.init();


        });


    </script>
@endsection