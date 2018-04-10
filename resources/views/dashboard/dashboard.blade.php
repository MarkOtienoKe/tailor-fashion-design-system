@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
{{--<link rel="stylesheet" href="{{ URL::asset('css/screen.css') }}">--}}
<style>
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
              Dashboard
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Dashboard</a></li>
                <li class="active">Dashboard Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                    <section class="content">
                                        <!-- Small boxes (Stat box) -->
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-6">
                                                <!-- small box -->
                                                <div class="small-box bg-aqua">
                                                    <div class="inner">
                                                        <h3>{{$neworders}}</h3>

                                                        <p>New Orders</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-bag"></i>
                                                    </div>
                                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-xs-6">
                                                <!-- small box -->
                                                <div class="small-box bg-aqua">
                                                    <div class="inner">
                                                        <h3>{{$completedOrders}}</h3>

                                                        <p>Completed Orders</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-shopping-cart"></i>
                                                    </div>
                                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                            <!-- ./col -->
                                            <div class="col-lg-3 col-xs-6">
                                                <!-- small box -->
                                                <div class="small-box bg-green">
                                                    <div class="inner">
                                                        <h3>{{$totalExpenses}}<sup style="font-size: 20px">%</sup></h3>

                                                        <p>Total Expenses</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-stats-bars"></i>
                                                    </div>
                                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-xs-6">
                                                <!-- small box -->
                                                <div class="small-box bg-green">
                                                    <div class="inner">
                                                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                                                        <p>Total Income</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-stats-bars"></i>
                                                    </div>
                                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-xs-6">
                                                <!-- small box -->
                                                <div class="small-box bg-green">
                                                    <div class="inner">
                                                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                                                        <p>Total Profit</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-stats-bars"></i>
                                                    </div>
                                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                            <!-- ./col -->
                                            <div class="col-lg-3 col-xs-6">
                                                <!-- small box -->
                                                <div class="small-box bg-yellow">
                                                    <div class="inner">
                                                        <h3>{{$numberOfNumbers}}</h3>

                                                        <p>Customers</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-person-add"></i>
                                                    </div>
                                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                            <!-- ./col -->
                                            <div class="col-lg-3 col-xs-6">
                                                <!-- small box -->
                                                <div class="small-box bg-red">
                                                    <div class="inner">
                                                        <h3>65</h3>

                                                        <p>Unique Visitors</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion ion-pie-graph"></i>
                                                    </div>
                                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                            <!-- ./col -->
                                        </div>

                                    </section>     <!-- /.row (main row) -->
                                <section>
                                    <div class="col-md-12">
                                        Monthly Income Gragh here
                                    </div>
                                </section>
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
{{--<script src="{{ asset('js/jquery.validate.min.js') }}"></script>--}}
<script src="{{ URL::asset('js/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
{{--<script src="{{URL::asset('bower_components/raphael/raphael.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bower_components/morris.js/morris.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
{{--<script src="{{URL::asset('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
{{--<script src="{{URL::asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
{{--<script src="{{URL::asset('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bower_components/moment/min/moment.min.js')}}"></script>--}}
<script src="{{URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {

  });


</script>

@endpush
