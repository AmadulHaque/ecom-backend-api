@extends('backend.app')
@section('content')

<x-page-title title="Prime Views List" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        @permission('prime-view-create')
        <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary btn-sm">Add new</button>
        @endpermission
        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search ..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>

    <div id="table">
        <x-prime-views.table :entity="$prime_views" />
    </div>

</div>
<x-prime-views.create />
<x-prime-views.edit />
@endsection

@push('scripts')

<script>
$(document).on('submit', '#saveButton', async function(e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr('action');
    let result = await AllScript.submitFormAsync(form, actionUrl, 'POST');
    if (result) {
        AllScript.loadPage('{{ Request::url() }}');
    }

    $('#createModal').modal('hide');
    $('#editModal').modal('hide');
    $("#saveButton")[0].reset()
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