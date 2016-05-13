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
                <h4 class="header">Codici Sconto</h4>
                <div class="row">
                    <div class="col s3 m3 l3" style="margin-bottom:30px;">

                        <div class=" input-field ">
                            <div class="btn insert-sconto "

                            >
                                <span>Nuovo sconto</span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Sconto</th>
                                <th>Creato il</th>
                                <th>Attivo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sconti as $sconto)
                                <tr>
                                    <td>{{$sconto['id']}}</td>
                                    <td>{{$sconto['name']}}</td>
                                    <td>{{$sconto['sconto']}} €</td>
                                    <td>
                                        <?php
                                        $data = new \DateTime($sconto['created_at']);
                                        echo $data->format("d-m-Y H:i");
                                        ?>
                                    </td>
                                    <td class="change-status">
                                        <?php
                                        if($sconto['is_active']){
                                        ?>
                                        <i class="mdi-navigation-check green-text" data-val="0"
                                           data-id="{{$sconto['id']}}"></i>
                                        <?php }else{ ?>
                                        <i class="mdi-navigation-close red-text" data-val="1"
                                           data-id="{{$sconto['id']}}"></i>

                                        <?php } ?>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->


<!-- Compose Email Structure -->
<div id="modal-new-sconto" class="modal std-modal">
    <div class="modal-content">
        <nav class="red color-result darken-1">
            <div class="nav-wrapper">
                <div class="left col s12 m5 l5">
                    <ul>

                        <li><a lang="en" href="#!" class="email-type">Aggiungi uno sconto</a>
                        </li>
                    </ul>
                </div>


            </div>
        </nav>
    </div>
    <div class="model-email-content color-result">
        <div class="row">


            <form id="new-sconto" class="col s12" method="POST" action="">

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
                            <input name="name" id="vacancyAddName" type="text" class="validate" required>
                            <label lang="en" for="vacancyAddName">Nome Sconto</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="sconto" id="vacancyAddName" type="text" class="validate" required>
                            <label lang="en" for="vacancyAddName">Valore in Euro</label>
                        </div>
                    </div>

                    <input type="hidden" name="is_active" value="true">

                    <div class="input-field col s12">
                        <button lang="en" class="btn waves-effect waves-light right red submit btn-add-vacancy"
                                type="submit"
                                name="action">Aggiungi<i class="mdi-content-add right"></i>
                        </button>
                    </div>

                </div>

                <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                     class="center form-result animated fadeIn">
                    <div class="white-text">
                        <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Sconto creato
                        </h4>
                        <h6 lang="en">Sconto creato con successo..<br></h6>
                    </div>
                    <div class="button-action">
                        <button type="button" data-form="new-vacancy" lang="en"
                                class="waves-effect waves-light green darken-2 btn form-recreate-modal">Aggiungi nuovo
                        </button>
                        <button type="button" lang="en"
                                class="waves-effect waves-light green darken-2 btn modal-close">
                            Chiudi
                        </button>
                    </div>

                </div>

                <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                     class="center form-result-error animated fadeIn">
                    <div class="white-text">
                        <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to add member
                        </h4>
                        <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                    </div>
                    <div class="button-action">
                        <button type="button" data-form="new-vacancy" lang="en"
                                class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit data
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

    <script type="text/javascript" src="/admin/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">

        $(document).ready(function () {

            $(".insert-sconto").click(function () {

                $("#modal-new-sconto").openModal();

            });

            $(document).on("click",".change-status i",function () {
                var btn = $(this);
                $.ajax({
                    type: "PATCH",
                    url: "/admin/codici-sconto/" + btn.attr("data-id"),
                    data: {is_active: btn.attr("data-val")},
                    success: function (data, textStatus, xhr) {
                        if (xhr.status == 201 || xhr.status == 204) {
                            if (btn.attr("data-val") == 0) {
                                btn.replaceWith('<i class="mdi-navigation-close red-text" data-val="1" data-id="' + btn.attr("data-id") + '"></i>');
                            } else {
                                btn.replaceWith($('<i class="mdi-navigation-check green-text" data-val="0" data-id="' + btn.attr("data-id") + '"></i>'));
                            }

                        } else {
                            alert(data.responseJSON.message);
                        }
                    },
                    error: function (data, textStatus, xhr) {
                        alert(data.responseJSON.message);
                    },
                    dataType: "json"
                });
            });

            $("#new-sconto").submit(function (e) {
                e.preventDefault();
                var params = $(this).find("input").serialize();
                $("#new-sconto button").attr("disabled",true);
                $("#new-sconto input[type=submit]").button('loading');

                $.ajax({
                    type: "POST",
                    url: "/admin/codici-sconto",
                    data: params,
                    success: function (data, textStatus, xhr) {
                        $("#new-sconto button").attr("disabled",false);

                        if (xhr.status == 201 || xhr.status == 204) {
                            location.href = '';
                        } else {
                            $("#new-sconto input[type=submit]").button('reset');
                            alert(data.responseJSON.message);
                        }
                    },
                    error: function (data, textStatus, xhr) {
                        $("#new-sconto button").attr("disabled",false);

                        $("#new-sconto input[type=submit]").button('reset');
                        alert(data.responseJSON.message);
                    },
                    dataType: "json"
                });
            });


        });


    </script>
@endsection