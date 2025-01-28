@extends('backend.app')
@section('content')

<x-page-title title="Coupon Type List" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary btn-sm">Add new</button>
    </div>

    <div class="table-wrapper">
        <div class="table">
            <div class="thead">
                <div class="row">
                    <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                    <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                    <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                </div>
            </div>
            <div id="table" class="tbody">
                <x-coupon-type.table :entity="$couponTypes" />
            </div>
        </div>
    </div>

</div>
<x-coupon-type.create />
<x-coupon-type.edit />
@endsection

@push('scripts')

<script>
$(document).on('submit', '#saveButton', async function(e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr('action');
    let result = await  AllScript.submitFormAsync(form, actionUrl, 'POST');
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