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

</style>

@endpush
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>'{{ $user->name }}' Roles</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Administration</a></li>
                <li class="active">Users Roles Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::model($user, [ 'route' => [ 'user.role.update', $user->id ], 'class' => 'form-horizontal','id'=>'update_user_roles_form']) !!}

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading clearfix">
                                    <h2 class="panel-title"><i class="fa fa-lg fa-users"></i> Current Roles
                                        <small>({{$roles->count()}})</small>
                                    </h2>
                                </div>

                                <div class="panel-body">
                                    @forelse($roles->chunk(6) as $c)
                                        @foreach ($c as $r)
                                            <div class="col-md-2 col-sm-3 col-xs-4">
                                                <label class="checkbox-inline" title="{{ $r->id }}">
                                                    <input type="checkbox" name="ids[]" value="{{$r->id}}"
                                                           checked=""> {{ $r->name }}
                                                    @if ($r->special == 'all-access')
                                                        <i class="fa fa-star text-success"></i>
                                                    @elseif ($r->special == 'no-access')
                                                        <i class="fa fa-ban text-danger"></i>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    @empty
                                        <span class="text-warning"><i class="fa fa-warning text-warning"></i> This user does not have any defined roles.</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading clearfix">
                                    <h2 class="panel-title">
                                        <i class="fa fa-users"></i> Available Roles
                                        <small>({{$available_roles->count()}})</small>
                                    </h2>
                                </div>

                                <div class="panel-body">
                                    @forelse($available_roles->chunk(6) as $chunk)
                                        @foreach ($chunk as $ar)
                                            <div class="col-md-2 col-sm-3 col-xs-4">
                                                <label class="checkbox-inline" title="{{ $ar->id }}">
                                                    <input type="checkbox" name="ids[]"
                                                           value="{{$ar->id}}"> {{ $ar->name }}
                                                    @if ($ar->special == 'all-access')
                                                        <i class="fa fa-star text-success"></i>
                                                    @elseif ($ar->special == 'no-access')
                                                        <i class="fa fa-ban text-danger"></i>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    @empty
                                        <span class="text-danger"><i class="fa fa-warning text-danger"></i> There aren't any available roles.</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3">
                            {!! Form::submit('Update Roles', ['class' => 'btn btn-primary form-control updateUserRoles']) !!}
                        </div>
                        <div class="col-sm-9">
                            <button class="btn btn-info pull-right" type="button" data-toggle="collapse"
                                    data-target="#collapsePermissions" aria-expanded="false"
                                    aria-controls="collapsePermissions">
                                Toggle Permissions
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}

                    <div class="row panel-collapse collapse" id="collapsePermissions">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-info">
                                <div class="panel-heading clearfix">
                                    <h2 class="panel-title"><i class="fa fa-key"></i> {{$user->name}}'s Permissions
                                        (from current roles)</h2>
                                </div>

                                <div class="panel-body">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <ul class="list-unstyled">
                                            @forelse($roles as $prole)
                                                <li><strong>{{$prole->name}}</strong></li>
                                                <ul>
                                                    @if ($prole->special == 'all-access')
                                                        <li><i class="fa fa-fw fa-star text-success"></i> All Access
                                                        </li>
                                                    @elseif ($prole->special == 'no-access')
                                                        <li><i class="fa fa-fw fa-ban text-danger"></i> No Access</li>
                                                    @else
                                                        @forelse($prole->permissions as $p)
                                                            <li>{{$p->name}} <em>({{ $p->slug }})</em></li>
                                                        @empty
                                                            <li>This role has no defined permissions</li>
                                                        @endforelse
                                                    @endif
                                                </ul>
                                            @empty
                                                <span class="text-danger"><i class="fa fa-warning text-danger"></i> There are no permissions defined for this user.</span>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


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
  $('.updateUserRoles').on('click', function (event) {

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
        var serializedData = $('#update_user_roles_form').serialize()

        // Disabled form elements will not be serialized.
        $inputs.prop('disabled', true)

        var url = '/user/role/{{$user->id}}'

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

