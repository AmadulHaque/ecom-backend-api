@extends('backend.app')
@section('content')
    <x-page-title title="Slider List" />

    <div class="page-wrapper mt-3">
        <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
            @permission('slider-create')
                <a href="{{ route('admin.sliders.create') }}"
                    class="btn btn-primary btn-sm justify-content-center d-flex align-items-center">Add new</a>
            @endpermission
            <div class="serchBar w-25">
                <input type="text" class="form-control" placeholder="Search ..."
                    onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
            </div>
        </div>


        <div class="table-wrapper">
            <div class="table">
                <div class="thead">
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Title </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Type </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Sub Title</div>
                        <div class="cell" data-width="130px" style="width: 130px"> Desktop Image</div>
                        <div class="cell" data-width="130px" style="width: 130px"> Mobile Image</div>
                        <div class="cell" data-width="100px" style="width: 100px"> Status </div>
                        @permission(['slider-update', 'slider-delete'])
                        <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                        @endpermission
                    </div>
                </div>
                <div id="table" class="tbody">
                    <x-slider.table :entity="$sliders" />
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('submit', '#saveButton', function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');
            AllScript.submitForm(form, actionUrl, 'POST');
            AllScript.loadPage('{{ Request::url() }}');
            $('#createModal').modal('hide');
            $('#editModal').modal('hide');
        })
        $(document).on('click', '.editItem', function() {
            const url = $(this).data('url');
            AllScript.loadFormPage(url, 'editForm')
        })
        $(document).on('click', '.deleteItem', async function() {
            const url = $(this).data('url');
            const result = await AllScript.deleteItem(url);
            if (result) {
                AllScript.loadPage('{{ Request::url() }}');
            }
        });
    </script>
@endpush
