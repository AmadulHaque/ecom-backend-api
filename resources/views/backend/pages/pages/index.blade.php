@extends('backend.app')
@section('content')
    <x-page-title title="Page List" />

    <div class="page-wrapper mt-3">
        <div class="table-wrapper">
            <div class="table">
                <div class="thead">
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                        <div class="cell" data-width="250px" style="width: 250px"> Page Name </div>
                        <div class="cell" data-width="100px" style="width: 100px;">Action</div>
                    </div>
                </div>
                <div id="table" class="tbody">
                    <x-pages.table :entity="$pages" />
                </div>
            </div>
        </div>
    </div>
@endsection
