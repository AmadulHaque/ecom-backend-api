<script>
    (function($){
      $('.select2').select2();
  
        toastr.options = {
          "positionClass": "toast-top-center",
        }
  
        // session flash message
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @elseif (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
  
    })(jQuery);
  </script>