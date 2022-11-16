

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script> -->
<script>
  var constants = {
    base_url:"{{URL::to('/')}}",
    current_url:"{{str_replace(URL::to('/'),'',URL::current())}}",
    csrf_token:'{{ csrf_token() }}',
  };
  
</script>
<script src="{{ asset('stylist/website/assets/js/tags.js') }}"></script>
<script src="{{ asset('stylist/website/assets/js/common.js') }}"></script>

</html>