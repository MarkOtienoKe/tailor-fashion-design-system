@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/.css') }}">

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
                @lang('material.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Materials</a></li>
                <li class="active">Materials Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <a class="btn btn-primary" id="new-material">Create New Material</a>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-secondary" id="view_material_images" href="/view/images" style="color: purple">View Material
                            Images</a>
                    </div>
                </div>

                <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="materials-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Material Name</th>
                                    <th>Description</th>
                                    <th>Material Image</th>
                                    <th>Material Status</th>
                                    <th>Created At</th>
                                    <th>Image Action</th>
                                    <th>Edit</th>
                                    <th>Deactivate</th>

                                </tr>

                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Material Name</th>
                                    <th>Description</th>
                                    <th>Material Image</th>
                                    <th>Material Status</th>
                                    <th>Created At</th>
                                    <th>Image Action</th>
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
    @include('materials.modals.create-material-modal')
    @include('employees.modals.edit-employee-modal')
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
    $('#materials-table').DataTable({
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
          filename: 'MaterialsList',
          title: 'Materials Data'

        },
        {
          extend: 'pdfHtml5',
          buttonClass: 'table_button',
          exportOptions: {
            columns: [0, 1, 2, 5]
          },
          filename: 'MaterialsList',
          title: 'Materials Data'
        },
      ],
      processing: true,
      serverSide: true,
      ajax: '/get/all/materials/data',
      columns: [
        {data: 'material_name', name: 'material_name'},
        {data: 'description', name: 'description'},
        {data: 'material_image', name: 'material_image'},
        {data: 'material_status', name: 'material_status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'image-upload', name: 'image-upload', orderable: false, searchable: false},
        {data: 'edit', name: 'edit', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],

      columnDefs: [
        {
          render: function (data, type, row) {
            if (row.material_image === '') {
              return 'No Image'
            }
            return '<img src= "{{url::asset('images/materials')}}/' + row.material_image + '" width="70px" height="50px">'

          },
          targets: 2
        },
        {
          render: function (data, type, row) {
            if (row.material_image === '') {
              console.log(row.material_image)
              return '<div><button class="btn btn-secondary" style="color: mediumpurple" onclick="uploadMaterialImage(' + row.material_id + ')">Add Image</button></div>'
            } else {
              return '<div><button class="btn btn-secondary" style="color: green" onclick="uploadMaterialImage(' + row.material_id + ')">Change Image</button></div>'
            }

          },
          targets: 5
        },
        {
          render: function (data, type, row) {
            return '<div><a href="#" class="btn btn-primary" onclick="editMaterial('+row.material_id+',\''+row.material_name+'\',\''+row.description+'\')">Edit </a></div>'

          },
          targets: 6
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.material_id + ')">Deactivate</button></div>'
          },
          targets: 7
        }
      ]
    })

    $('#new-material').on('click', function () {
      swal({
        title: 'Create New Material',
        html: '<input id="material_name" class="swal2-input" placeholder="Enter Material Name">' +
        '<textarea id="material_description" class="swal2-textarea" placeholder="Enter description"></textarea>',
        focusConfirm: false,
        showConfirmButton: true,
        showCancelButton: true
      }).then(function (result) {
//        console.log(result);
        if (result === true) {
          $.LoadingOverlay('show')
          console.log(result)
          var material_name = document.getElementById('material_name').value
          var material_description = document.getElementById('material_description').value
          console.log(material_description)

          var formData = new FormData()
          formData.append('name', material_name)
          formData.append('description', material_description)

          $.ajax({
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/create/material',
            processData: false,
            contentType: false,
            data: formData
          }).done(function (data) {
            $.LoadingOverlay('hide')
            if (data.message = 'success') {
              $('#materials-table').DataTable().ajax.reload()

              swal({
                title: 'Material Successfully Submitted !',
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

  function changeStatus (materialId) {
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
        var url = '/deactivate/material'
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            'material_id': materialId,
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
              $('#materials-table').DataTable().ajax.reload()
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
  function uploadMaterialImage (materialId) {
    swal({
      html: '<form id="add_image_form"><input type="file" name="material_image"></form>',
      title: 'Select image',
      showCancelButton: true,
      showConfirmButton: true,
    }).then(function (result) {
      var form = document.getElementById('add_image_form')
      var formData = new FormData(form)
      formData.append('material_id', materialId)
      $.LoadingOverlay('show')

      $.ajax({
        url: '/upload/material/image',
        data: formData,
        type: 'POST',
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (response) {
          $.LoadingOverlay('hide')
          if (response.status == 'success') {
            swal({
              type: 'success',
              title: 'Successfully Submitted',
              showConfirmButton: true
            })
            $('#materials-table').DataTable().ajax.reload()
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
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
          }
        },
        complete: function () {
          //Reload when complete
        }
      })    //END AJAX

    })
  }
  function editMaterial (materialId,materialName,description) {
    $('.swal2-input').val(materialName)
    $('#material_description').val(description)
    swal({
      title: 'Edit Material',
      html: '<input id="material_name" class="swal2-input" placeholder="Enter Material Name" value="'+materialName+'">' +
      '<textarea id="material_description" class="swal2-textarea" placeholder="Enter description" >'+description+'</textarea>',
      focusConfirm: false,
      showConfirmButton: true,
      showCancelButton: true
    }).then(function (result) {
//        console.log(result);
      if (result === true) {
        $.LoadingOverlay('show')
        console.log(result)
        var material_name =document.getElementById('material_name').value
        var material_description = document.getElementById('material_description').value
console.log(material_name)
        var formData = new FormData()
        formData.append('material_name', material_name)
        formData.append('description', material_description)
        formData.append('material_id', materialId)
        $.ajax({
          type: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/edit/material',
          processData: false,
          contentType: false,
          data: formData
        }).done(function (data) {
          $.LoadingOverlay('hide')
          if (data.message = 'success') {
            $('#materials-table').DataTable().ajax.reload()

            swal({
              title: 'Material Successfully Submitted !',
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
  }

</script>

@endpush
