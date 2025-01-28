@extends('backend.app')
@section('content')

<x-page-title title="Edit Slider" />

<div class="page-wrapper mt-3">

    <form id="saveButton" action="{{ route('admin.sliders.update', $slider->id) }}" method="POST"
        class="needs-validation add-custom-form" novalidate="">
        @csrf
        @method('PUT')
        <x-slider.form :data="$slider" />
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
        window.location.href = "{{ route('admin.sliders.index') }}";
    }
})
</script>
@endpush