@extends('backend.app')

@section('content')
<x-page-title title="Settings" />


{{-- settingsGroups --}}
<div class="page-wrapper mt-3 d-flex justify-content-between align-items-center">
    <div class="status-tab mt-3">
        <div class="tab-menus">
            <ul class="tab-menus-items d-flex gap-3">
                @foreach ($settingsGroups as $groupName => $settings)
                <li class="tab-item">
                    <button
                        class="groupPage btn btn-sm {{ $loop->first ? 'btn-primary' : 'btn-secondary'}}">{{ $groupName }}</button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


<div class="page-wrapper mt-3">

    <form id="saveButton" action="{{ route('admin.settings.update') }}" method="POST"
        class="needs-validation add-supplier-form" enctype="multipart/form-data">
        @csrf
        <div id="form" class="settingForm">
        </div>
    </form>
</div>


@endsection
@push('scripts')
<script>
let page = '';
$(document).ready(function() {

    const firstTab = $('.groupPage').first();
    if (firstTab.length) {
        page = firstTab.text();
        firstTab.addClass('btn-primary').removeClass('btn-secondary');
        AllScript.loadPage('{{ Request::url() }}?group=' + page, 'form');
    }

    $('.groupPage').click(function() {
        page = $(this).text();
        $('.groupPage').removeClass('btn-primary').addClass('btn-secondary')
        $(this).addClass('btn-primary').removeClass('btn-secondary')
        AllScript.loadPage('{{ Request::url() }}?group=' + page, 'form');
    })
    $(document).on('submit', '#saveButton', async function(e) {
        e.preventDefault();
        let form = $(this);
        let actionUrl = form.attr('action');
        const result = await AllScript.submitFormAsync(form, actionUrl, 'POST');
        if (result) {
            AllScript.loadPage('{{ Request::url() }}?group=' + page, 'form');
        }
    })
})
</script>
@endpush