@extends('backend.app')
@section('content')

<x-page-title title="Category Edit" />

<form id="saveButton" action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="needs-validation add-custom-form" novalidate="">
    @csrf
    @method('PUT')
    
    <x-category.form :data="$category" />
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