
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
            <h1>
               Roles
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Administration</a></li>
                <li class="active">Roles Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">

                    <div class="btn-group pull-right" role="group" aria-label="...">
                        @if ( Shinobi::can( config('admin.acl.role.viewmatrix', false) ) )
                            <a href="{{ route('role.matrix') }}">
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-th fa-fw"></i>
                                    <span class="hidden-xs hidden-sm">Role Matrix</span>
                                </button></a>
                        @endif

                        @if ( Shinobi::can( config('admin.acl.role.create', false) ) )
                            <a href="{{ route( 'role.create') }}">
                                <button type="button" class="btn btn-info">
                                    <i class="fa fa-plus fa-fw"></i>
                                    <span class="hidden-xs hidden-sm">Add New Role</span>
                                </button></a>
                        @endif
                    </div>
                </div>
                        <!-- /.box-header -->


                <div class="box-body">
                    <div class="table-responsive">
                        <table id="roles-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

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
<script src="{{ URL::asset('js/spin.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay_progress.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#roles-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
      ],
      processing: true,
      serverSide: true,
      ajax: '{!! route('roles.data') !!}',
      columns: [
        {data: 'name', name: 'name'},
        {data: 'slug', name: 'slug'},
        {data: 'description', name: 'description'},
        {data: 'permissions', name: 'permissions'},
        {data: 'users', name: 'users', orderable: false, searchable: false},
        {data: 'update', name: 'update', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],
      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><a href="/role/permission/'+row.id+'/edit" class="btn btn-primary btn-xs" > <i class="fa fa-key fa-fw"></i><span class="hidden-xs hidden-sm">Permissions</span> </a></div>'

          },
          targets: 3
        },
        {
          render: function (data, type, row) {
            return '<div><a href="/role/user/'+row.id+'/edit" class="btn btn-primary btn-xs"><i class="fa fa-user fa-fw"></i><span class="hidden-xs hidden-sm">Users</span> </a></div>'

          },
          targets: 4
        },
        {
          render: function (data, type, row) {
            return '<div><a href="/role/'+row.id+'/edit" class="btn btn-default" style="color: green" ><i class="fa fa-pencil fa-fw"></i><span class="hidden-xs hidden-sm">Update</span></a></div>'

          },
          targets: 5
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.id + ')">Deactivate</button></div>'
          },
          targets: 6
        }
      ]
    })
  });
  function changeStatus (roleId) {
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

        var url = '/deactivate/role'
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            'role_id': roleId,
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
                'The user has been deleted.',
                'success'
              )
              $('#roles-table').DataTable().ajax.reload()
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
