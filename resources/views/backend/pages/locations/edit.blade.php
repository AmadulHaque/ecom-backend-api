@extends('backend.app')
@section('content')

<x-page-title title="Edit Location" />

<div class="page-wrapper mt-3">

    <form id="saveButton" action="{{ route('admin.locations.update', $location->id) }}" method="POST"
        class="needs-validation add-custom-form" novalidate="">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-sm-12 mt-3">
                <label for="">Location </label>
                <select id="parent_id" name="parent_id" class="custom-select2">
                    <option value="" disabled selected>Select Division</option>
                    @foreach ($locations as $division)
                    <option @selected($location->parent_id == $division->id)
                        value="{{ $division->id }}"><b>{{ $division->name }}</b></option>
                    @foreach ($division->children as $district)
                    <option @selected($location->parent_id == $district->id)
                        value="{{ $district->id }}">--{{ $district->name }}</option>
                    @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-sm-12 mt-3">
                <label for="">Location Name *</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Location Name..." required=""
                    value="{{ $location->name }}">
            </div>

            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
$(document).on('submit', '#saveButton', async function(e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr('action');
    const result = await AllScript.submitFormAsync(form, actionUrl, 'POST');
    if (result) {
        window.location.href = "{{ route('admin.locations.index') }}";
    }
})
</script>
@endpush