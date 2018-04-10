@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/flag-icon.min.css') }}">

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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>Edit '{{ $resource->name }}'</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Administration</a></li>
                <li class="active">Edit User Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::model($resource, ['class' => 'form-horizontal','id'=>'edit_user_form']) !!}

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                {!! Form::label('name', 'Name: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>
                                {!! $errors->first('name', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                {!! Form::label('email', 'Email Address: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                </div>
                                {!! $errors->first('email', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
                            </div>

                            @if ($show == '0')

                                <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                    {!! Form::label('password', 'Password: ', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password" id="password">
                                        {!! $errors->first('password', '<div class="text-danger">:message</div>') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                                    {!! Form::label('password_confirmation', 'Confirm Password: ', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password_confirmation">
                                        {!! $errors->first('password_confirmation', '<div class="text-danger">:message</div>') !!}
                                    </div>
                                </div>

                                @if ( Shinobi::can( config('admin.acl.user.edit', false) ) )

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-3">
                                            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control userEditBtn']) !!}
                                        </div>

                                        @else

                                            <div class="col-sm-6 col-sm-offset-3 alert alert-danger lead">
                                                <i class="fa fa-exclamation-triangle fa-1x"></i> You are not permitted to {{ ( ($show == '0') ? 'edit' : 'view' ) }} users.
                                            </div>

                                        @endif
                                    </div>

                                @else
                                    <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <a href="{{ route('user.edit', $resource->id) }}" class="pull-right" title="Edit this User">
                                                <i class="fa fa-pencil fa-fw"></i>
                                                <span class="hidden-xs hidden-sm">Edit</span>
                                                </a>

                                            <a href="{{ route('user.role.edit', $resource->id) }}" title="Roles for this user">
                                                <i class="fa fa-key fa-fw"></i>
                                                <span class="hidden-xs hidden-sm">Roles</span>
                                                </a>
                                        </div>
                                    </div>
                                @endif
                                {!! Form::close() !!}
                        </div>

            </div>
            <!-- /.box-body -->
            <!-- /.box-footer-->
            <!-- /.box -->
        </section>
    <!-- /.content -->
    </div>

@endsection
@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay_progress.min.js')}}"></script>
<script>
  $('.userEditBtn').on('click', function (event) {

    $('#edit_user_form').validate({
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
          equalTo: '#password'
        },
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        name: {
          required: 'Please enter name',
          minlength: 'Your username must consist of at least 2 characters'
        },
        password: {
          required: 'Please provide a password',
          minlength: 'Your password must be at least 5 characters long'
        },
        password_confirmation: {
          required: 'Please provide a password',
          minlength: 'Your password must be at least 5 characters long',
          equalTo: 'Please enter the same password as above'
        },
        email: 'Please enter a valid email address',
      },

      submitHandler: function (form) {
        var request
        $.LoadingOverlay('show')

        if (request) {
          request.abort()
        }

        // setup some local variables
        var $form = $(this)

        // Let's select and cache all the fields
        var $inputs = $form.find('input, select, button, textarea')
        // Serialize the data in the form
        var serializedData = $('#edit_user_form').serialize()

        // Disabled form elements will not be serialized.
        $inputs.prop('disabled', true)

        var url = '/user/{{$resource->id}}'

        // Fire off the request to /form.php
        request = $.ajax({
          url: url,
          type: 'PATCH',
          data: serializedData,
        })

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR) {
          console.log(response)
          if (response === null || response === undefined || response.length <= 0 || response['status_code']===500) {
            $.LoadingOverlay('hide')
            swal(
              'Sorry...',
              'Something went wrong, Try Again!',
              'error'
            ).catch(swal.noop)
          } else if (response['status_code'] === 200) {
            $.LoadingOverlay('hide')
            var message = response['success'];
            swal({
              title: 'Successfully Submitted!',
              text: message,
              type: 'success'
            }).then(function () {
              // Refresh table
              $('#edit_user_form').trigger('reset')
              window.location='/user';
            }).catch(swal.noop)
          }
        })

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown) {
          $.LoadingOverlay('hide')
          if (jqXHR.responseJSON) {
            var errors = '<h3 class=\'space-down-15\'>Please correct them and try again.</h3>'
              + '<div class=\'list-group shrink-text-dot-8em push-down-10\'>'

            for (var key in jqXHR.responseJSON) {

              if (key == 'errors') {
                errors += '<div class=\'list-group-item text-left text-danger\'><strong>'
                  + jqXHR.responseJSON['errors'] + '</strong></div>'
              } else {
                errors += '<div class=\'list-group-item text-left text-danger\'><strong>'
                  + jqXHR.responseJSON[key][0] + '</strong></div>'
              }
            }

            errors += '</div>'

            swal({
              title: 'Sorry. We found some errors',
              html: errors,
              type: 'error',
              showCancelButton: true,
              showConfirmButton: false,
              cancelButtonText: 'Close',
            }).catch(swal.noop)
          } else {
            swal({
              title: 'Sorry...',
              text: 'Something went wrong, Please try again!',
              type: 'error',
              showCancelButton: true,
              showConfirmButton: false,
              cancelButtonText: 'Close',
            }).catch(swal.noop)
            $.LoadingOverlay('hide')
          }
        })

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
          //hide loader
          $.LoadingOverlay('hide')

          // Reenable the inputs
          $inputs.prop('disabled', false)
        })

      }
    })
  })
  event.preventDefault()
</script>
@endpush

