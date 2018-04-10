
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
            <h1>
                @lang('user.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Administration</a></li>
                <li class="active">Users Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">

                    <div class="btn-group pull-right" role="group" aria-label="...">
                        <a href="{{ route('user.matrix') }}">
                            <button type="button" class="btn btn-default">
                                <i class="fa fa-th fa-fw"></i>
                                <span class="hidden-xs hidden-sm">User Matrix</span>
                            </button></a>

                        <a href="{{ route('user.create') }}">
                            <button type="button" class="btn btn-info">
                                <i class="fa fa-plus fa-fw"></i>
                                <span class="hidden-xs hidden-sm">Add New User</span>
                            </button></a>
                    </div>

                </div>
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
                                        <th>Roles</th>
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
                                        <th>Roles</th>
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
        {data: 'roles', name: 'roles', orderable: false, searchable: false},
        {data: 'edit', name: 'edit', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],
      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><a href="/user/role/'+row.id+'/edit" class="btn btn-primary" >Roles </a></div>'

          },
          targets: 4
        },
        {
          render: function (data, type, row) {
            return '<div><a href="/user/'+row.id+'/edit" class="btn btn-default" style="color: green" >Edit </a></div>'

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
  function changeStatus (userId) {
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
            $.LoadingOverlay('hide')

            swal(
              'Deleted!',
              'The user has been deleted.',
              'success'
            )
            $('#users-table').DataTable().ajax.reload()
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