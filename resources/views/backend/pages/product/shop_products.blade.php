@extends('backend.app')
@section('content')


<x-page-title title="Shop Product List" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <div class="selectBar d-flex gap-3">
            <x-common.merchant-select/>
        </div>
        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search product name..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>

    <div id="table"> <x-product.table :products="$products" /> </div>


</div>
@endsection
@push('scripts')

@endpush