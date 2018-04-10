@extends('common.master')
@push('styles')
<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/custom-datatables.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-utilities.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/lc_lightbox.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/skins/minimal.css') }}">

<style>
    .elem, .elem * {
        box-sizing: border-box;
        margin: 0 !important;
    }
    .elem {
        display: inline-block;
        font-size: 0;
        width: 33%;
        border: 20px solid transparent;
        border-bottom: none;
        background: #fff;
        padding: 10px;
        height: auto;
        background-clip: padding-box;
    }
    .elem > span {
        display: block;
        cursor: pointer;
        height: 0;
        padding-bottom:	70%;
        background-size: cover;
        background-position: center center;
    }
    .lcl_fade_oc.lcl_pre_show #lcl_overlay,
    .lcl_fade_oc.lcl_pre_show #lcl_window,
    .lcl_fade_oc.lcl_is_closing #lcl_overlay,
    .lcl_fade_oc.lcl_is_closing #lcl_window {
        opacity: 0 !important;
    }
    .lcl_fade_oc.lcl_is_closing #lcl_overlay {
        -webkit-transition-delay: .15s !important;
        transition-delay: .15s !important;
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
                {{$pageData['title']}}
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
                        <a class="btn btn-primary" href="/view/materials">back</a>
                    </div>

                </div>

                <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="content">

                            @foreach($pageData['material_images'] as $image)
                                {{--<a class="elem" href="{{url::asset('images/materials')}}/{{$image['material_image']}}?dpr=1&auto=format&fit=crop&w=2000&q=80&cs=tinysrgb" title="{{$image['material_name']}}" data-lcl-thumb="{{url::asset('images/materials')}}/{{$image['material_image']}}?dpr=1&auto=format&fit=crop&w=150&q=80&cs=tinysrgb">--}}
                                    {{--<span style="background-image: url({{url::asset('images/materials')}}/{{$image['material_image']}}?dpr=1&auto=format&fit=crop&w=400&q=80&cs=tinysrgb);"></span>--}}

                                {{--</a>--}}

                                <a class="elem" href="{{url::asset('images/materials')}}/{{$image['material_image']}}?dpr=1&auto=format&fit=crop&w=2000&q=80&cs=tinysrgb" title="{{$image['material_name']}}" data-lcl-thumb="{{url::asset('images/materials')}}/{{$image['material_image']}}?dpr=1&auto=format&fit=crop&w=150&q=80&cs=tinysrgb">
                                    <span style="background-image: url({{url::asset('images/materials')}}/{{$image['material_image']}}?dpr=1&auto=format&fit=crop&w=400&q=80&cs=tinysrgb);"></span>
                                </a>
                            @endforeach
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
<script type="text/javascript" src="{{URL::asset('js/lc_lightbox.lite.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/alloy_finger.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(e) {

    // live handler
    lc_lightbox('.elem', {
      wrap_class: 'lcl_fade_oc',
      gallery : true,
      thumb_attr: 'data-lcl-thumb',

      skin: 'minimal',
      radius: 0,
      padding	: 0,
      border_w: 0,
    });

  });
</script>

@endpush
