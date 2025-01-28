@php
    $favicon = '';
    $logo = '';

    $keyToValue = array_column($shop_settings, 'value', 'key');
    if (isset($keyToValue['site_favicon'])) {
        $favicon = $keyToValue['site_favicon'];
    }
    if (isset($keyToValue['site_logo'])) {
        $logo = $keyToValue['site_logo'];
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">

   <!-- set your title -->
   <title> Master admin panel</title>

   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- replace favicon path or source here -->
   <link rel="shortcut icon" href="{{ asset('storage/'.$favicon) }}" type="image/x-icon" />


   <!-- bootstrap and font-awesome cdn link -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- end bootstrap and font-awesome cdn link -->
   <link rel="stylesheet" href="{{ asset('backend') }}/css/master.css">
   <link rel="stylesheet" href="{{ asset('backend') }}/css/style.css">
   <link rel="stylesheet" href="{{ asset('backend') }}/css/responsive.css">
   @yield('style')
</head>

<body class="mm-active">

    <div class="app-wrapper">
        <div class="main-content">
          <div class="auth-wrapper mt-5">
            <div class="content-area">
              <div class="favcon-icon d-flex align-items-center justify-content-center mb-3">
                <img src="{{  asset($logo ? 'storage/'. $logo : 'backend/images/brand/logo.png') }}" alt="" class="w-auto h-auto">
              </div>
              <h5 class=" mb-4 text-center">Welcome Back</h5>
              <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="row">
                    @error('error_message')
                    <div class="invalid-feedback d-block">{{ $message  }}</div>
                    @enderror
                  <div class="col-sm-12">
                    <div class="form-group position-relative mb-3">
                      <input type="text" name="phone_mail" class="form-control" value="" id="phn_num" placeholder="Mail or Phone no">
                      @error('phone_mail')
                      <div class="invalid-feedback d-block">{{ $message  }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group position-relative mb-3">
                      <input name="password" type="password" class="form-control" id="pass" placeholder="Password">
                      @error('password')
                      <div class="invalid-feedback d-block">{{ $message  }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-sm mt-3 w-100">Login</button>
                  </div>
                </div>
              </form>
              <div class="text-end mt-3">
                <a href="#" class="font-14">Forgot Password?</a>
              </div>
            </div>
          </div>
        </div>
        <div class="footer p-3 mt-3">
            <div class="d-flex justify-content-center align-items-center">
               <p class="font-14 fw-500">© 2016 - 2024 SteadFast. All rights reserved</p>
            </div>
        </div>
    </div>

    <!-- bootstrap and jquery cdn link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
         const Toast = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
       
        function notifaction(message="test",type='success'){
            Toast.fire({
                icon: type,
                title: message
            });
        }
        
        (function($){
            // session flash message
            @if (Session::has('success'))
                notifaction("{{ Session::get('success') }}");
            @elseif (Session::has('error'))
                notifaction("{{ Session::get('error') }}", 'error');
            @elseif (Session::has('info'))
                notifaction("{{ Session::get('info') }}", 'info');
            @elseif (Session::has('warning'))
                notifaction("{{ Session::get('warning') }}", 'warning');
            @endif
        })(jQuery);
    </script>
</body>
</html>