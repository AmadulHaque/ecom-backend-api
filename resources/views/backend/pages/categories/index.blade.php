@extends('backend.app')

@section('content')
    <x-page-title title="Category List" />

    <div class="page-wrapper mt-3">
        <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.categories.create') }}"
                    class="btn btn-primary btn-sm justify-content-center d-flex align-items-center">Add new</a>
                <button type="button" class="btn btn-secondary btn-sm justify-content-center d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#importExcelModal">Import Excel</button>
                <div class="selectBar">
                    <select name="type" id="type"
                        onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?type='+this.value)"
                        class="custom-select2">
                        <option selected value="1">Main Category</option>
                        <option value="2">Sub Category</option>
                        <option value="3">Child Category</option>
                    </select>
                </div>
            </div>
            <div class="serchBar w-25">
                <input type="text" class="form-control" placeholder="Search ..."
                    onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search=' + this.value + '&type=' + $('#type').val())" />
            </div>
        </div>
        <div id="table">
            <x-category.table :entity="$entity" />
        </div>
    </div>

    <div class="modal" id="importExcelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="font-18 mt-2">Import Excel (.xlsx)</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="saveButton" action="{{ route('admin.import.categories') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit"
                                class="btn btn-secondary btn-sm justify-content-center d-flex align-items-center">
                                <span class="spinner-border spinner-border-sm me-2 d-none" id="importSpinner" role="status"
                                    aria-hidden="true"></span>
                                Import
                            </button>
                            <a href="{{ asset('assets/categories.xlsx') }}" download
                                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                                <span class="spinner-border spinner-border-sm me-2 d-none" id="importSpinner" role="status"
                                    aria-hidden="true"></span>
                                Download Sample
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.deleteItem', async function() {
            const url = $(this).data('url');
            const result = await AllScript.deleteItem(url);
            if (result) {
                location.href = "{{ route('admin.categories.index') }}";
            }
        });

        $('#saveButton').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let submitButton = $(this).find('button[type="submit"]');
            let spinner = $('#importSpinner');

            submitButton.prop('disabled', true);
            spinner.removeClass('d-none');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    // Close the modal
                    $('#importExcelModal').modal('hide');

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Optionally refresh the page or table
                        location.reload();
                    });

                },
                error: function(xhr) {
                    let message = 'Something went wrong!';
                    console.log(xhr.responseJSON.error);
                    if (xhr.responseJSON.error) {
                        message = xhr.responseJSON.error;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: message
                    });
                },
                complete: function() {
                    submitButton.prop('disabled', false);
                    spinner.addClass('d-none');
                }
            });
        });
    </script>
@endpush
