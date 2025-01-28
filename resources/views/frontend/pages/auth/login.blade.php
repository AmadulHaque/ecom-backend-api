@extends('frontend.app')
@section('content')
    <div class="main-content">
        <!-- login page -->
        <div class="auth-wrapper mt-5">
            <div class="content-area">
                <div class="favcon-icon d-flex align-items-center justify-content-center mb-3">
                    <img src="{{ asset('frontend/assets/images/brand/logo.svg') }}" alt="" class="w-auto h-auto">
                </div>
                <h5 class=" mb-4 text-center">Welcome Back</h5>

                <form action="" class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group position-relative mb-3">
                                <input type="text" name="phone_mail" class="form-control" value="" id="phn_num"
                                    placeholder="Mail or Phone no" required>
                                <div class="invalid-feedback">
                                    Please provide valid mail/phone no.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group position-relative mb-3">
                                <input name="password" type="password" class="form-control" id="pass"
                                    placeholder="Password" required>
                                <div class="invalid-feedback">
                                    Please provide phone no.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-sm mt-3 w-100">Submit</button>
                        </div>
                    </div>
                </form>

                <div class="text-end mt-3">
                    <a href="#" class="font-14">Forgot Password?</a>
                </div>

            </div>
        </div>
        <!-- login page -->
    </div>
@endsection
