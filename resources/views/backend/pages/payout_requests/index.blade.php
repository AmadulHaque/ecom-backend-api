@extends('backend.app')
@section('content')

<x-page-title title="Payout request list" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <div class="selectBar d-flex align-items-center gap-3">
            <x-common.merchant-select/>
                <select name="status" id="Status" onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?status='+this.value)" class="custom-select2">
                    <option value="" selected>-- select status --</option>
                    <option value="1">Pending</option>
                    <option value="2">In Progress</option>
                    <option value="3">Approved</option>
                    <option value="4">Rejected</option>
                </select>
        </div>
        <div class="serchBar w-25">
            <input type="date" class="form-control" placeholder="date ..." onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?date='+this.value)">
        </div>
    </div>
    <div id="table">  <x-payout_request.table :entity="$entity" /></div>
</div>
@endsection
