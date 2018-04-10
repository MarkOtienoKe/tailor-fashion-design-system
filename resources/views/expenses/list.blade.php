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
                @lang('expense.titles.all')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Expenses</a></li>
                <li class="active">Expenses Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <a class="btn btn-primary" id="new-expense">Create New Expenses</a>
                        <a class="btn btn-secondary pull-right" id="new_expense_category">Add Expense Category</a>
                    </div>
                </div>

                <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="expense-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Expense Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Expense Status</th>
                                    <th>Created At</th>
                                    <th>Edit</th>
                                    <th>Deactivate</th>

                                </tr>

                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Expense Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Expense Status</th>
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
        <!-- /.content -->
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('js/spin.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay_progress.min.js')}}"></script>


<script type="text/javascript">
  var expenseCategoriesData = {}
  $(document).ready(function () {
    $('#expense-table').DataTable({
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
      ajax: '/get/all/expenses/data',
      columns: [
        {data: 'expense_category', name: 'expense_category'},
        {data: 'description', name: 'description'},
        {data: 'amount', name: 'amount'},
        {data: 'expense_status', name: 'expense_status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'edit', name: 'edit', orderable: false, searchable: false},
        {data: 'deactivate', name: 'deactivate', orderable: false, searchable: false},
      ],

      columnDefs: [
        {
          render: function (data, type, row) {
            return '<div><a href="#" class="btn btn-primary" onclick="editExpense(' + row.expense_id + ',\'' + row.amount + '\',\'' + row.description + '\')">Edit </a></div>'

          },
          targets: 5
        },
        {
          render: function (data, type, row) {
            return '<div><button class="btn btn-danger" onclick="changeStatus(' + row.expense_id + ')">Deactivate</button></div>'
          },
          targets: 6
        }
      ]
    })

    $.ajax({
      type: 'GET',
      url: '/get/expense/categories',
      success: function (data) {
        $.map(data,
          function (o) {
            expenseCategoriesData[o.id] = o.name
          })

      }
    })
    $('#new-expense').on('click', function () {
      var expenseCategoryId = null
      swal({
        title: 'Create New Expense',
        html: '<form id="add_expense_form"><input id="expense_amount" class="swal2-input" placeholder="Enter Amount">' +
        '<textarea id="expense_description" class="swal2-textarea" placeholder="Enter description"></textarea> </form>',
        input: 'select',
        inputOptions: expenseCategoriesData,
        inputPlaceholder: 'Select Expense Category',
        inputClass: 'swal2-input',
        showConfirmButton: true,
        showCancelButton: true,
        inputValidator: function (value) {
          return new Promise(function (resolve, reject) {
            if (value != '') {
              expenseCategoryId = value
              resolve()
            } else {
              reject('You need to select expense category')
            }
          })
        }
      }).then(function (result) {
        if (result > 0) {
          $.LoadingOverlay('show')
          var expense_amount = document.getElementById('expense_amount').value
          var expense_description = document.getElementById('expense_description').value
          var formData = new FormData()
          formData.append('amount', expense_amount)
          formData.append('expense_category_id', expenseCategoryId)
          formData.append('description', expense_description)

          $.ajax({
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/create/expense',
            processData: false,
            contentType: false,
            data: formData
          }).done(function (data) {
            $.LoadingOverlay('hide')
            if (data.message = 'success') {
              $('#expense-table').DataTable().ajax.reload()

              swal({
                title: 'Expense Successfully Submitted !',
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

    $('#new_expense_category').on('click', function () {
      swal({
        title: 'Create Expense Category',
        html: '<input id="expense_category_name" class="swal2-input"  placeholder="Enter Category Name">' +
        '<textarea id="expense_category_description" class="swal2-textarea" placeholder="Enter description"></textarea>',
        focusConfirm: false,
        showConfirmButton: true,
        showCancelButton: true
      }).then(function (result) {
        if (result === true) {
          $.LoadingOverlay('show')
          var expense_category_name = document.getElementById('expense_category_name').value
          var expense_category_description = document.getElementById('expense_category_description').value

          var formData = new FormData()
          formData.append('name', expense_category_name)
          formData.append('description', expense_category_description)

          $.ajax({
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/create/expense/category',
            processData: false,
            contentType: false,
            data: formData
          }).done(function (data) {
            $.LoadingOverlay('hide')
            if (data.message = 'success') {
              swal({
                title: 'Successfully Submitted !',
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

  });
  (function () {
    $('#expense_category_id').append('<option>BMW</option>')
  })()
  function changeStatus (expenseId) {
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
        var url = '/deactivate/expense'
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            'expense_id': expenseId,
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
              $('#expense-table').DataTable().ajax.reload()
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

  function editExpense (expenseId, expenseAmount, description) {
    var expenseCategoryId = null

    swal({
      title: 'Edit Expense',
      html: '<input id="expense_amount" class="swal2-input" placeholder="Enter Amount" value="' + expenseAmount + '">' +
      '<textarea id="expense_description" class="swal2-textarea" placeholder="Enter description" >' + description + '</textarea>',
      input: 'select',
      inputOptions: expenseCategoriesData,
      inputPlaceholder: 'Select Expense Category',
      inputClass: 'swal2-input',
      showConfirmButton: true,
      showCancelButton: true,
      inputValidator: function (value) {
        return new Promise(function (resolve, reject) {
          if (value != '') {
            expenseCategoryId = value
            resolve()
          } else {
            reject('You need to select expense category')
          }
        })
      }
    }).then(function (result) {
      if (result > 0) {
        $.LoadingOverlay('show')
        var expense_amount = document.getElementById('expense_amount').value
        var expense_description = document.getElementById('expense_description').value
        var formData = new FormData()
        formData.append('amount', expense_amount)
        formData.append('description', expense_description)
        formData.append('expense_id', expenseId)
        formData.append('expense_category_id', expenseCategoryId)
        $.ajax({
          type: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/edit/expense',
          processData: false,
          contentType: false,
          data: formData
        }).done(function (data) {
          $.LoadingOverlay('hide')
          if (data.message = 'success') {
            $('#expense-table').DataTable().ajax.reload()

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
        }).error(function (jqXHR, textStatus, errorThrown) {
          $.LoadingOverlay('hide')
          $('#upload_location_limits_modal').modal('hide')

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
        })
      }
    })
  }

</script>

@endpush
