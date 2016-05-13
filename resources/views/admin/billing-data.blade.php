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
                <h5 class="breadcrumbs-title">Billing Data</h5>
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
                        <h5 style="font-size: 1.1rem; font-weight: 200;" class="header2">Manage your billing information here.</h5>

                        <div style="margin-top: 35px;" class="row">
                            <div class="input-field col s6">
                                <input class="validate" type="text" name="billing_name" id="billing_name" value="@if(isset($company['billing_name'])){{$company['billing_name']}}@endif" required>
                                <label for="billing_name" class="active" data-error="This field is required" data-success="Ok">Billing Name <span class="label-required">*</span></label>
                            </div>

                        </div>
                        <div style="margin-top: 35px;" class="row">
                            <div class="input-field col s8">
                                <input class="validate" type="text" name="billing_address" id="billing_address" value="@if(isset($company['billing_address'])){{$company['billing_address']}}@endif" required>
                                <label for="billing_address" class="active" data-error="This field is required" data-success="Ok">Billing Address <span class="label-required">*</span></label>
                            </div>

                            <div class="input-field col s4">
                                <input class="validate" type="text" name="billing_zip" id="billing_zip" value="@if(isset($company['billing_zip'])){{$company['billing_zip']}}@endif" required>
                                <label for="billing_zip" class="active" data-error="This field is required" data-success="Ok">Billing Zip <span class="label-required">*</span></label>
                            </div>
                        </div>
                        <div style="margin-top: 35px;" class="row">
                            <div class="input-field col s8">
                                <input class="validate" type="text" name="billing_city" id="billing_city" value="@if(isset($company['billing_city'])){{$company['billing_city']}}@endif" required>
                                <label for="billing_city" class="active" data-error="This field is required" data-success="Ok">Billing City <span class="label-required">*</span></label>
                            </div>

                            <div class="input-field col s4">
                                <select name="billing_country" id="billing_country" required>
                                    @foreach($countries as $country)
                                        <option value="{{$country['name']}}" @if(isset($company['billing_country']) && $company['billing_country']==$country['name']){{$company['billing_country']}}@endif>{{$country['name']}}</option>
                                    @endforeach
                                </select>
                                <label for="billing_country" class="active" data-error="This field is required" data-success="Ok">Billing Country <span class="label-required">*</span></label>
                            </div>
                        </div>
                        <div style="margin-top: 35px;" class="row">
                            <div class="input-field col s8">


                                <input class="validate" type="text" name="billing_vat" id="billing_vat" value="@if(isset($company['billing_vat'])){{$company['billing_vat']}}@endif" required>


                                <label for="billing_vat" class="active" data-error="This field is required" data-success="Ok">VAT Code <span class="label-required">*</span></label>
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