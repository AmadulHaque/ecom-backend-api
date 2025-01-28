
<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                <div class="cell" data-width="150px" style="width: 150px">Merchant Name </div>

                <div class="cell" data-width="150px" style="width: 150px">Beneficiary</div>
                <div class="cell" data-width="100px" style="width: 100px">Type</div>
                <div class="cell" data-width="150px" style="width: 150px">Bank/Wallet</div>
                <div class="cell" data-width="150px" style="width: 150px">Account</div>

                <div class="cell" data-width="150px" style="width: 150"> Amount</div>
                <div class="cell" data-width="150px" style="width: 150"> Charge</div>
                <div class="cell" data-width="150px" style="width: 150px"> Status </div>
                <div class="cell" data-width="170px" style="width: 170px"> Date </div>
                <div class="cell" data-width="110px" style="width: 110px"> Action </div>
            </div>
        </div>
        <div  class="tbody">
            @php
                $sl = ($entity->currentPage() - 1) * $entity->perPage();
            @endphp
            @foreach ($entity as $key=>$item)
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration + $sl }} </div>
                <div class="cell" data-width="150px" style="width: 150px">
                     <a href="{{ route('admin.merchant.show', $item->merchant->id) }}" class="btn btn-link font-14">
                        {{ $item->merchant->name }}  
                    </a>
                </div>

                <div class="cell" data-width="150px" style="width: 150px">{{ $item->payoutBeneficiary->account_holder_name }}</div>
                <div class="cell" data-width="100px" style="width: 100px">{{ $item->payoutBeneficiary->beneficiaryTypes->name }}</div>
                <div class="cell" data-width="150px" style="width: 150px">{{  $item->payoutBeneficiary->bank->name ?? $item->payoutBeneficiary->mobileWallet->name }}</div>
                <div class="cell" data-width="150px" style="width: 150px">{{ $item->payoutBeneficiary->account_number ?? $item->payoutBeneficiary->account_number }}</div>

                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->amount }}</div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->charge }} %</div>
                <div class="cell" data-width="150px" style="width: 150px">
                    <span class="text-white alert {{ $item->status_label['bg_color'] }}  alert-sm">{{ $item->status_label['value'] }} </span>
                </div>
                <div class="cell" data-width="170px" style="width: 170px"> {{ $item->created_at->format('d/m/Y h:i A')  }}</div>
                <div class="cell" data-width="110px" style="width: 110px;">
                    <a href="{{ route('admin.payout-requests.show', $item->id) }}" class="btn btn-link font-14">View</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<x-pagination :paginator="$entity" />