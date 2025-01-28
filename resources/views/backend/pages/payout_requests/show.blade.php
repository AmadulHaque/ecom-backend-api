@extends('backend.app')
@section('content')

<x-page-title title="Payout request Details" />

<div class="page-wrapper mt-3">
    <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
        <form class="d-block" action="{{ route('admin.payout-requests.status.update', $data->id) }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="d-flex align-items-center gap-3">
                <div class="selectBar">
       
                    <select name="status" id="Status"  class="custom-select2">
                        <option value="" selected>-- select status --</option>
                        <option @selected($data->status == '1') value="1">Pending</option>
                        <option @selected($data->status == '2') value="2">In Progress</option>
                        <option @selected($data->status == '3') value="3">Approved</option>
                        <option @selected($data->status == '4') value="4">Rejected</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-sm-6 row mt-3">
          <div class="col-6">
            <h6>BASIC INFORMATION</h6>
            <div class=" mt-2 d-flex flex-column gap-2">
              <p>Merchant Name      : {{ $data->merchant->name }}</p>
              <p>Type      : {{ $data->payoutBeneficiary->beneficiaryTypes->name }}</p>
              <p>Beneficiary      : {{ $data->payoutBeneficiary->account_holder_name }}</p>
              <p>Bank/Wallet      : {{  $data->payoutBeneficiary->bank->name ?? $data->payoutBeneficiary->mobileWallet->name }}</p>
              <p>Account      : {{  $data->payoutBeneficiary->account_number ?? $data->payoutBeneficiary->account_number  }}</p>
              <p> Amount  : <b>৳{{ $data->amount  }}</b></p>
              <p> Charge  : <b>{{ $data->charge  }}%</b></p>

              <p>Status : {{ $data->status_label['value'] }} </p>
              <p>Date   : {{ $data->created_at->format('d/m/Y h:i A') }} </p>
            </div>
          </div>


          <div class="col-6">
            <h6>PAYMENT INFORMATION</h6>
            <div class=" mt-2 d-flex flex-column gap-2">
              @if ($data->payoutBeneficiary->bank && $data->payoutBeneficiary->bank->name)
                <p>Bank: {{ $data->payoutBeneficiary->bank_name }} </p>
                <p>Account Holder Name   :  {{ $data->payoutBeneficiary->account_holder_name }}</p>
                <p>Account Number :  {{ $data->payoutBeneficiary->account_number }} </p>
                <p>Branch Name    :  {{ $data->payoutBeneficiary->branch_name }} </p>
                <p>Routing        :  {{ $data->payoutBeneficiary->routing_number }} </p>
              @else
              <p>Account Number :  {{ $data->payoutBeneficiary->account_number }} </p>
              @endif
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
