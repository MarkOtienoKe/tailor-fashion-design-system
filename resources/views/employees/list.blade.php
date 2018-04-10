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
                @lang('employee.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Employees</a></li>
                <li class="active">Employees Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <a class="btn btn-link" href="/employees/create">Create
                            New Employee</a>
                    </div>
                </div>

                <div class="box-body">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="employees-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Id Number</th>
                                        <th>Date Of Employment</th>
                                        <th>Salary</th>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Edit</th>
                                        <th>Deactivate</th>

                                    </tr>

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Id Number</th>
                                        <th>Date Of Employment</th>
                                        <th>Salary</th>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Edit</th>
                                        <th>Deactivate</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    @include('employees.modals.create-designation-modal')
    @include('employees.modals.edit-employee-modal')
    <!-- /.content -->
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay_progress.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $('#employees-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7, 8, 9]
          },
          filename: 'EmployeesList',
          title: 'Employees Data'
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7, 8, 9]
          },
          filename: 'EmployeesList',
          title: 'Employees Data'

        },
        {
          extend: 'pdfHtml5',
          buttonClass: 'table_button',
          exportOptions: {
            columns: [0, 1, 2, 5, 6, 7, 8, 9]
          },
          filename: 'EmployeesList',
          title: 'Employees Data'
        },
      ],
      processing: true,
      serverSide: true,
      ajax: '{!! route('get.employees.data') !!}',
      columns: [
        {data: 'employee_name', name: 'employee_name'},
        {data: 'employee_email', name: 'employee_email'},
        {data: 'employee_mobile_no', name: 'employee_mobile_no'},
        {data: 'employee_address', name: 'employee_address'},
        {data: 'employee_id_no', name: 'employee_id_no'},
        {data: 'date_of_employment', name: 'date_of_employment'},
        {data: 'salary', name: 'salary'},
        {data: 'position', name: 'position'},
        {data: 'employee_status', name: 'employee_status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'edit', name: 'edit', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],

      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><a href="/edit/employee/view/'+row.employee_id+'" class="btn btn-primary">Edit </a></div>'

          },
          targets: 10
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.employee_id + ')">Deactivate</button></div>'
          },
          targets: 11
        }
      ]
    })
  });

  function changeStatus (customerId) {
    swal({
      title: "Are you sure?",
      text: "Once deactivated will not appear on the list",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Deactivate it!"
    }).then(function(result) {
      if(result['value']==true){
        $.LoadingOverlay('show')

        var url = '/deactivate/Customer'
        console.log(url)
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

            if (data['status_code'] == 200) {
              $.LoadingOverlay('hide')

              swal(
                'Deleted!',
                'The Customer has been deleted.',
                'success'
              )
              $('#customers-table').DataTable().ajax.reload()
            } else {
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
    });
  }

</script>

@endpush
