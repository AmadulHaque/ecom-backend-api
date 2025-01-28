@extends('backend.app')
@section('style')
<style>


</style>
@endsection
@section('content')

<x-page-title title="Merchant Report Create" />


<div class="page-wrapper mt-3">

    <form id="saveButton" action="{{ route('admin.merchant-reports.store') }}" method="POST" class="needs-validation" novalidate="">
        @csrf
        <input type="hidden" name="merchant_id" value="{{ $id }}" hidden>
        <div class="row justify-content-center">
            <div class="col-8 mb-3 d-block">
                <h4 class="d-inline-block justify-content-center align-items-center">Report Details</h4>
                <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
            </div>
            <div class="col-8">
                <div class="form-group position-relative mb-3">
                    <textarea name="report_details" id="report_details" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
    </form>

</div>



@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

<script>
    
    $('#report_details').summernote({
        placeholder: 'Write Report...',
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
</script>
<script>
    $(document).on('submit', '#saveButton', async function(e) {
        e.preventDefault();
        let form = $(this);
        let actionUrl = form.attr('action');
        const result = await AllScript.submitFormAsync(form, actionUrl, 'POST');
        if (result) {
            window.location.href = "{{ route('admin.merchant.show', $id) }}";
        }
    })
    </script>
@endpush
