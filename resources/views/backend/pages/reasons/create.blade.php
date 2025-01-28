@extends('backend.app')
@section('content')

<x-page-title title="Add Reason" />

<div class="page-wrapper mt-3">

    <form id="saveButton" action="{{ route('admin.reasons.store') }}" method="POST"
        class="needs-validation add-custom-form" novalidate="">
        @csrf
        <x-reason.form />
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
        window.location.href = "{{ route('admin.reasons.index') }}";
    }
})
</script>
@endpush