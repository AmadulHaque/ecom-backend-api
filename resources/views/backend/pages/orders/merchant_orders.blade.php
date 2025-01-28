@extends('backend.app')

@section('content')
@use('App\Enums\OrderStatus', 'OrderStatus')
<x-page-title title="Merchant Orders" />
@php
$merchant_id = Request::get('merchant_id') ?? "";
@endphp
<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <div class="selectBar d-flex gap-3">
            <x-common.merchant-select/>
            <select name="status" class="form-control custom-select2" id="status"
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?status='+this.value)">
                <option  value="">-- select status -- </option>
                @foreach (OrderStatus::getStatusLabels() as $key=>$item)
                    <option value="{{ $key }}" >{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search ..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>

    <div  id="table">
        <x-orders.merchant_table :entity="$orders" />
    </div>


</div>
@endsection
