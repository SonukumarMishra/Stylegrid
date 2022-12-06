
</body>
<!-- BEGIN: Vendor JS-->
<script src="{{asset('admin-section/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('admin-section/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="{{asset('admin-section/app-assets/js/core/app.js')}}" type="text/javascript"></script>
<!-- END: Theme JS-->
<script>
  var constants = {
      base_url:"{{URL::to('/')}}",
      current_url:"{{str_replace(URL::to('/'),'',URL::current())}}",
      csrf_token: '{{ csrf_token() }}',
  };
</script>
<script src="{{asset('admin-section/assets/js/common.js')}}" type="text/javascript"></script>

</html>