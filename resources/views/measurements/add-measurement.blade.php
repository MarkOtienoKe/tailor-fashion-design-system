@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/jquery-Ui.min.css') }}">
<style>
    .content-header {
        color: purple;
    }
</style>

@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('measurement.titles.create')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Measurement</a></li>
                <li class="active">Add</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="">
                    <a href="/view/customer/measurements/{{$customerId}}" class="btn btn-link">Back</a>
                </div>
                <div class="box-body">
                    <!-- /.box-header -->


                    <div class="col-md-12">
                        <form role="form" method="POST" action="" id="add_measurement_form">
                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="status" name="status" value="ACTIVE">
                            <input type="hidden" id="customer_id" name="customer_id" value="{{$customerId}}">
                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Person <span required_field>*</span></label>
                                        <div>
                                            <input type="text" class="form-control" name="measurements_person_name"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Date <span required_field>*</span></label>
                                        <div>
                                            <input type="text" id="measurement_date" class="form-control"
                                                   name="measurement_date" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Description </label>
                                        <div>
                                            <textarea name="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Gender <span required_field>*</span></label>
                                        <div>
                                            <select name="sex" class="form-control">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Length</label>
                                        <div>
                                            <input type="text" class="form-control" name="length" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Waist</label>
                                        <div>
                                            <input type="text" class="form-control" name="waist" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Thigh </label>
                                        <div>
                                            <input type="text" class="form-control" name="thigh" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Bottom </label>
                                        <div>
                                            <input type="text" class="form-control" name="bottom" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Round </label>
                                        <div>
                                            <input type="text" class="form-control" name="round" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Fly </label>
                                        <div>
                                            <input type="text" class="form-control" name="fly" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Sleeves </label>
                                        <div>
                                            <input type="text" class="form-control" name="sleeves" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Round Sleeve </label>
                                        <div>
                                            <input type="text" class="form-control" name="round_sleeve" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Chest </label>
                                        <div>
                                            <input type="text" class="form-control" name="chest" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Tummy </label>
                                        <div>
                                            <input type="text" class="form-control" name="tummy" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Biceps </label>
                                        <div>
                                            <input type="text" class="form-control" name="biceps" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Shoulder </label>
                                        <div>
                                            <input type="text" class="form-control" name="shoulder" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Burst </label>
                                        <div>
                                            <input type="text" class="form-control" name="burst" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Hips </label>
                                        <div>
                                            <input type="text" class="form-control" name="hips" value="">
                                        </div>
                                    </div>
                                </div>
                                <div id="loader"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Bodies </label>
                                        <div>
                                            <input type="text" class="form-control" name="bodies" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-lg" id="createMeasurement" type="submit"
                                        value="Submit">
                                    Submit
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery-Ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('js/spin.min.js') }}"></script>


<script type="text/javascript">
  $(document).ready(function () {
    $('#measurement_date').datepicker({dateFormat: 'yy-mm-dd'})

    $('#createMeasurement').on('click', function () {
      $('#add_measurement_form').validate({
        rules: {
          measurements_person_name: {
            required: true,
            minlength: 2,
            maxlength: 255,
          },
          measurement_date: {
            required: true,
          },

        },
        messages: {
          measurements_person_name: {
            required: 'Please enter name',
            minlength: 'name must consist of at least 2 characters'
          },
          measurement_date: {
            required: 'Please enter Measurement Date',
          }
        },
        submitHandler: function (form) {
          var request
          $('#loader').show()
          var opts = {
            lines: 12 // The number of lines to draw
            , length: 6 // The length of each line
            , width: 5 // The line thickness
            , radius: 5 // The radius of the inner circle
            , scale: 1 // Scales overall size of the spinner
            , corners: 1 // Corner roundness (0..1)
            , color: 'blue' // #rgb or #rrggbb or array of colors
            , opacity: 0.25 // Opacity of the lines
            , rotate: 0 // The rotation offset
            , direction: 1 // 1: clockwise, -1: counterclockwise
            , speed: 1 // Rounds per second
            , trail: 60 // Afterglow percentage
            , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
            , zIndex: 2e9 // The z-index (defaults to 2000000000)
            , className: 'spinner' // The CSS class to assign to the spinner
            , top: '50%' // Top position relative to parent
            , left: '50%' // Left position relative to parent
            , shadow: false // Whether to render a shadow
            , hwaccel: false // Whether to use hardware acceleration
            , position: 'absolute' // Element positioning
          }
          var target = document.getElementById('loader')
          var spinner = new Spinner(opts).spin(target)

          if (request) {
            request.abort()
          }

          // setup some local variables
          var $form = $(this)

          // Let's select and cache all the fields
          var $inputs = $form.find('input, select, button, textarea')
          // Serialize the data in the form
          var serializedData = $('#add_measurement_form').serialize()

          // Disabled form elements will not be serialized.
          $inputs.prop('disabled', true)

          var url = '/save/measurement'

          // Fire off the request to /form.php
          request = $.ajax({
            url: url,
            type: 'post',
            data: serializedData,
          })

          // Callback handler that will be called on success
          request.done(function (response, textStatus, jqXHR) {
            if (response === null || response === undefined || response.length <= 0 || response['status_code']===500) {
              $('#loader').hide()
              swal(
                'Sorry...',
                'Something went wrong, Try Again!',
                'error'
              ).catch(swal.noop)
            } else if (response['status_code'] === 200) {
              $('#loader').hide()

              swal({
                title: 'Successfully Submitted!',
                text: 'Thank You!',
                type: 'success'
              }).then(function () {
                // Refresh table
                $('#add_measurement_form').trigger('reset')
                window.location='/view/customer/measurements/{{$customerId}}'
              }).catch(swal.noop)
            }
          })

          // Callback handler that will be called on failure
          request.fail(function (jqXHR, textStatus, errorThrown) {
            $('#loader').hide()
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
              $('#loader').hide()
            }
          })

          // Callback handler that will be called regardless
          // if the request failed or succeeded
          request.always(function () {
            //hide loader
            $('#loader').hide()

            // Reenable the inputs
            $inputs.prop('disabled', false)
          })

        }
      })
    })
    event.preventDefault()
  })


</script>

@endpush
