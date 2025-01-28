@extends('backend.app')
@section('content')
@use('App\Enums\MerchantStatus', 'MerchantStatus')
<x-page-title title="Merchant List" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <div class="selectBar">
            <select name="shop_status" class="form-control custom-select2" id="shop_status"
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?shop_status='+this.value)">
                <option  value="">All</option>
                @foreach(MerchantStatus::toArray() as $key => $value)
                <option  value="{{ $value }}">{{ $key }} </option>
                @endforeach
            </select>
        </div>
        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search merchant..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>

    <div id="table" class="table-wrapper">
        <x-merchant.table :entity="$merchants" />
    </div>


</div>

@endsection