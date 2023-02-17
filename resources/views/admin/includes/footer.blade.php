
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<!-- BEGIN: Vendor JS-->
<script src="{{asset('admin-section/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('admin-section/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="{{asset('admin-section/app-assets/js/core/app.js')}}" type="text/javascript"></script>
<script src="{{ asset('extensions/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('extensions/toastr/js/toastr.js') }}"></script>
<script src="{{ asset('extensions/sweetalert/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('extensions/moment/js/moment.min.js') }}"></script>
<script src="{{ asset('extensions/fontawesome/js/all.min.js') }}"></script>

<!-- END: Theme JS-->
<script>
  var constants = {
      base_url:"{{URL::to('/')}}",
      current_url:"{{str_replace(URL::to('/'),'',URL::current())}}",
      csrf_token: '{{ csrf_token() }}',
  };
</script>
<script src="{{asset('admin-section/assets/js/common.js')}}" type="text/javascript"></script>
@include('scripts.common_scripts')

@yield('page-scripts')

</html>