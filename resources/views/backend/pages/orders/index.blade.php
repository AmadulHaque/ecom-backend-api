@extends('backend.app')

@section('content')

<x-page-title title="Orders List" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <div class="selectBar d-flex gap-3">
            <select name="delivery_type" class="form-control custom-select2" id="delivery_type"
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?delivery_type='+this.value)">
                <option  value="">-- delivery type-- </option>
                <option value="1">Regular</option>
                <option value="2">Express</option>
            </select>
            <select name="ship_type" class="form-control custom-select2" id="ship_type"
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?ship_type='+this.value)">
                <option  value="">-- shipping type-- </option>
                <option value="OSD">OSD</option>
                <option value="ISD">ISD</option>
            </select>
        </div>
        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search ..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>

    <div  id="table" >
        <x-orders.table :entity="$orders" />
    </div>

</div>

@endsection