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
                <h4 class="header">{{trans('profile.your_attachments_title')}}</h4>
                <div class="row">


                    <div class="col s12 m12 l12">

                        <table id="attachments" class="display  no-wrap " width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>{{trans('profile.type_attachment')}}</th>
                                <th>{{trans('profile.name')}}</th>
                                <th>{{trans('profile.data_creazione')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attachments as $allegato)
                                @if($allegato['active']==true)
                                    <tr>
                                        @if($allegato['type']=="CV")
                                            <td>
                                                <span class="task-cat light-yellow accent-2">{{trans('profile.curriculum')}}</span>
                                            </td>
                                        @elseif($allegato['type']=="COVER_LETTER")
                                            <td><span class="task-cat light-blue accent-2">COVER LETTER</span>
                                            </td>
                                        @endif
                                        <td>{{$allegato['name']}}</td>
                                        <td>{{date('d-m-Y', strtotime($allegato['created_at']))}}</td>

                                        <td>
                                            <div class="hide-on-small-and-down">

                                            <?php
                                            if (filter_var($allegato['link'], FILTER_VALIDATE_URL) === FALSE) { ?>
                                            <a href="/cv/{{$allegato['link']}}" target="_blank" title="Scarica Allegato"
                                               class="waves-effect waves-light  btn white black-text"><i
                                                        class="mdi-file-file-download "></i></a>
                                            <?php }else{ ?>
                                            <a data-id="{{$allegato["id"]}}"  title="Rinomina Allegato"
                                               class="waves-effect waves-light  btn white black-text file-rename"><i
                                                        class="mdi-editor-mode-edit left"></i>{{trans('common.rename')}}
                                            </a>

                                            <a href="{{$allegato['link']}}" target="_blank" title="Scarica Allegato"
                                               class="waves-effect waves-light  btn white black-text"><i
                                                        class="mdi-file-file-download left"></i>{{trans('common.download')}}
                                            </a>


                                            <?php } ?>
                                            <a data-href="/elimina/attachment/{{$allegato['id']}}"
                                               title="Elimina allegato" data-method="GET"
                                               class="waves-effect waves-light btn white black-text action-button "><i
                                                        class="mdi-action-delete left"></i>{{trans('common.remove')}}
                                            </a>
                                            </div>

                                            <div class="hide-on-med-and-up">
                                                <?php
                                                if (filter_var($allegato['link'], FILTER_VALIDATE_URL) === FALSE) { ?>
                                                <a href="/cv/{{$allegato['link']}}" target="_blank" title="Scarica Allegato"
                                                   class="waves-effect waves-light  btn-floating btn-small  white black-text" style="margin-right:20px"><i
                                                            class="mdi-file-file-download "></i></a>
                                                <?php }else{ ?>


                                                <a href="{{$allegato['link']}}"  style="margin-right:20px"target="_blank" title="Scarica Allegato"
                                                   class="waves-effect waves-light  btn-floating btn-small  white black-text"><i
                                                            class="mdi-file-file-download left"></i>{{trans('common.download')}}
                                                </a>


                                                <?php } ?>
                                                <a  style="margin-right:20px" data-href="/elimina/attachment/{{$allegato['id']}}"
                                                   title="Elimina allegato" data-method="GET"
                                                   class="waves-effect waves-light btn-floating btn-small white black-text action-button "><i
                                                            class="mdi-action-delete left"></i>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col s12 m4 l4">

                        <div class="btn load-file red">
                            <span>{{trans('profile.upload_cv')}}</span>
                        </div>

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
    <script>
        $(document).ready(function(){
            $('#attachments').DataTable( {
                responsive: true
            } );
        });
        $(".file-rename").on("click", function () {
            var id = $(this).attr("data-id");
            swal({
                title: trans('rename_file_title'),
                text: trans('rename_file_desc'),
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: ""
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                }
                $.ajax({ // make an AJAX request
                    type: "PATCH",
                    url: "/attachment/"+id,
                    dataType: 'json',
                    data: {"name" : inputValue},

                    success: function (data, textStatus, xhr) {
                        if(xhr.status == 201) {
                            swal(trans('ok_opt'), trans('rename_file_success'), "info");
                            window.location.reload();
                        } else {
                            swal(trans('error_occurred'), trans('error_occurred'), "error");
                        }
                    },
                    error: function (request, status, error) {
                        swal(trans('error_occurred'), trans('error_occurred'), "error");
                    }

                });


            });
        });
    </script>
@endsection

@section("page-css")
    <link href="https://cdn.datatables.net/rowreorder/1.1.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css" rel="stylesheet">

@endsection