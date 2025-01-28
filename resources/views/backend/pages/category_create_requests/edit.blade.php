@extends('backend.app')
@section('content')

<x-page-title title="Category Create Request view" />

<div class="page-wrapper mt-3">

    <form id="saveButton" action="{{ route('admin.category-create-requests.update', $category_request->id) }}" method="POST"
        class="needs-validation add-custom-form" novalidate="">
        @csrf
        @method('PUT')
        <x-category_requests.form :data="$category_request" />
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
        window.location.href = "{{ route('admin.category-create-requests.index') }}";
    }
})
</script>
@endpush