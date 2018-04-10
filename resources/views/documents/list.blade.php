@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/flag-icon.min.css') }}">

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
                @lang('document.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Documents</a></li>
                <li class="active">Documents Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <a class="btn btn-primary" id="new-doc">Create New Document</a>
                    </div>
                </div>

                <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="doc-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Document Type</th>
                                    <th>Description</th>
                                    <th>Document Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    <th>Deactivate</th>

                                </tr>

                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Document Type</th>
                                    <th>Description</th>
                                    <th>Document Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
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
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay_progress.min.js')}}"></script>


<script type="text/javascript">
  $(document).ready(function () {
    $('#doc-table').DataTable({
      dom: '<\'row table-controls\'<\'col-sm-4 col-md-3 page-length\'l><\'col-sm-6 col-md-6 search\'f><\'col-sm-6 col-md-3 text-right\'B>><\'row\'<\'col-md-12\'rt>><\'row space-up-10\'<\'col-md-6\'i><\'col-md-6\'p>>',
      buttons: [
        'print',
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5]
          },
          filename: 'MaterialsList',
          title: 'Materials Data'
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [0, 1, 2, 5]
          },
          filename: 'ExpenseList',
          title: 'Expenses Data'

        },
        {
          extend: 'pdfHtml5',
          buttonClass: 'table_button',
          exportOptions: {
            columns: [0, 1, 2, 5]
          },
          filename: 'ExpenseList',
          title: 'Expenses Data'
        },
      ],
      processing: true,
      serverSide: true,
      ajax: '/get/all/documents/data',
      columns: [
        {data: 'document_name', name: 'document_name'},
        {data: 'document_type', name: 'document_type'},
        {data: 'description', name: 'description'},
        {data: 'document_status', name: 'document_status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],

      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><a href="/download/document/'+row.document_id+'" class="btn btn-primary" >Download Document </a></div>'

          },
          targets: 5
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.document_id + ')">Deactivate</button></div>'
          },
          targets: 6
        }
      ]
    })

    $('#new-doc').on('click', function () {
      swal({
        title: 'Create New Document',
        html: '<form id="add_doc_form"><input id="doc_name" class="swal2-input" placeholder="Enter Document Name" name="document_name"><input id="doc_type" class="swal2-input" placeholder="Enter Document Type" name="document_type">' +
        '<textarea id="doc_description" class="swal2-textarea" placeholder="Enter description" name="description"></textarea>' +
        '<div><label>Upload File</label><input type="file" id="doc_file" name="document_file"></div></form>',
        focusConfirm: false,
        showConfirmButton: true,
        showCancelButton: true
      }).then(function (result) {
        if (result === true) {
          $.LoadingOverlay('show')
          var form = document.getElementById('add_doc_form')
          var formData = new FormData(form)
          $.ajax({
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/create/document',
            processData: false,
            contentType: false,
            data: formData
          }).done(function (data) {
            $.LoadingOverlay('hide')
            if (data.message = 'success') {
              $('#doc-table').DataTable().ajax.reload()

              swal({
                title: 'Document Successfully Submitted !',
                text: data.message,
                type: 'success',
                showCancelButton: true,
                cancelButtonColor: '#12a8bc',
                showConfirmButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: 'sweetalert-lg'
              }).catch(swal.noop)
            } else {
              swal({
                title: 'Sorry. We found some errors!',
                type: 'error',
                showCancelButton: true,
                allowOutsideClick: false,
                showConfirmButton: false,
                allowEscapeKey: false,
                cancelButtonText: 'Close',
                customClass: 'sweetalert-lg',
              }).catch(swal.noop)
            }
          }).error(function (response) {
            $.LoadingOverlay('hide')

            var errorText = '<div class=\'list-group shrink-text-dot-8em push-down-10\'>'
            var errors = JSON.parse(response.responseText)

            for (var key in errors) {
              errorText += '<div class=\'list-group-item text-left text-danger\'><strong>'
                + errors[key][0].message + '</strong></div>'
            }

            errorText += '</div>'

            swal({
              title: 'Sorry. We found some errors!',
              html: errorText,
              type: 'error',
              showCancelButton: true,
              allowOutsideClick: false,
              showConfirmButton: false,
              allowEscapeKey: false,
              cancelButtonText: 'Close',
              customClass: 'sweetalert-lg',
            }).catch(swal.noop)
          })
        }
      })
    })
  })

  function changeStatus (docId) {
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
        var url = '/deactivate/document'
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            'document_id': docId,
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
              $('#doc-table').DataTable().ajax.reload()
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
