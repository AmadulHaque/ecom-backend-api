@extends('backend.app')
@section('style')
<style>


</style>
@endsection
@section('content')

<x-page-title title="Merchant Report Show" />


<div class="page-wrapper mt-3">


    <div class="row">
        <div class="col-12 mb-3">
            <span> Created on <b>{{ $report->created_at->format('d-m-Y') }}</b> </span>
            <span>| Updated on <b>{{ $report->updated_at->format('d-m-Y') }}</b> </span>
            <span>| Added By <b>{{ $report->addedBy->name }} </b></span>
            <span>| Status: <b>{{ $report->status }}</b></span>

        </div>
        <div class="col-8">
               {!! $report->report_details !!}
        </div>
    </div>
    
</div>



@endsection

