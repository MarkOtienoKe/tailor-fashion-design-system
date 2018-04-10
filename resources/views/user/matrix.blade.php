@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<style>
    .content-header {
        color: purple;
    }
</style>

@endpush
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>User Matrix <small class="hidden-xs">Users that are on each role</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Administration</a></li>
                <li class="active">User Matrix Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="visible-xs alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                This page might not be formatted properly for this screen due to the complexity of Role Based Access Control permissioning.
                            </div>

                            {!! Form::open( ['class' => 'form-horizontal','id'=>'update_user_matrix_form'] ) !!}
                            <div class="table" style="max-height:500px; overflow:auto; border: 1px dashed;">
                                <table class="table table-bordered table-striped table-hover" style=" margin-bottom:0">
                                    <thead>
                                    <tr class="alert-warning">
                                        <th class="text-center">
                    <span class="pull-left"><span class="sr-only">Users</span>
                      <i class="fa fa-arrow-down"></i>
                      <i class="fa fa-user fa-lg"></i>
                    </span>

                                            <span class="pull-right"><span class="sr-only">Roles</span>
                    <i class="fa fa-users" title="Roles"></i>
                    <i class="fa fa-arrow-right"></i>
                    </span>
                                        </th>
                                        @foreach ($roles as $r)
                                            <th> {{ $r->name }} <a href="{{ route('role.show',$r->id) }}">
                                                    <button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-link"></span></button></a>
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($users as $u)
                                        <tr>
                                            <th class="">
                                                <a href="{{ route('user.show',$u->id) }}">
                                                    <button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-link"></span></button></a>
                                                {{ $u->name }}
                                            </th>
                                            @for ($i=0; $i < $roles->count(); $i++ )
                                                <td data-container="body" data-trigger="focus" data-toggle="popover" data-placement="left" data-content="Role: {{$roles[$i]->name}}, User: {{$u->email}}">
                                                    {!! Form::checkbox('role_user[]', $roles[$i]->id.":".$u->id, ( in_array( ($roles[$i]->id.":".$u->id), $pivot ) ? true : false ) ) !!}
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach

                                    <!-- table footer -->
                                    <tfoot>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>

                            @if ( Shinobi::can( config('admin.acl.user.usermatrix', false)) )
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        {!! Form::submit('Save User Role Changes', ['class' => 'btn btn-primary form-control updateUserMatrix']) !!}
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger lead">
                                    <i class="fa fa-exclamation-triangle fa-1x"></i> You are not permitted to sync user roles.
                                </div>
                            @endif
                            {!! Form::close() !!}

                        </div>
                        <!-- /.box-body -->
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
  $('.updateUserMatrix').on('click', function (event) {

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
    var serializedData = $('#update_user_matrix_form').serialize()

    // Disabled form elements will not be serialized.
    $inputs.prop('disabled', true)

    var url = '/user/matrix';

    // Fire off the request to /form.php
    request = $.ajax({
      url: url,
      type: 'post',
      data: serializedData,
    })

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
      if (response === null || response === undefined || response.length <= 0|| response['status_code']===500) {
        $.LoadingOverlay('hide')
        swal(
          'Sorry...',
          'Something went wrong, Try Again!',
          'error'
        ).catch(swal.noop)
      } else if (response['status_code'] === 200) {
        $.LoadingOverlay('hide')
        var message = response['message'];
        swal({
          title: 'Successfully Submitted!',
          text: message,
          type: 'success'
        }).then(function () {
          // Refresh table
          location.reload();
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
    event.preventDefault()

  })
</script>
@endpush

