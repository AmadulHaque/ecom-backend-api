@extends('backend.app')
@section('content')

<x-page-title title="Category Create" />

<form id="saveButton" action="{{ route('admin.categories.store') }}" method="POST" class="needs-validation add-custom-form" novalidate="">
    @csrf
    <x-category.form :data="null"  />
</form>

@endsection

@push('scripts')
<script>
$(document).on('submit', '#saveButton', async function(e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr('action');
    const result = await AllScript.submitFormAsync(form, actionUrl, 'POST');
    if (result) {
        window.location.href = "{{ route('admin.categories.index') }}";
    }
})
</script>
@endpush