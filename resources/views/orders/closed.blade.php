@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<style>
    .buttons-print {
        background-color: #7a0428;
        color: white;
    }
    .buttons-excel {
        background-color: #1a225e;
        color: white;
    }
    .buttons-csv {
        background-color: #030b4c;
        color: white;
    }
    .buttons-pdf {
        background-color: #125442;
        color: white;
    }
    .content-header{
        color: purple;
    }
</style>

@endpush
@section('content')

    <!-- Page heading ends -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('order.titles.closed')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Orders</a></li>
                <li class="active">Closed Orders</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="closed-orders-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Cost</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Date Of Collection</th>
                                    <th>Status</th>
                                    <th>Created At</th>

                                </tr>

                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Cost</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Date Of Collection</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('js/spin.min.js') }}"></script>


<script type="text/javascript">
  $(document).ready(function () {
    $('#closed-orders-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7, 8]
          },
          filename: 'Closed Orders List',
          title: 'Closed Orders Data'
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7, 8]
          },
          filename: 'Closed Orders List',
          title: 'Closed Orders Data'

        },
        {
          extend: 'pdfHtml5',
          buttonClass: 'table_button',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7, 8]
          },
          filename: 'Closed Orders List',
          title: 'Closed Orders Data'
        },
      ],
      processing: true,
      serverSide: true,
      ajax: '/get/orders/data/CLOSED',
      columns: [
        {data: 'customer_name', name: 'customer_name'},
        {data: 'date_received', name: 'date_received'},
        {data: 'amount_to_pay', name: 'amount_to_pay'},
        {data: 'amount_paid', name: 'amount_paid'},
        {data: 'balance', name: 'balance'},
        {data: 'date_of_collection', name: 'date_of_collection'},
        {data: 'order_status', name: 'order_status'},
        {data: 'created_at', name: 'created_at'},
      ],

    })
  });

</script>

@endpush
