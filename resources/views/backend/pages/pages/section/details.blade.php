@extends('backend.app')
@section('content')
    <style>
        .card {
            border: 1px solid var(--bs-neutral-200);
        }

        .card-header {
            background-color: var(--bs-white);
        }

        .card-header h5 {
            color: var(--bs-neutral-500);
        }
    </style>
    <x-page-title title="{{ $pageSection->name }} Details" />

    <div class="page-wrapper mt-3">
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('admin.pages.show', $pageSection->page->slug) }}"
                    class="btn btn-primary btn-sm d-flex align-items-center gap-2 float-end">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
        <form id="saveButton" action="{{ route('admin.pages.section.update', $pageSection->slug) }}" method="POST"
            class="needs-validation add-supplier-form" novalidate="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        @foreach ($pageSectionDelails as $key => $pageSectionDelail)
                        @if (is_array(json_decode($pageSectionDelail->value)))
                                @foreach (json_decode($pageSectionDelail->value) as $keyDetails => $details)
                                    <div class="col-sm-6">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                {{ __('Service') }}<span class="text-primary">#{{ $keyDetails + 1 }}</span>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($details as $title => $value)
                                                <div class="col-sm-12 mt-3">
                                                        <div class="form-group">
                                                            <label for="{{ $title }}"
                                                                class="form-label">{{ ucfirst($title) }}</label>
                                                                <input type="{{ $title == 'image' ? 'file' : 'text' }}"
                                                                name="services[{{ $keyDetails }}][{{ $title }}]"
                                                                class="form-control" value="{{ $value }}"
                                                                id="{{ $title }}"
                                                                placeholder="{{ ucfirst($title) }} ...">
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                @endforeach
                            @else
                            @php
                                $isImage = strpos($pageSectionDelail->name, 'image') !== false;
                                @endphp
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="col-sm-12 mt-3">
                                            <div class="form-group">
                                                <label for="{{ $pageSectionDelail->name }}"
                                                    class="form-label">{{ ucfirst(str_replace('_', ' ', $pageSectionDelail->name)) }}</label>
                                                <input type="{{ $isImage ? 'file' : 'text' }}" name="{{ $pageSectionDelail->name }}"
                                                    class="form-control" value="{{ $pageSectionDelail->value }}"
                                                    id="{{ $pageSectionDelail->name }}"
                                                    placeholder="{{ ucfirst(str_replace('_', ' ', $pageSectionDelail->name)) }} ...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-sm-12 text-end">
                        <button type="submit" class="btn btn-primary btn-sm mt-3">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
@endpush
