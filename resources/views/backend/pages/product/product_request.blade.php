@extends('backend.app')
@section('content')


<x-page-title title="Product Request List" />

<div class="page-wrapper mt-3">

    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <div class="selectBar  d-flex gap-3">
            <x-common.merchant-select/>
            <select onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?status='+this.value)"
                class="custom-select2">
                <option value="">-- select status -- </option>
                @foreach ($shopStatuses as $key => $value)
                <option @selected(isset($_GET['status']) && ($_GET['status']==$key)) value="{{ $key }}">{{ $value }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search product name..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>
    <div id="table">
        <x-product.request_table :products="$products" />
    </div>

</div>

<div class="modal" id="requestModal" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="modalTitle" class="font-18 mt-2">Product Request</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saveButton" action="{{ route('admin.request.product.status') }}" method="POST"
                    class="needs-validation add-supplier-form" novalidate>
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id" value="">
                            <select id="status" name="status" class="custom-select2">
                                @foreach ($shopStatuses as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
<script>
let page = 1;
$(document).on('click', '.request_status', function() {
    const val = $(this).data('status');
    page = $(this).data('page');
    $('#id').val($(this).data('id'));
    $('#status').val(val).change();
})

$('#saveButton').on('submit', async function(e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr('action');
    let result = await  AllScript.submitFormAsync(form, actionUrl, 'POST');
    if (result) {
        $('#requestModal').modal('hide');
        AllScript.loadPage('{{ Request::url() }}?page=' + page);
    }

});
</script>
@endpush