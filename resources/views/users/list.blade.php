@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<style>
  .content-header {
    color: white;
  }
</style>

@endpush
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('user.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Users</a></li>
                <li class="active">Users Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <a class="btn btn-primary" id="new-user" data-toggle="modal" data-target="#createUserModal">Create New User</a>
                    </div>
                </div>
                <div class="box-header with-border">

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>


                </div>

                <div class="box-body">
                    <div class="box">

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                            <table id="users-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer-->
            <!-- /.box -->
        </section>
    @include('users.modals.create-user-modal')
    @include('users.modals.edit-user-modal')
    <!-- /.content -->
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('js/spin.min.js') }}"></script>



<script type="text/javascript">
  $(document).ready(function () {
    $('#users-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
      ],
      processing: true,
      serverSide: true,
      ajax: '{!! route('get.users.data') !!}',
      columns: [
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'status', name: 'status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'edit', name: 'edit', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],
      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><button type="button" onclick="getUserDetails(' + row.id + ',\'' + row.name + '\',\'' + row.email + '\')" class="btn btn-primary" data-toggle="modal" data-target="#editUserModal">Edit </button></div>'

          },
          targets: 4
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.id + ')">Deactivate</button></div>'
          },
          targets: 5
        }
      ]
    })
    $("#create_user_form").validate({
      rules: {
        name: {
          required: true,
          minlength: 2
        },
        password: {
          required: true,
          minlength: 5
        },
        password_confirmation: {
          required: true,
          minlength: 5,
          equalTo: "#password"
        },
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        name: {
          required: "Please enter name",
          minlength: "Your username must consist of at least 2 characters"
        },
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        password_confirmation: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long",
          equalTo: "Please enter the same password as above"
        },
        email: "Please enter a valid email address",
      },
      submitHandler: function (form) {
        var request;
        $('#loader').show();
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
        var target = document.getElementById('loader');
        var spinner = new Spinner(opts).spin(target);

        if (request) {
          request.abort();
        }

        // setup some local variables
        var $form = $(this);

        // Let's select and cache all the fields
        var $inputs = $form.find('input, select, button, textarea');
        // Serialize the data in the form
        var serializedData = $('#create_user_form').serialize();

        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);

        var url = '/create/user';

        // Fire off the request to /form.php
        request = $.ajax({
          url: url,
          type: "post",
          data: serializedData,
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR) {
          if (response === null || response === undefined || response.length <= 0) {
            $('#loader').hide();
            swal(
              'Sorry...',
              'Something went wrong, Try Again!',
              'error'
            ).catch(swal.noop);
          } else {
            $('#loader').hide();
            $("#createUserModal").modal('hide');

            swal({
              title: 'Successfully Submitted!',
              text: 'Thank You!',
              type: 'success'
            }).then(function () {
              // Refresh table
              $('#users-table').DataTable().ajax.reload();

              $("#create_user_form").trigger('reset');
            }).catch(swal.noop);
          }
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown) {
          $('#loader').hide();
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
            $('#loader').hide();
          }
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
          //hide loader
          $('#loader').hide();

          // Reenable the inputs
          $inputs.prop("disabled", false);
        });

      }
    });
  });

  $(function () {
    $("#edit_user_form").validate({
      rules: {
        name: {
          required: true,
          minlength: 2
        },
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        name: {
          required: "Please enter name",
          minlength: "Your username must consist of at least 2 characters"
        },
        email: "Please enter a valid email address",
      },
      submitHandler: function(form) {
        var request;
        $('#edit_loader').show();
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
        var target = document.getElementById('edit_loader');
        var spinner = new Spinner(opts).spin(target);

        if (request) {
          request.abort();
        }

        // setup some local variables
        var $form = $(this);

        // Let's select and cache all the fields
        var $inputs = $form.find('input, select, button, textarea');
        // Serialize the data in the form
        var serializedData = $('#edit_user_form').serialize();

        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);

        var url = '/edit/user';

        // Fire off the request to /form.php
        request = $.ajax({
          url: url,
          type: "post",
          data: serializedData,
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR) {
          if (response === null || response === undefined || response.length <= 0) {
            $('#edit_loader').hide();
            swal(
              'Sorry...',
              'Something went wrong, Try Again!',
              'error'
            ).catch(swal.noop);
          } else {
            $('#edit_loader').hide();
            $("#editUserModal").modal('hide');

            swal({
              title: 'Successfully Submitted!',
              text: 'Thank You!',
              type: 'success'
            }).then(function () {
              // Refresh table
              $('#users-table').DataTable().ajax.reload();

              $("#edit_user_form").trigger('reset');
            }).catch(swal.noop);
          }
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown) {
          $('#edit_loader').hide();
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
          $('#edit_loader').hide();

          // Reenable the inputs
          $inputs.prop("disabled", false);
        });

      }
    });
  });
    function getUserDetails (id,name,email) {
      $("#editUserModal #userId").val(id)
      $('#edit_user_form #edit_name').val(name)
      $('#editUserModal #edit_user_form #edit_email').val(email)
    }
    function changeStatus (userId) {
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result==true) {
        var url = '/deactivate/user'
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            'user_id': userId,
            '_token': '{{ csrf_token() }}'
          },
          dataType: 'json',
          encode: true
        })
        // using the done promise callback
          .done(function (data) {

           if(data['status_code']==200){
             swal(
               'Deleted!',
               'The user has been deleted.',
               'success'
             )
             $('#users-table').DataTable().ajax.reload()
           }else{
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
