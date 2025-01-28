@extends('backend.app')
@section('content')

<x-page-title title="Payment List" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between">
        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search ..."
                onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>

    <div id="table"  >
        <x-payment.table :entity="$payments" />
    </div>
</div>

@endsection
