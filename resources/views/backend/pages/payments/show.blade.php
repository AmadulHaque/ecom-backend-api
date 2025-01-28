@extends('backend.app')
@section('content')

<x-page-title title="Payment Details" />

<div class="page-wrapper mt-3 d-flex justify-content-between  order_details">
    <div class="order-id">
        <span class="d-flex gap-1">Order Id : <p class="txt-primary"> #{{ $payment->order->tracking_id  }} </p>
        </span>
        <small>Placed on : {{ $payment->order->created_at }}</small>
    </div>
    <div class="status-tab mt-3">
        <div class="tab-menus">
            <ul class="tab-menus-items d-flex gap-3">
                <li class="tab-item">
                    <button class=" btn btn-sm  btn-primary ">{{ $payment->order->status_label }}</button>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="storeContainer d-flex flex-column gap-2">
    @php
        $merchantOrder = $payment->order;
    @endphp
    <div class="storeOrder ">
        <div class="page-wrapper mt-3">
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

<div class="dsContainer mt-4">
    <div class="row">
        <div class="col-sm-6">
            <div class="dsMethod">
                <h6>DELIVERY ADDRESS</h6>
                <div class=" mt-2 d-flex flex-column gap-2">
                    <p>Name : {{ $merchantOrder->order->customer_name }}</p>
                    <p>Cell : {{ $merchantOrder->order->customer_number }}</p>
                    <p>Address : {{ $merchantOrder->order->customer_address }} </p>
                    <p>landmark : {{ $merchantOrder->order->customer_landmark }} </p>
                    <p>Division : {{ $merchantOrder->order->customer_location->parent->parent?->name }} </p>
                    <p>District : {{ $merchantOrder->order->customer_location->parent->name }} </p>
                    <p>City : {{ $merchantOrder->order->customer_location->name }} </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="dsMethod">
                <h6>PAYMENT INFORMATION</h6>
                <div class=" mt-2 d-flex flex-column gap-2">
                    <p>Payment Method  : {{ $payment->payment_method }} </p>
                    <p>Payment Status  :  <span class="text-white alert {{ $payment->status_bg_color }} alert-sm ">{{ $payment->status_label }}</span> </p>
                    <p>Payment TransID  : {{ $payment->tran_id  }} </p>
                    <p>Payment Amount  : {{ $payment->amount  }} </p>
                    <p>Payment Ref  : {{ $payment->payment_ref  }} </p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


