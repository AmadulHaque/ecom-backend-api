@extends('backend.app')
@section('content')
    <div class="page-content ">
        <div class="page-title">
            <div>
                <h5 class="fw-600">Update Password</h5>
            </div>
        </div>
        <div class="page-wrapper mt-3">
            <div class="admin-form w-25">
                <form id="updatePassword" action="{{ route('admin.profile.password.update') }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group position-relative mb-3">
                                <label for="pass" class="form-label">Current Password</label>
                                <input name="old_password" value="{{ old('old_password') }}" onkeyup="removeSpaces(this)"
                                    type="password" class="form-control pass-field" id="pass" required
                                    placeholder="Current Password">
                                
                                <div class="invalid-feedback">Please provide your new password.</div>
                            </div>
                            @error('old_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group position-relative mb-3">
                                <label for="pass" class="form-label">New Password</label>
                                <input name="password" value="{{ old('password') }}" onkeyup="removeSpaces(this)"
                                    type="password" class="form-control pass-field" id="pass" required
                                    placeholder="New Password">
                                
                                <div class="invalid-feedback">Please provide your new password.</div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group position-relative mb-3">
                                <label for="confirmpass" class="form-label">Confirm Password</label>
                                <input name="password_confirmation" type="password" onkeyup="removeSpaces(this)"
                                    value="{{ old('password_confirmation') }}" class="form-control pass-field"
                                    id="confirmpass" placeholder="Confirm Password" required>
                               
                                <div class="invalid-feedback">Please confirm your new password.</div>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-25 mt-4">Save</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function removeSpaces(input) {
            input.value = input.value.replace(/\s/g, '');
        }
    </script>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#updatePassword').submit(function(event) {
                event.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.type == "warning") {
                            toastr.warning(response.data, response.message);
                        } else if (response.type == "success") {
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = response.redirectUrl;
                            }, 1000);
                        } else {
                            toastr.error(response.message);
                            // console.log(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        let response = xhr.responseJSON;
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                toastr.error(value);
                            });
                        }
                    }
                });
            });
        })
    </script>
@endpush