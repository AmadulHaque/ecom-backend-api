@php
    $favicon = '';

    $keyToValue = array_column($shop_settings, 'value', 'key');
    if (isset($keyToValue['site_favicon'])) {
        $favicon = $keyToValue['site_favicon'];
    }
@endphp
<!DOCTYPE html>
<html lang="en">
	
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <!-- set your title -->
   <title> Master admin panel</title>

   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- replace favicon path or source here -->
   <link rel="shortcut icon" href="{{ asset('storage/'.$favicon) }}" type="image/x-icon" />
   <!-- bootstrap and font-awesome cdn link -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
   <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
   <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!-- end bootstrap and font-awesome cdn link -->
   <link rel="stylesheet" href="{{ asset('backend') }}/plugin/css/mestimenu.css">
   <link rel="stylesheet" href="{{ asset('backend') }}/css/master.css">
   <link rel="stylesheet" href="{{ asset('backend') }}/css/style.css">
   <link rel="stylesheet" href="{{ asset('backend') }}/css/responsive.css">
   <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
   @yield('style')
</head>

<body class="mm-active" id="pjax-container">
   <div class="app">

      <div class="layout-wrapper">
         <div class="layout-left">
            @include('backend.layouts.sidebar')
         </div>
         <div class="layout-right">
            @include('backend.layouts.navbar')

            <div class="main-content">
               <div class="container-fluid">
                    @yield('content')
               </div>
            </div>
            <div class="footer p-3 mt-3">
               <div class="d-flex justify-content-center align-items-center">
                  <p class="font-14 fw-500">© 2016 - 2024 SteadFast. All rights reserved</p>
               </div>
            </div>
         </div>
      </div>

      <!-- bootstrap and jquery cdn link -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.5/simplebar.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
      <script   src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <!-- end bootstrap and jquery cdn link -->
      <!-- custom javascript -->
      <script src="{{ asset('backend') }}/plugin/js/sidebarmenu.js"></script>
      <script src="{{ asset('backend') }}/js/custom.js"></script>
      <script src="{{ asset('backend') }}/js/master.js"></script>
      <!-- custom javascript -->
      <script src="{{ asset('assets/js/scripts.js') }}" ></script>
      @include('backend.layouts.script')
      @stack('scripts')

</body>
</html>