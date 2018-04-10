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
                @lang('order.titles.partiallypaid')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Orders</a></li>
                <li class="active">Partially Paid Orders</li>
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
                            <table id="partially-paid-orders-table" class="table table-bordered table-striped">
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
            @include('orders.modals.make-payment-modal')
        </section>
        <!-- /.content -->
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('js/spin.min.js') }}"></script>


<script type="text/javascript">
  $(document).ready(function () {
    $('#partially-paid-orders-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7,8]
          },
          filename: 'Partially Paid Orders List',
          title: 'Partially Paid Orders Data'
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7,8]
          },
          filename: 'Partially Paid Orders List',
          title: 'Partially Paid Orders Data'

        },
        {
          extend: 'pdfHtml5',
          buttonClass: 'table_button',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7,8]
          },
          filename: 'Partially Paid Orders List',
          title: 'Partially Paid Orders Data'
        },
      ],
      processing: true,
      serverSide: true,
      ajax: '/get/orders/data/PARTIALLY PAID',
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
            return '<div><a class="btn btn-primary" data-toggle="modal" data-target="#makePaymentModal" href="#" onclick="makePaymentDetails(' + row.order_id + ')">Make Payment</a></div>'
          },
          targets: 9
        }
      ]
    })
    $('#payment_method').on('change', function () {
      if (this.value === 'CASH') {
        $('.amount_to_pay').show()
        $('.mpesa_transaction').hide()
        $('.upload_cheque').hide()

      } else if (this.value === 'MPESA') {
        $('.amount_to_pay').show()
        $('.mpesa_transaction').show()
        $('.upload_cheque').hide()
      } else if (this.value === 'CHEQUE') {
        $('.amount_to_pay').show()
        $('.mpesa_transaction').hide()
        $('.upload_cheque').show()

      } else {
        $('.amount_to_pay').hide()
        $('.mpesa_transaction').hide()
        $('.upload_cheque').hide()
      }
    });
    $('#makePayment').on('click', function () {
      $('#make_payment_form').validate({
        rules: {
          payment_method: {
            required: true,
          },
          amount: {
            required: true,
            minlength: 1,
            maxlength: 255
          },
        },
        messages: {
          payment_method: {
            required: 'Please Select Customer',
          },
          amount: {
            required: 'Please enter amount',
            minlength: 'The amount must be 1 character long',
            maxlength: 'The amount  must be 255 characters long'
          },
        },
        submitHandler: function (form) {
          $('#loader').show()
          var opts = {
            lines: 12 // The number of lines to draw
            , length: 6 // The length of each line
            , width: 5 // The line thickness
            , radius: 5 // The radius of the inner circle
            , scale: 1 // Scales overall size of the spinner
            , corners: 1 // Corner roundness (0..1)
            , color: 'blue' // #rgb or #rrggbb or array of colors
            , opacity: 0.25 // Opacity of the lines
            , rotate: 0 // The rotation offset
            , direction: 1 // 1: clockwise, -1: counterclockwise
            , speed: 1 // Rounds per second
            , trail: 60 // Afterglow percentage
            , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
            , zIndex: 2e9 // The z-index (defaults to 2000000000)
            , className: 'spinner' // The CSS class to assign to the spinner
            , top: '50%' // Top position relative to parent
            , left: '50%' // Left position relative to parent
            , shadow: false // Whether to render a shadow
            , hwaccel: false // Whether to use hardware acceleration
            , position: 'absolute' // Element positioning
          }
          var target = document.getElementById('loader')
          var spinner = new Spinner(opts).spin(target)

          $.ajax({
            url: '/make/payment/order', // Url to which the request is send
            type: 'POST',             // Type of request to be send, called as method
            data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,        // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
              $('#loader').hide()
              if (JSON.stringify(data['status_code'] == 200)) {
                $('#loader').hide()
                $("#makePaymentModal").modal('hide');

                swal({
                  title: 'Successfully Submitted!',
                  text: 'Thank You.!',
                  type: 'success'
                }).then(function () {

                  $('#partially-paid-orders-table').DataTable().ajax.reload()

                  $('#make_payment_form').trigger('reset')

                }).catch(swal.noop)
              } else {
                $('#loader').hide()
                swal(
                  'Sorry...',
                  'Something went wrong, Try Again!',
                  'error'
                ).catch(swal.noop)
              }
            }
          })
          event.preventDefault()
        }
      })
    })
  })

  function makePaymentDetails (orderId) {
    $('#order_id').val(orderId)
  }


</script>

@endpush
