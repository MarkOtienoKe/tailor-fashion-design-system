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
            <h1>Administration</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Administration</a></li>
                <li class="active">Administration Panel</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 class="page-header">{{ $title }}
                                        <small>Dashboard</small>
                                    </h1>
                                </div>
                                <!-- /.col-lg-12 -->
                            </div>
                            <!-- /.row -->
                            <div class="col-md-offset-1">
                                @foreach ( array_chunk($dashboard, 4) as $chunk )
                                    <div class="row text-center col-md-offset-1">
                                        @foreach ($chunk as $item)
                                            @include( config('admin.views.layouts.adminlinks'), [ 'item' => $item ] )
                                        @endforeach
                                    </div>
                                    <!-- /.row -->
                                @endforeach
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
