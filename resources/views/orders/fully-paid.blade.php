@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
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

    .content-header {
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
                @lang('order.titles.fullypaid')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Orders</a></li>
                <li class="active">Fully Paid Orders</li>
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
                            <table id="fully-paid-orders-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Cost</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Date Of Collection</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th></th>

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
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('js/spin.min.js') }}"></script>


<script type="text/javascript">
  $(document).ready(function () {
    $('#fully-paid-orders-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7,8]
          },
          filename: 'Fully Paid Orders List',
          title: 'Fully Paid Orders Data'
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7,8]
          },
          filename: 'Fully Paid Orders List',
          title: 'Fully Paid Orders Data'

        },
        {
          extend: 'pdfHtml5',
          buttonClass: 'table_button',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7,8]
          },
          filename: 'Fully Paid Orders List',
          title: 'Fully Paid Orders Data'
        },
      ],
      processing: true,
      serverSide: true,
      ajax: '/get/orders/data/FULLY PAID',
      columns: [
        {data: 'customer_name', name: 'customer_name'},
        {data: 'date_received', name: 'date_received'},
        {data: 'amount_to_pay', name: 'amount_to_pay'},
        {data: 'amount_paid', name: 'amount_paid'},
        {data: 'balance', name: 'balance'},
        {data: 'date_of_collection', name: 'date_of_collection'},
        {data: 'addedby_user_name', name: 'addedby_user_name'},
        {data: 'order_status', name: 'order_status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'make-payment', name: 'make-payment'},
      ],

      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="closeOrder(' + row.order_id + ')">Close</button></div>'
          },
          targets: 9
        }
      ]
    })
  })

  function closeOrder (orderId) {
    swal({
      title: 'Are you sure?',
      text: 'Once closed will not appear on the list',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Close it!'
    }).then(function (result) {
      if (result['value'] = true) {
        var url = '/close/order'
        console.log(url)
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            'order_id': orderId,
            '_token': '{{ csrf_token() }}'
          },
          dataType: 'json',
          encode: true
        })
        // using the done promise callback
          .done(function (data) {

            if (data['status_code'] == 200) {
              swal(
                'Closed!',
                'The closed has been deleted.',
                'success'
              )
              $('#fully-paid-orders-table').DataTable().ajax.reload()
            } else {
              'Error!',
                'An error occured.',
                'error'
            }
            // here we will handle errors and validation messages
          })

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault()
      }
    })
  }

</script>

@endpush
