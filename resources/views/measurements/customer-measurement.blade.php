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
                @lang('measurement.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Measurements</a></li>
                <li class="active">Measurements Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <a class="btn btn-link" href="/add/measurement/{{$customerId}}">Add
                            Measurement</a>
                    </div>
                </div>

                <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="measurement-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Measurement Date</th>
                                    <th>Measurement For</th>
                                    <th>Measured By</th>
                                    <th>Description</th>
                                    <th>Measurement Status</th>
                                    <th>View</th>
                                    <th>Deactivate</th>

                                </tr>

                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Measurement Date</th>
                                    <th>Measurement For</th>
                                    <th>Measured By</th>
                                    <th>Description</th>
                                    <th>Measurement Status</th>
                                    <th>View</th>
                                    <th>Deactivate</th>
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
    var customerId = '{{$customerId}}'
    $('#measurement-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5 ]
          },
          filename: 'MeasurementsList',
          title: 'Measurements Data'
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5]
          },
          filename: 'EmployeesList',
          title: 'Measurements Data'

        },
        {
          extend: 'pdfHtml5',
          buttonClass: 'table_button',
          exportOptions: {
            columns: [0, 1, 2, 5]
          },
          filename: 'MeasurementsList',
          title: 'Measurements Data'
        },
      ],
      processing: true,
      serverSide: true,
      ajax: '/get/customer/measurements/'+customerId,
      columns: [
        {data: 'measurement_date', name: 'measurement_date'},
        {data: 'measurements_person_name', name: 'measurements_person_name'},
        {data: 'addedby_user_name', name: 'addedby_user_name'},
        {data: 'description', name: 'description'},
        {data: 'measurement_status', name: 'measurement_status'},
        {data: 'view', name: 'view', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],

      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><a href="/view/measurement/details/'+row.measurement_id+'" class="btn btn-primary">View Details </a></div>'

          },
          targets: 5
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.measurement_id + ')">Deactivate</button></div>'
          },
          targets: 6
        }
      ]
    })
  });
  function changeStatus (measurementId) {
    swal({
      title: 'Are you sure?',
      text: 'Once deactivated will not appear on the list',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Deactivate it!'
    }).then(function (result) {
      if (result['value'] = true) {
        var url = '/deactivate/measurement'
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            'measurement_id': measurementId,
            '_token': '{{ csrf_token() }}'
          },
          dataType: 'json',
          encode: true
        })
        // using the done promise callback
          .done(function (data) {

            if (data['status_code'] == 200) {
              swal(
                'Deactivated!',
                'Successfully Deactivated.!',
                'success'
              )
              $('#measurement-table').DataTable().ajax.reload()
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
