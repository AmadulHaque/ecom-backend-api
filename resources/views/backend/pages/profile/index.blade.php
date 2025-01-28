@extends('backend.app')
@section('content')
    <style>
        /* profile image  */
        .userProfile {
            width: 50%;
        }

        .image-upload-container {
            width: 104px;
            height: 104px;
            display: flex;
            flex-direction: column;
            margin-top: 1rem;
            /* mt-3 */
        }

        .thumbnail_image {
            position: relative;
        }

        .thumbnail_image .dragDrop-area {
            width: 100%;
            height: 104px;
            border: 1px dashed var(--bs-neutral-300);
            /* Example border */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail_image .image-preview-container {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
        }

        .thumbnail_image .image-preview-container .uplodedImg {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .thumbnail_image .image-preview-container .uplodedImg .image-preview {
            width: 100%;
            height: 100%;
            border-radius: 4px;
        }

        .dragDrop-area input[type="file"] {
            display: none;
        }

        .dragDrop-area label {
            width: 100%;
            height: 100%;
            font-size: 14px;
            /* font-14 */
            font-weight: 500;
            /* fw-500 */
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            /* gap-1 */
            align-items: center;
            justify-content: center;
        }

        .image-preview {
            margin-top: 0.25rem;
            /* mt-1 */
            border-radius: 4px;
        }

        .image-preview-container .close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            cursor: pointer;
        }

        .update-info {
            margin-top: 1rem;
            /* mt-4 */
        }

        .update-info .form-group {
            margin-bottom: 1rem;
            /* mb-3 */
            position: relative;
        }

        .update-info .form-label {
            font-weight: 500;
        }

        .update-info .form-control {
            width: 100%;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: 1px solid var(--bs-neutral-300);
            /* Example styling */
        }

        .btn-primary {
            background-color: var(--bs-primary-500);
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            width: 100%;
        }
    </style>
    <div class="page-title d-flex align-items-center justify-content-between">
        <div>
            <h5 class="fw-600">Profile</h5>
        </div>
    </div>
    <div class="page-wrapper mt-4">
        <form id="saveButton" action="{{ route('admin.profile.update') }}" class="profile-form" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="userProfile col-md-6 col-12">
                <div class="image-upload-container d-flex flex-column mt-3">
                    <div class="thumbnail_image position-relative">
                        <div class="dragDrop-area">
                            <input type="file" accept="image/*" name="avatar" class="form-control image-upload"
                                id="profileImage">
                            <label
                                class="w-100 h-100 font-14 fw-500 upload-label  d-flex flex-column gap-1 align-items-center justify-content-center"
                                for="profileImage">
                                <img src="{{ asset('assets/images/icon/img_upload.svg') }}" alt=""
                                    class="w-auto h-auto">
                        </div>
                        <div class="image-preview-container">
                            <div class="uplodedImg position-relative">
                                <img class="image-preview mt-1"
                                    src="{{ $user->avatar ?: asset('assets/images/no_mage.svg') }}" alt="Image Preview"
                                    style="width: 150px; height: 150px">
                                <img src="{{ asset('') }}assets/images/icon/close_icon_upload_img.svg" alt=""
                                    class="close-icon" style="width: 20px; height:20px; top: -15px; right: -15px">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="update-info mt-4">
                    <div class="form-group position-relative mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name"
                            placeholder="Type your name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group position-relative mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="number" name="phone" class="form-control" id="phone"
                            placeholder="Your phone number" value="{{ $user->phone }}">
                    </div>

                    <button type="submit" class="btn btn-md w-100 btn-primary mt-3">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        $(document).on('submit', '#saveButton', async function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');
            const result = await AllScript.submitFormAsync(form, actionUrl, 'POST');
            if (result) {
                window.location.href = "{{ route('admin.profile.index') }}";
            }
        })
    </script>
@endpush
