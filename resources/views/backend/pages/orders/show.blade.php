@extends('backend.app')
@section('content')

<style>
.common_dashboard {
    background: var(--bs-white);
    border: 1px solid var(--bs-neutral-200);
    box-shadow: var(--box-shadow-10);
    padding: 32px 32px 80px 32px;
    min-height: 840px;
}

.order_details .pg-head {
    padding: 16px;
    border-bottom: 1px solid var(--bs-neutral-200);
}
</style>
<x-page-title title="Orders Details ( #{{ $order->invoice_id }} )" />

<div class="page-wrapper mt-3 d-flex justify-content-between  order_details">
    <div class="order-id">
        <span class="d-flex gap-1">Order Id : <p class="txt-primary"> #{{ $order->invoice_id }} </p>
        </span>
        <small>Placed on : {{ $order->created_at }}</small>
    </div>
    @php
    $status = $_GET['status_id'] ?? '';
    @endphp
    <div class="status-tab mt-3">
        <div class="tab-menus">
            <ul class="tab-menus-items d-flex gap-3">
                <li class="tab-item">
                    <button onClick="location.href='{{ Request::url() }}'"
                        class="  btn btn-sm  {{$status == "" ? 'btn-primary' : 'btn-secondary' }}">All</button>
                </li>
                <li class="tab-item">
                    <button onClick="location.href='{{ Request::url() }}?status_id=1'"
                        class="  btn btn-sm  {{$status == "1" ? 'btn-primary' : 'btn-secondary' }}">Pending</button>
                </li>
                <li class="tab-item">
                    <button onClick="location.href='{{ Request::url() }}?status_id=2'"
                        class=" btn btn-sm  {{$status == "2" ? 'btn-primary' : 'btn-secondary' }}">Processing</button>
                </li>
                <li class="tab-item">
                    <button onClick="location.href='{{ Request::url() }}?status_id=3'"
                        class=" btn btn-sm  {{$status == "3" ? 'btn-primary' : 'btn-secondary' }}">Delivered</button>
                </li>
                <li class="tab-item">
                    <button onClick="location.href='{{ Request::url() }}?status_id=4'"
                        class=" btn btn-sm  {{$status == "4" ? 'btn-primary' : 'btn-secondary' }}">Cancelled</button>
                </li>
            </ul>
        </div>
    </div>
</div>



<div class="storeContainer d-flex flex-column gap-2">
    @php
    $merchantOrders = $order->merchantOrders()->when($status, function ($query, $status) {
    return $query->where('status_id', $status);
    })->get();
    @endphp
    @foreach ($merchantOrders as $key=>$merchantOrder)
    <div class="storeOrder ">
        <div class="page-wrapper mt-3">
            <div class="page-title mb-3 d-flex justify-content-between  cursor-pointer" data-bs-toggle="collapse"
                data-bs-target="#store_id_{{ $key }}" aria-expanded="true" aria-controls="store_id_{{ $key }}">
                <div class="store-name d-flex gap-2 ">
                    <div class="d-flex gap-2 align-items-center">
                        <img src="{{ asset('backend') }}/images/icon/store_icon.svg" alt="" class="w-auto h-auto">
                        <h6>{{ $merchantOrder->merchant->shop_name }}</h6>
                    </div>
                    <div class="d-flex gap-2 align-items-center tracking-id">
                        <span><i class="fa-solid fa-chevron-right"></i>
                            <b>Tracking Id : </b></span><span>#{{ $merchantOrder->tracking_id  }}</span>
                    </div>
                </div>
                <div class="alert {{ $merchantOrder->status_bg_color }} alert-sm" role="alert">
                    {{ $merchantOrder->status_label }}
                </div>
            </div>
            <div class="collapse show" id="store_id_{{ $key }}">
                <div class="orders-summary d-flex">
                    <div class="table-wrapper ">
                        <div class="table">
                            <div class="thead">
                                <div class="row">
                                    <div class="cell" data-width="44px" style="width: 44px;">
                                        Id
                                    </div>
                                    <div class="cell" data-width="64px" style="width: 64px;">
                                        Image
                                    </div>
                                    <div class="cell" data-width="280px" style="width: 210px;">
                                        Name
                                    </div>
                                    <div class="cell" data-width="80px" style="width: 80px;">
                                        Price
                                    </div>
                                    <div class="cell" data-width="80px" style="width: 80px;">
                                        QTY
                                    </div>
                                    <div class="cell" data-width="110px" style="width: 110px;">
                                        Status
                                    </div>
                                </div>
                            </div>
                            <div class="tbody">
                                @foreach ($merchantOrder->orderItems as $item)
                                <div class="row">
                                    <div class="cell" data-width="44px" style="width: 44px;">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="cell" data-width="64px" style="width: 64px;">
                                        <img src="{{$item->product->thumbnail}}" alt="">
                                    </div>
                                    <div class="cell" data-width="280px" style="width: 210px;">
                                        <div class="d-flex flex-column gap-1">
                                            <h6>{{$item->product->name}}</h6>
                                            @if ($item->product->is_variant=='1')
                                            <p>
                                                @foreach ($item->product_variant->variationAttributes as $variation)
                                                <span>{{ $variation->attribute->name }}:
                                                    {{ $variation->attributeOption->attribute_value  }}</span>
                                                @endforeach
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="cell" data-width="80px" style="width: 80px;">
                                        {{$item->price}}
                                    </div>
                                    <div class="cell" data-width="80px" style="width: 80px;">
                                        {{$item->quantity}}
                                    </div>
                                    <div class="cell" data-width="110px" style="width: 110px;">
                                        <div class="alert  {{ $item->status_bg_color }} alert-sm" role="alert">
                                            {{ $item->status_label }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                    <div class="summary">
                        <h6 class="text-center">Order Summary</h6>
                        <ul class="list-group mt-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <p>Sub Total ({{ $merchantOrder->orderItems->count() }} Items)</p>
                                <p class="txt-black">৳ {{ $merchantOrder->sub_total }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <p>Discount</p>
                                <p class="txt-black">৳ {{ $merchantOrder->discount_amount }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <p>Shipping Fee</p>
                                <p class="txt-black">৳ {{ $merchantOrder->shipping_amount }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <p>Charge</p>
                                <p class="txt-black">৳ {{ $merchantOrder->charge }}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <p class="txt-black font-16 fw-500">Total</p>
                                <p class="txt-black font-16 fw-500">৳ {{ $merchantOrder->total_amount }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
<div class="dsContainer mt-4">
    <div class="row">
        <div class="col-sm-6">
            <div class="dsMethod">
                <h6>DELIVERY ADDRESS</h6>
                <div class=" mt-2 d-flex flex-column gap-2">
                    <p>Name : {{ $order->customer_name }}</p>
                    <p>Cell : {{ $order->customer_number }}</p>
                    <p>Address : {{ $order->customer_address }} </p>
                    <p>landmark : {{ $order->customer_landmark }} </p>
                    <p>Division : {{ @$order->customer_location->parent->parent->name }} </p>
                    <p>District : {{ $order->customer_location->parent->name }} </p>
                    <p>City : {{ $order->customer_location->name }} </p>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection
