@extends('backend.app')
@section('content')

<x-page-title title="Reason List" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between reasons-title">
        <div class="d-flex gap-3 reasons-status">
            @permission('reason-create')
            <a href="{{ route('admin.reasons.create') }}"
                class="btn btn-primary btn-sm justify-content-center d-flex align-items-center">Add new</a>
            @endpermission

            <div class="selectBar">
                <select id="type" name="type" class="custom-select2"
                    onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?type='+this.value)">
                    <option value="">-- All --</option>
                    <option value="cancel">Cancel</option>
                    <option value="return">Return</option>
                    <option value="exchange">Exchange</option>
                    <option value="refund">Refund</option>
                </select>
            </div>
        </div>

        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search ..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">

        </div>
    </div>

    <!-- <div class="row mb-3">
        <div class="col-2">
            <a href="{{ route('admin.reasons.create') }}"
                class="btn btn-primary btn-sm justify-content-center d-flex align-items-center">Add new</a>
        </div>
        <div class="col-3">
            <div class="ml-3 d-block w-75 " style="margin-left: 10px">
                <select id="type" name="type" class="custom-select2 w-75"
                    onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?type='+this.value)">
                    <option value="cancel">Cancel</option>
                    <option value="return">Return</option>
                    <option value="exchange">Exchange</option>
                    <option value="refund">Refund</option>
                </select>
            </div>
        </div>
        <div class="col-4"></div>
        <div class="col-3">
            <input type="text" class="form-control" placeholder="Search ..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">

        </div>
    </div> -->

    <div class="table-wrapper">
        <div class="table">
            <div class="thead">
                <div class="row">
                    <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                    <div class="cell" data-width="150px" style="width: 150px"> Type </div>
                    <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                    <div class="cell" data-width="100px" style="width: 100px"> Status </div>
                    @permission(['reason-update', 'reason-delete'])
                        <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                    @endpermission
                </div>
            </div>
            <div id="table" class="tbody">
                <x-reason.table :entity="$reasons" />
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
        AllScript.loadPage('{{ Request::url() }}');
    }
});
</script>
@endpush