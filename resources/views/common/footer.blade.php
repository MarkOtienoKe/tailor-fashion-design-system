<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b><a href="">@lang('common.system-version')</a></b>
    </div>
    <strong> <a href=""><span>@</span><span>@lang('common.copy-right.year')</span><span>@lang('common.copy-right.rights')</span></a></strong>
</footer>
<!-- jQuery 2.2.3 -->
<script src="{{URL::asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('js/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>

<script src="{{ URL::asset('vendor/datatables/buttons.server-side.js') }}"></script>
<!-- SlimScroll -->
{{--<script src="{{URL::asset(' plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>--}}
<!-- FastClick -->
<script src="{{URL::asset('plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{URL::asset('dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{URL::asset('dist/js/demo.js')}}"></script>
@stack('scripts')
