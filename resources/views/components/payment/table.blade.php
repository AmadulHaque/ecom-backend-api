@php
    $sl = ($entity->currentPage() - 1) * $entity->perPage();
@endphp

<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                <div class="cell" data-width="150px" style="width: 150px"> Shop</div>
                <div class="cell" data-width="150px" style="width: 150px"> TrackingID</div>
                <div class="cell" data-width="130px" style="width: 130px"> Total Amount</div>
                <div class="cell" data-width="130px" style="width: 130px"> Payment Method</div>
                <div class="cell" data-width="130px" style="width: 130px"> Payment Ref</div>
                <div class="cell" data-width="100px" style="width: 100px"> TransID </div>
                @permission('order-payment-update')
                    <div class="cell" data-width="170px" style="width: 170px"> Status </div>
                @endpermission
                @permission('order-payment-show')
                    <div class="cell" data-width="100px" style="width: 100px;"> Action</div>
                @endpermission
            </div>
        </div>
        <div class="tbody">
            @foreach ($entity as $item)
                <div class="row">
                    <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration + $sl }}  </div>
                    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->merchant->name }}</div>
                    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->order->tracking_id }} </div>
                    <div class="cell" data-width="130px" style="width: 130px"> {{ $item->amount }}</div>
                    <div class="cell" data-width="130px" style="width: 130px">{{ $item->payment_method }}</div>
                    <div class="cell" data-width="130px" style="width: 130px"> {{ $item->payment_ref }}</div>
                    <div class="cell" data-width="100px" style="width: 100px"> {{ $item->tran_id }} </div>
                    @permission('order-payment-update')
                        <div class="cell" data-width="170px" style="width: 170px"> 
                            {{-- @if ($item->status_label=='Approved')
                                <span class="text-white alert alert-success alert-sm ">Approved</span>
                            @elseif ($item->status_label=='Cancelled')
                                <span class="text-white alert alert-danger alert-sm ">Cancelled</span>
                            @else --}}
                            <form action="{{ route('admin.payments.status.change', $item->id) }}" class="d-block" style="width: 100%"  method="post">
                                @csrf
                                @method('PUT')
                                <select class="from-control custom-select2" name="status" onChange="this.form.submit()" >
                                    @if ($item->payment_method == 'COD')
                                        <option @selected($item->status_label == 'Pending') value="1">Pending</option>
                                        <option @selected($item->status_label == 'Approved') value="3">Approved</option>
                                        <option @selected($item->status_label == 'Cancelled') value="4">Cancelled</option>
                                    @else
                                        <option @selected($item->status_label == 'Pending') value="1">Pending</option>
                                        <option @selected($item->status_label == 'Success') value="2">Success</option>
                                        <option @selected($item->status_label == 'Approved') value="3">Approved</option>
                                        <option @selected($item->status_label == 'Cancelled') value="4">Cancelled</option>
                                        <option @selected($item->status_label == 'Failed') value="5">Failed</option>
                                    @endif
                                    
                                </select>
                            </form>
                            {{-- @endif --}}
                        </div>
                    @endpermission
                    @permission('order-payment-show')
                        <div class="cell" data-width="100px" style="width: 100px;">
                            <a href="{{ route('admin.payments.show', $item->tran_id) }}" class="btn btn-link font-14">View</a>
                        </div>
                    @endpermission
                </div>
            @endforeach
        </div>
    </div>
</div>

<x-pagination :paginator="$entity" />
<script>
    $(document).ready(function() {
        $(".custom-select2").select2({
            theme: "bootstrap-5",
        });
        $(".custom-select2").on("select2:open", function (e) {
            $(".select2-search__field").get(0).focus();
        });
    });
</script>