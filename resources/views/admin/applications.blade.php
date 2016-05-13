@extends('template.admin_layout')

@yield('header')


@section('content')

        <!-- START CONTENT -->
<section id="content">


    <!--start container-->
    <div class="container">
        <div class="section">

            <!--DataTables example-->
            <div id="table-datatables">
                <h4 class="header">{{trans('profile.tue_candidature')}}</h4>
                <div class="row">

                    <div class="col s12 m12 l12">
                        <table id="data-table-simple" class="responsive-table display hidden-xs hide-on-small-and-down" cellspacing="0">
                            <thead>
                            <tr>
                                <th>{{trans('profile.azienda')}}</th>
                                <th>{{trans('profile.posizione')}}</th>
                                <th class="">{{trans('profile.luogo')}}</th>
                                <th>{{trans('profile.candidato_il')}}</th>
                                <th class="hidden-xs">{{trans('profile.ultimo_aggiornamento')}}</th>
                               <th>{{trans('profile.stato')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applications as $application)
                                <tr @if($application['status']=="SENT" && $application['active']==false) class="alert-row" @endif>
                                    <td>{{$application['vacancy']['company']['name']}}</td>
                                    <td>{{$application['vacancy']['name']}}</td>
                                    <td class="hidden-xs">{{$application['vacancy']['company']['city_plain_text']}}</td>
                                    <td>{{date('d-m-Y', strtotime($application['created_at']))}}</td>
                                    <td class="hidden-xs">{{date('d-m-Y', strtotime($application['updated_at']))}}</td>
                           <td>@if($application['status']=="SENT")

                                   <?php
                                   $isRead=false;
                                   foreach($application['events'] as $event){
                                       if($event['status']=="READ"){
                                           $isRead=true;
                                       }
                                       ?>

                               <?php } ?>
                               <?php
                                   if($isRead){ ?>
                                       <i class="mdi-image-remove-red-eye "></i>
                                       {{trans("profile.read")}}

                                   <?php  }else{ ?>
                                       <i class="mdi-content-send "></i>
                                       {{trans("profile.".strtolower($application['status']))}}

                                   <?php }
                                   ?>

                                        @elseif($application['status']=="STARRED")
                                            <i class="mdi-action-thumb-up green-text"></i>
                                   {{trans("profile.".strtolower($application['status']))}}

                               @elseif($application['status']=="SENT" && $application['active']==false)
                                            <i class="mdi-action-report-problem red-text"></i>
                                   {{trans("profile.uncompleted")}}

                               @elseif($application['status']=="REJECTED")
                                            <i class="mdi-action-thumb-down red-text"></i>
                                   {{trans("profile.".strtolower($application['status']))}}

                               @endif
                                    </td>
                                    <td><a href="/user/application/{{$application['id']}}" class="waves-effect waves-light  btn red">{{trans('profile.dettagli')}}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                        @foreach($applications as $application)


                            <div class="row hidden-sm hidden-md hidden-lg hide-on-small-and-up hide-on-med-and-up" style="margin-bottom: 30px;">
                                <div class="col s12"><strong>{{$application['vacancy']['name']}}</strong><br>{{$application['vacancy']['company']['name']}}</div>
                                <div class="col s12">{{date('d-m-Y', strtotime($application['created_at']))}}</div>
                                <div class="col s12">@if($application['status']=="SENT")

                                        <?php
                                        $isRead=false;
                                        foreach($application['events'] as $event){
                                            if($event['status']=="READ"){
                                                $isRead=true;
                                            }
                                            ?>

                               <?php } ?>
                                        <?php
                                        if($isRead){ ?>
                                        <i class="mdi-image-remove-red-eye "></i>
                                        {{trans("profile.read")}}

                                        <?php  }else{ ?>
                                        <i class="mdi-content-send "></i>
                                        {{trans("profile.".strtolower($application['status']))}}

                                        <?php }
                                        ?>

                                    @elseif($application['status']=="STARRED")
                                        <i class="mdi-action-thumb-up green-text"></i>
                                        {{trans("profile.".strtolower($application['status']))}}

                                    @elseif($application['status']=="SENT" && $application['active']==false)
                                        <i class="mdi-action-report-problem red-text"></i>
                                        {{trans("profile.uncompleted")}}

                                    @elseif($application['status']=="REJECTED")
                                        <i class="mdi-action-thumb-down red-text"></i>
                                        {{trans("profile.".strtolower($application['status']))}}

                                    @endif</div>
                                <div class="col s12"><a href="/user/application/{{$application['id']}}" class="waves-effect waves-light  btn red">{{trans('profile.dettagli')}}</a></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->



@endsection



@section('custom-js')

    <script type="text/javascript" src="/admin/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <?php
    $agent = new \Jenssegers\Agent\Agent();

            if($agent->isMobile()){
    ?>
    <script language="javascript">
        $(document).ready(function(){

            $("#data-table-simple_wrapper").remove();
        });
    </script>
    <?php } ?>

@endsection