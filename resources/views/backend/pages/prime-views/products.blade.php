@extends('backend.app')
@section('content')

<x-page-title title="Prime View Products" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <div class=" d-flex gap-3">
            @permission('prime-view-product-create')
            <a href="{{ route('admin.prime-view-products.create') }}"
                class="btn btn-primary btn-sm justify-content-center d-flex align-items-center" style="width: 180px">Add new</a>
            @endpermission
            <select id="prime_view_id" name="prime_view_id" class="custom-select2" onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?prime_view_id='+this.value)">
                <option value="">-- prime view --</option>
                @foreach ($prime_views as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
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
                    <div class="cell" data-width="150px" style="width: 150px"> PrimeView </div>
                    <div class="cell" data-width="80px" style="width: 80px"> Image </div>
                    <div class="cell" data-width="220px" style="width: 220px"> Name </div>
                    <div class="cell" data-width="90px" style="width: 90px"> SKU </div>
                    <div class="cell" data-width="150px" style="width: 150px"> Category </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Regular price </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Discount price </div>
                    <div class="cell" data-width="70px" style="width: 70px"> Stock </div>
                    @permission('prime-view-product-delete')
                        <div class="cell" data-width="100px" style="width: 100px;">Action</div>
                    @endpermission
                </div>
            </div>
            <div id="table" class="tbody">
                <x-prime-views.product_table :entity="$products" />
            </div>
        </div>
    </div>
    <x-pagination :paginator="$products" />


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