@extends('backend.app')
@section('content')
    <x-page-title title="Page List" />

    <div class="page-wrapper mt-3">
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('admin.pages.index') }}"
                    class="btn btn-primary btn-sm d-flex align-items-center gap-2 float-end">
                    <i class="fa-solid fa-arrow-left"></i>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
        <div class="table-wrapper">
            <div class="table">
                <div class="thead">
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                        <div class="cell" data-width="250px" style="width: 250px"> Section Name </div>
                        <div class="cell" data-width="100px" style="width: 100px;">Action</div>
                    </div>
                </div>
                <div id="table" class="tbody">
                    <x-pages.section.table :entity="$pageSections" />
                </div>
            </div>
        </div>
    </div>
@endsection
