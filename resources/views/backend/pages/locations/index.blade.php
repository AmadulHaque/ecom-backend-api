@extends('backend.app')
@section('content')

<x-page-title title="Locations" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between reasons-title">
        <div class="d-flex gap-3 reasons-status">
            @permission('location-create')
            <a href="{{ route('admin.locations.create') }}"
                class="btn btn-primary btn-sm justify-content-center d-flex align-items-center">Add new</a>
            @endpermission
            <div class="selectBar">
                <select name="location_id" id="location_id" class="form-control custom-select2" onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?location_id='+this.value)">
                    <option value="">-- select location --</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                        <optgroup label="{{ $division->name }}">
                            @foreach ($division->children as $district)
                            <option value="{{ $district->id }}">  --{{ $district->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="serchBar w-25">
            <input type="text" class="form-control" placeholder="Search ..." onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?search='+this.value)">
        </div>
    </div>


        <div class="table-wrapper">
            <div id="table" class="table">
                <x-location.table :entity="$locations" />
            </div>
        </div>    
    </div>

@endsection
@push('scripts')

@endpush