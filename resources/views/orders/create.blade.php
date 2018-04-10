@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/jquery-Ui.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/jquery.typeahead.min.css')}}">
<link rel="stylesheet" href="{{ URL::asset('css/flag-icon.min.css') }}">


<style>
    .content-header {
        color: purple;
    }
    .typeahead__container [type=search]{
        font-size: 14px;
    }
    .js div#preloader { position: fixed; left: 0; top: 0; z-index: 999; width: 100%; height: 100%; overflow: visible; background: #332 url('{{URL::asset('img/ajax-loader.gif')}}') no-repeat center center; }
</style>

@endpush
@section('content')

    <!-- Page heading ends -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('order.titles.create')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Orders</a></li>
                <li class="active">Create</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <div class="box-body">
                    <!-- /.box-header -->

                    <div class="col-md-offset-1">
                        <a href="/view/orders/list/new" class="btn btn-default">BACK</a>
                    </div>
                    <div class="js">
                        <div id="preloader"></div>

                    </div>
                    <div class="col-md-offset-2 col-md-8">
                        <form role="form" method="POST" action="" id="create_order_form">
                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="status" name="status" value="NEW">
                            <input type="hidden" id="customerId" name="customer_id" value="">
                            <div class="form-group ">
                                <label class="control-label">Material <span class="required_field">*</span></label>
                                <div>
                                    <select id="materialId" class="form-control input-lg"
                                            name="material_id"></select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="control-label">Clothe Type <span class="required_field">*</span></label>
                                <div>
                                    <select id="clotheTypeId" class="form-control input-lg"
                                            name="clothe_type_id"></select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="control-label">Customer Name <span class="required_field">*</span></label>
                                <div>
                                    <div class="typeahead__container">
                                        <div class="typeahead__field">

            <span class="typeahead__query">
                <input class="customer-search form-control input-lg" name="customer_name" type="search" placeholder="Search Customer" autocomplete="off">
            </span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Amount TO Pay <span required_field>*</span></label>
                                <div>
                                    <input type="text" class="form-control input-lg" name="amount_to_pay" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Order Received Date <span required_field>*</span></label>
                                <div>
                                    <input id="date_received" type="text" class="form-control input-lg"
                                           name="date_received">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date Of Collection <span required_field>*</span></label>
                                <div>
                                    <input id="date_of_collection" type="text" class="form-control input-lg"
                                           name="date_of_collection">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Description<span
                                            class="optional_field"> (optional)</span></label>
                                <div>
                                    <textarea type="text" class="form-control input-lg" name="description" value=""></textarea>
                                </div>
                            </div>
                            <div id="loader"></div>
                            <button class="btn btn-primary btn-lg" id="createOrder" type="submit" value="Submit">
                                Submit
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </section>
         </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery-Ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('js/typeahead/jquery.typeahead.min.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/loadingoverlay_progress.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $(window).load(function () {
      setTimeout(function(){
        $('.js').fadeOut('slow', function () {
        });
      },2000); // set the time here
    });
    $('#date_received,#date_of_collection').datepicker({dateFormat: 'yy-mm-dd'})

    $('#createOrder').on('click', function () {
      $('#create_order_form').validate({
        rules: {
          customer_name: {
            required: true,
          },
          amount_to_pay: {
            required: true,
            minlength: 1,
            maxlength: 255
          },
          date_received: {
            required: true,
          },
          date_of_collection: {
            required: true,
          },
        },
        messages: {
          customer_name: {
            required: 'Please Select Customer',
          },
          amount_to_pay: {
            required: 'Please enter amount',
            minlength: 'The amount must be 1 character long',
            maxlength: 'The amount  must be 255 characters long'
          },
          date_of_collection: {
            required: 'Please enter Date of collection',
          },
          date_received: {
            required: 'Please enter order receive date',
          }
        },
        submitHandler: function (form) {
          var request
          $('#loader').show()
          $.LoadingOverlay('show')


          if (request) {
            request.abort()
          }

          // setup some local variables
          var $form = $(this)

          // Let's select and cache all the fields
          var $inputs = $form.find('input, select, button, textarea')
          // Serialize the data in the form
          var serializedData = $('#create_order_form').serialize()

          // Disabled form elements will not be serialized.
          $inputs.prop('disabled', true)

          var url = '/create/order'

          // Fire off the request to /form.php
          request = $.ajax({
            url: url,
            type: 'post',
            data: serializedData,
          })

          // Callback handler that will be called on success
          request.done(function (response, textStatus, jqXHR) {
            console.log(response)
            if (response === null || response === undefined || response.length <= 0) {
              $.LoadingOverlay('hide')
              swal(
                'Sorry...',
                'Something went wrong, Try Again!',
                'error'
              ).catch(swal.noop)
            } else if (response['status_code'] === 200) {
              $.LoadingOverlay('hide')

              swal({
                title: 'Successfully Submitted!',
                text: 'Thank You!',
                type: 'success'
              }).then(function () {
                // Refresh table
                $('#create_order_form').trigger('reset')
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
    $.typeahead({
      input: '.customer-search',
      minLength: 0,
      maxItem: 15,
      order: "asc",
      hint: true,
      accent: true,
      searchOnFocus: true,
      backdrop: {
        "background-color": "#3879d9",
        "opacity": "0.1",
        "filter": "alpha(opacity=10)"
      },
      display: ["customer_name"],
      source: {
        users: {
          ajax: {
            url: '/data/customers',
            data: 'response'
          }
        }
      },
      emptyTemplate: "No result found",
      callback: {
        onEnter: function (node, query, result, resultCount, resultCountPerGroup) {
          $('#customerId').val(result.customer_id)
        },
      },
      debug: true,
    })


    $.ajax({
      type: 'GET',
      url: '/data/clothe/types',
      success: function (data) {

        if (!(data.length > 0)) {
          $('#clotheTypeId').append('<option value="">Nothing To Select</option>')
        } else {
          // Parse the returned json data
          var opts = (data)
          $('#clotheTypeId').append('<option value="">Choose Clothe Type</option>')
          // Use jQuery's each to iterate over the opts value
          $.each(opts, function (i, d) {
            // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
            $('#clotheTypeId').append('<option value="' + d.id + '">' + d.name + '</option>')
          })
        }

      }

    })
    $.ajax({
      type: 'GET',
      url: '/data/materials',
      success: function (data) {

        if (!(data.length > 0)) {
          $('#materialId').append('<option value="">Nothing To Select</option>')
        } else {
          // Parse the returned json data
          var opts = (data)
          $('#materialId').append('<option value="">Choose Material</option>')
          // Use jQuery's each to iterate over the opts value
          $.each(opts, function (i, d) {
            // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
            $('#materialId').append('<option value="' + d.material_id + '">' + d.material_name + '</option>')
          })
        }

      }

    })
  });


</script>

@endpush
