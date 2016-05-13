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
                <h4 class="header">Payments</h4>
                <div class="row">

                    <div class="col s12 m12 l12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Vacancy</th>
                                <th>Total</th>
                                <th>Transaction ID</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vacancies as $vacancy)
                                @if($vacancy['payment_date'] && $vacancy['payment_date']!=null)
                                    <?php
                                    $dataPagamento=new \DateTime($vacancy['payment_date']);
                                    ?>
                                <tr>
                                    <td>{{$dataPagamento->format("d-m-Y H:i")}}</td>
                                    <td>{{$vacancy['name']}}</td>
                                    <td>{{$vacancy['paypal_total']}}</td>
                                    <td>{{$vacancy['paypal_transaction_id']}}</td>
                                </tr>
                                @endif
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


@endsection



@section('page-scripts')

    <script type="text/javascript" src="/admin/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">

        $(document).ready(function () {
            $('#data-table-simple').DataTable({
                "paging": true,
                "ordering": true,
                "info": true
            });


        });



    </script>
@endsection