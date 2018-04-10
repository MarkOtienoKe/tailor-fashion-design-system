@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
{{--<link rel="stylesheet" href="{{ URL::asset('css/screen.css') }}">--}}
<style>
  .content-header {
    color: purple;
  }
  .error{
    color:red;
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
                @lang('customer.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Customers</a></li>
                <li class="active">Customers Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <a class="btn btn-link" id="new-user" data-toggle="modal" data-target="#createCustomerModal">Create New Customer</a>
                    </div>
                </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="customers-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Location</th>
                                        <th>Id Number</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Location</th>
                                        <th>Id Number</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer-->
            <!-- /.box -->
        </section>
    @include('customers.modals.create-customer-modal')
    @include('customers.modals.edit-customer-modal')
    <!-- /.content -->
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay_progress.min.js')}}"></script>


<script type="text/javascript">
  $(document).ready(function () {
    $('#customers-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
      {
        extend: 'csvHtml5',
        exportOptions: {
          columns: [ 0, 1, 2, 5,6]
        }
      },
        {
        extend: 'excelHtml5',
        exportOptions: {
          columns: [ 0, 1, 2, 5,6]
        }
      },
      {
        extend: 'pdfHtml5',
        exportOptions: {
          columns: [ 0, 1, 2, 5,6]
        }
      },
      ],
      processing: true,
      serverSide: true,
      ajax: '{!! route('get.customers.data') !!}',
      columns: [
        {data: 'customer_name', name: 'customer_name'},
        {data: 'customer_email', name: 'customer_email'},
        {data: 'customer_mobile_no', name: 'customer_mobile_no'},
        {data: 'location', name: 'location'},
        {data: 'customer_id_no', name: 'customer_id_no'},
        {data: 'customer_status', name: 'customer_status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'edit', name: 'edit', orderable: false, searchable: false},
        {data: 'measurement', name: 'measurement', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],
      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><button type="button" onclick="getCustomerDetails(' + row.customer_id + ',\'' + row.customer_name + '\',\'' + row.customer_email + '\',\'' + row.customer_mobile_no + '\',\'' + row.location + '\',\'' + row.customer_id_no + '\')" class="btn btn-primary" data-toggle="modal" data-target="#editCustomerModal">Edit </button></div>'

          },
          targets: 7
        },
        {
          render: function (data, type, row) {
            return '<div><a class="btn btn-warning" href="/view/customer/measurements/' + row.customer_id + '">Measurements</a></div>'
          },
          targets: 8
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.customer_id + ')">Deactivate</button></div>'
          },
          targets: 9
        }
      ]
    })

    $("#create_customer_form").validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
          maxlength: 255,
        },
        mobile: {
          required: true,
          minlength: 10,
          maxlength: 10,
          number: true,
        },
        id_number: {
          required: true,
          minlength: 2,
          maxlength:15,
          number: true,
        },
        location: {
          required: true,
          minlength: 2,
          maxlength:255
        },
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        name: {
          required: "Please enter name",
          minlength: "Your name must consist of at least 2 characters"
        },
        mobile: {
          required: "Please enter your phone number",
          minlength: "Your phone number must be 10 numbers",
          maxlength: "Your phone number must be 10 numbers"
        },
        location: {
          required: "Please enter your location",
          minlength: "Your location must be atleast 2 characters long",
          maxlength: "Your location must be atmost 255 characters long"
        },
        id_number: {
          required: "Please enter your Id Number",
          minlength: "Your Id Number must be 8 characters long",
          maxlength: "Your location must be 8 characters long"
        },
        email: "Please enter a valid email address",
      },
      submitHandler: function (form) {
        var request;
        $.LoadingOverlay('show')

        if (request) {
          request.abort();
        }

        // setup some local variables
        var $form = $(this);

        // Let's select and cache all the fields
        var $inputs = $form.find('input, select, button, textarea');
        // Serialize the data in the form
        var serializedData = $('#create_customer_form').serialize();

        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);

        var url = '/create/customer';

        // Fire off the request to /form.php
        request = $.ajax({
          url: url,
          type: "post",
          data: serializedData,
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR) {
          if (response === null || response === undefined || response.length <= 0) {
            $.LoadingOverlay('hide')
            swal(
              'Sorry...',
              'Something went wrong, Try Again!',
              'error'
            ).catch(swal.noop);
          } else {
            $.LoadingOverlay('hide')
            $("#createCustomerModal").modal('hide');

            swal({
              title: 'Successfully Submitted!',
              text: 'Thank You!',
              type: 'success'
            }).then(function () {
              // Refresh table
              $('#customers-table').DataTable().ajax.reload();

              $("#create_customer_form").trigger('reset');
            }).catch(swal.noop);
          }
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown) {
          $.LoadingOverlay('hide')
          if (jqXHR.responseJSON) {
            var errors = "<h3 class='space-down-15'>Please correct them and try again.</h3>"
              + "<div class='list-group shrink-text-dot-8em push-down-10'>";

            for (var key in jqXHR.responseJSON) {

              if (key=='errors'){
                errors += "<div class='list-group-item text-left text-danger'><strong>"
                  + jqXHR.responseJSON['errors'] + "</strong></div>";
              }else{
                errors += "<div class='list-group-item text-left text-danger'><strong>"
                  + jqXHR.responseJSON[key][0] + "</strong></div>";
              }
            }

            errors += "</div>";

            swal({
              title: 'Sorry. We found some errors',
              html: errors,
              type: 'error',
              showCancelButton: true,
              showConfirmButton: false,
              cancelButtonText: 'Close',
            }).catch(swal.noop);
          } else {
            swal({
              title: 'Sorry...',
              text: 'Something went wrong, Please try again!',
              type: 'error',
              showCancelButton: true,
              showConfirmButton: false,
              cancelButtonText: 'Close',
            }).catch(swal.noop);
            $.LoadingOverlay('hide')
          }
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
          //hide loader
          $.LoadingOverlay('hide')

          // Reenable the inputs
          $inputs.prop("disabled", false);
        });

      }
    });
  });

  $(function () {
    $("#edit_customer_form").validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
          maxlength: 255,
        },
        mobile: {
          required: true,
          minlength: 10,
          maxlength: 10
        },
        id_number: {
          required: true,
          minlength: 8,
          maxlength:8
        },
        location: {
          required: true,
          minlength: 2,
          maxlength:255
        },
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        name: {
          required: "Please enter name",
          minlength: "Your name must consist of at least 2 characters"
        },
        mobile: {
          required: "Please enter your phone number",
          minlength: "Your phone number must be 10 numbers",
          maxlength: "Your phone number must be 10 numbers"
        },
        location: {
          required: "Please enter your location",
          minlength: "Your location must be atleast 2 characters long",
          maxlength: "Your location must be atmost 255 characters long"
        },
        id_number: {
          required: "Please enter your Id Number",
          minlength: "Your Id Number must be 8 characters long",
          maxlength: "Your location must be 8 characters long"
        },
        email: "Please enter a valid email address",
      },
      submitHandler: function(form) {
        var request;
        $.LoadingOverlay('show')

        if (request) {
          request.abort();
        }

        // setup some local variables
        var $form = $(this);

        // Let's select and cache all the fields
        var $inputs = $form.find('input, select, button, textarea');
        // Serialize the data in the form
        var serializedData = $('#edit_customer_form').serialize();

        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);

        var url = '/edit/customer';

        // Fire off the request to /form.php
        request = $.ajax({
          url: url,
          type: "post",
          data: serializedData,
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR) {
          if (response === null || response === undefined || response.length <= 0) {
            $.LoadingOverlay('hide')
            swal(
              'Sorry...',
              'Something went wrong, Try Again!',
              'error'
            ).catch(swal.noop);
          } else {
            $.LoadingOverlay('hide')
            $("#editCustomerModal").modal('hide');

            swal({
              title: 'Successfully Submitted!',
              text: 'Thank You!',
              type: 'success'
            }).then(function () {
              // Refresh table
              $('#customers-table').DataTable().ajax.reload();

              $("#edit_customer_form").trigger('reset');
            }).catch(swal.noop);
          }
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown) {
          $.LoadingOverlay('hide')
          if (jqXHR.responseJSON) {
            var errors = "<h3 class='space-down-15'>Please correct them and try again.</h3>"
              + "<div class='list-group shrink-text-dot-8em push-down-10'>";

            for (var key in jqXHR.responseJSON) {

              if (key=='errors'){
                errors += "<div class='list-group-item text-left text-danger'><strong>"
                  + jqXHR.responseJSON['errors'] + "</strong></div>";
              }else{
                errors += "<div class='list-group-item text-left text-danger'><strong>"
                  + jqXHR.responseJSON[key][0] + "</strong></div>";
              }
            }

            errors += "</div>";

            swal({
              title: 'Sorry. We found some errors',
              html: errors,
              type: 'error',
              showCancelButton: true,
              showConfirmButton: false,
              cancelButtonText: 'Close',
            }).catch(swal.noop);
          } else {
            swal({
              title: 'Sorry...',
              text: 'Something went wrong, Please try again!',
              type: 'error',
              showCancelButton: true,
              showConfirmButton: false,
              cancelButtonText: 'Close',
            }).catch(swal.noop);
            $('#edit_loader').hide();
          }
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
          //hide loader
          $.LoadingOverlay('hide')

          // Reenable the inputs
          $inputs.prop("disabled", false);
        });

      }
    });
  });
  function getCustomerDetails (id,name,email,mobile,location,idNumber) {
    $("#editCustomerModal #customerId").val(id)
    $('#editCustomerModal #edit_name').val(name)
    $('#editCustomerModal #edit_customer_form #edit_email').val(email)
    $('#editCustomerModal #edit_customer_form #edit_mobile').val(mobile)
    $('#editCustomerModal #edit_customer_form #edit_location').val(location)
    $('#editCustomerModal #edit_customer_form #edit_id_number').val(idNumber)
  }
  function changeStatus (customerId) {
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then(function (result) {
      if (result==true) {
        $.LoadingOverlay('show')

        var url = '/deactivate/customer'
      $.ajax({
        type: 'POST',
        url: url,
        data: {
          'customer_id': customerId,
          '_token': '{{ csrf_token() }}'
        },
        dataType: 'json',
        encode: true
      })
      // using the done promise callback
        .done(function (data) {

          if(data['status_code']==200){
            $.LoadingOverlay('hide')

            swal(
              'Deleted!',
              'The Customer has been deleted.',
              'success'
            )
            $('#customers-table').DataTable().ajax.reload()
          }else{
            $.LoadingOverlay('hide')

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
