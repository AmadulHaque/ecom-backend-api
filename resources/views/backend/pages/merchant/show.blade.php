@extends('backend.app')
@section('style')
<style>


</style>
@endsection
@section('content')

<x-page-title title="Merchant Details" />


<div class="page-wrapper mt-3 ">
    <div class="store-profile">
        <div class="banner">

        </div>
        <div>
            <div class="profile d-flex gap-3 align-items-center">
                <div class="profile-image">
                    <img src="{{ asset('assets') }}/images/no_mage.svg" alt="">
                </div>
                <div class="d-flex align-items-center">
                    <a href="#" class="btn btn-link">{{ $merchant->shop_name }}</a>
                    @if (isset($merchant->shop_status) && $merchant->shop_status->value == 1)
                    <i class="fa-solid fa-circle-check" style="color: #00a486;"></i>
                    @endif
                    @permission('merchant-active')
                        @if ( !isset($merchant->shop_status) or $merchant->shop_status->value != 1)
                        <form id="activeForm" action="{{ route('admin.merchant.active', $merchant->id) }}" method="post">
                            @method('PATCH')
                            @csrf
                            <button type="button" class="ActiveBtn btn btn-danger btn-ex-sm ms-2">Make Active</button>
                        </form>
                        @endif
                    @endpermission
                </div>
            </div>
            @if (isset($merchant->shop_status) && $merchant->shop_status->value == 1)
            <a href="{{ route('admin.merchant-reports.create') }}?id={{ $merchant->id }}" class="btn btn-warning btn-ex-sm justify-content-center align-items-center d-flex float-end ">Change to InActive</a>
            @endif
        </div>
        <div class="basic-info mt-3 d-flex flex-column gap-1">
            <p><b>Name:</b> {{ $merchant->name }}</p>
            <p><b>Phone:</b> {{ $merchant->phone }}</p>
            <p><b>Email:</b> {{ $merchant->email }}</p>
            <p><b>Address:</b> {{ $merchant->shop_address }}</p>
            <p><b>Shop Url: </b>{{ $merchant->shop_url  }}</p>
            <p><b>Shop Status: </b> 
                @if (isset($merchant->shop_status))
                    <span class="text-white alert alert-{{ $merchant->status_color() }} alert-sm">{{ $merchant->status_label() }} </span>
                @else
                    Unknown
                @endif
            </p>
        </div>
    </div>
</div>

<div class="store-summary mt-3">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon">
                        <!-- <img src="{{ asset('backend') }}/images/icon/cash_in_hand.svg" alt=""> -->
                    </div>
                    <div class="card-body-text d-flex flex-column ">
                        <h6 class="card-title fw-400">Total Product</h6>
                        <h5 class="card-text fw-600">{{ $count['products'] }} / {{$count['shop_products']}}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon">
                        <!-- <img src="{{ asset('backend') }}/images/icon/cash_in_hand.svg" alt=""> -->
                    </div>
                    <div class="card-body-text d-flex flex-column">
                        <a href="#orders">
                            <h6 class="card-title fw-400">Total Order</h6>
                            <h5 class="card-text fw-600">{{ $count['orders'] }} </h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon">
                        <!-- <img src="{{ asset('backend') }}/images/icon/cash_in_hand.svg" alt=""> -->
                    </div>
                    <div class="card-body-text d-flex flex-column ">
                        <h6 class="card-title fw-400">Cancel Order</h6>
                        <h5 class="card-text fw-600">{{ $count['cancel_orders'] }} </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon">
                        <!-- <img src="{{ asset('backend') }}/images/icon/cash_in_hand.svg" alt=""> -->
                    </div>
                    <div class="card-body-text d-flex flex-column ">
                        <h6 class="card-title fw-400">Total Customers</h6>
                        <h5 class="card-text fw-600">{{ $count['customers'] }}</h5>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon">
                        <!-- <img src="{{ asset('backend') }}/images/icon/cash_in_hand.svg" alt=""> -->
                    </div>
                    <div class="card-body-text d-flex flex-column ">
                        <h6 class="card-title fw-400">Current Balance</h6>
                        <h5 class="card-text fw-600">৳{{ $merchant->balance }}</h5>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon">
                        <!-- <img src="{{ asset('backend') }}/images/icon/cash_in_hand.svg" alt=""> -->
                    </div>
                    <div class="card-body-text d-flex flex-column ">
                        <a href="#products">
                            <h6 class="card-title fw-400">Total Products</h6>
                            <h5 class="card-text fw-600">{{ count($merchant->products) }}</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon">
                        <!-- <img src="{{ asset('backend') }}/images/icon/cash_in_hand.svg" alt=""> -->
                    </div>
                    <div class="card-body-text d-flex flex-column ">
                        <a href="#reports">
                            <h6 class="card-title fw-400">Total Reports</h6>
                            <h5 class="card-text fw-600">{{ count($merchant->reports) }}</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="products"  class="block-wrapper mt-3">
    @if ($products->count() > 0)
    <div class="page-title mb-3">
        <h5><b>Products</b></h5>
    </div>
    
    <div class="tab-menus">
        <ul class="tab-menus-items d-flex gap-3">
            <li class="tab-item">
                <button onClick="event.preventDefault();AllScript.loadPage('{{ Request::url() }}')"
                    class=" btn btn-sm btn-primary">All</button>
            </li>
            @foreach ($shopStatuses as $key=>$value)
            <li class="tab-item">
                <button onClick="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?status={{ $key }}')"
                    class=" btn btn-sm btn-secondary">{{ $value }}</button>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="table-wrapper mt-3">
        <div class="table">
            <div class="thead">
                <div class="row">
                    <div class="cell" data-width="44px" style="width: 44px;">
                        Id
                    </div>
                    <div class="cell" data-width="64px" style="width: 64px"> Image </div>
                    <div class="cell" data-width="210px" style="width: 210px;">
                        Name
                    </div>
                    <div class="cell" data-width="110px" style="width: 110px;">
                        Status
                    </div>

                    <div class="cell" data-width="110px" style="width: 110px;">
                        Date
                    </div>
                    <div class="cell" data-width="100px" style="width: 100px;">
                        Action
                    </div>
                </div>
            </div>
            <div id="table" class="tbody">
                <x-merchant.product_table :entity="$products" />
            </div>
        </div>
    </div>
    @else
    <div class="text-center">
        <h5>No Product Found</h5>
    </div>
    @endif
</div>
<div id="orders" class="block-wrapper mt-3">
    @if ($orders->count() > 0)
    <div class="page-title mb-3">
        <h5><b>Orders</b></h5>
    </div>
    <div  class="table-wrapper mt-3">
        <div class="table">
            <div class="thead">
                <div class="row">
                    <div class="cell" data-width="100px" style="width: 100px"> TrkID </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Total Amount </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Total Discount </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Total Shipping </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Total Charge </div>
                    <div class="cell" data-width="100px" style="width: 100px"> Total Price </div>
                    <div class="cell" data-width="100px" style="width: 100px"> Total Items </div>
                    <div class="cell" data-width="100px" style="width: 100px"> Date </div>
                    <div class="cell" data-width="100px" style="width: 100px"> Status </div>
                    <div class="cell" data-width="110px" style="width: 110px;">Action</div>
                </div>
            </div>
            <div id="table" class="tbody">
                @foreach ($orders as $order)
                <div class="row">
                    <div class="cell" data-width="100px" style="width: 100px"><i
                            class="fa-solid fa-hashtag text-primary"></i> {{ $order->tracking_id  }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->total_amount  }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->discount_amount  }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->shipping_amount }}</div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->charge }} </div>
                    <div class="cell" data-width="100px" style="width: 100px"> {{ $order->sub_total   }} </div>
                    <div class="cell" data-width="100px" style="width: 100px"> {{ $order->order_items_count }} </div>
                    <div class="cell" data-width="100px" style="width: 100px"> {{ $order->created_at }} </div>
                    <div class="cell" data-width="100px" style="width: 100px">
                        <span class="text-white alert {{ $order->status_bg_color }} alert-sm">{{ $order->status_label }}
                        </span>
                    </div>
                    <div class="cell" data-width="110px" style="width: 110px;">
                        <a href="{{ route('admin.orders.show', $order->order->invoice_id) }}"
                            class="btn btn-link font-14">View</a>
                    </div>
                </div>
                @endforeach
                <div class="text-center">
                    <p><a href="{{ route('admin.merchant.order.list') }}?merchant_id={{ $merchant->id }}"
                            class="btn btn-link">View All Orders</a></p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center">
        <h5>No Order Found</h5>
    </div>
    @endif
</div>

<div id="reports" class="block-wrapper mt-3">
    @if (count($merchant->reports) > 0)
    <div class="page-title mb-3">
        <h5><b>Reports</b></h5>
    </div>
    <div  class="table-wrapper mt-3">
        <div class="table">
            <div class="thead">
                <div class="row">
                    <div class="cell" data-width="100px" style="width: 100px"> SL </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Status </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Created Date </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Updated Date </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Added By </div>
                    <div class="cell" data-width="120px" style="width: 120px"> Action </div>
                </div>
            </div>
            <div id="table" class="tbody">
                @foreach ($merchant->reports as $report)
                <div class="row">
                    <div class="cell" data-width="100px" style="width: 100px"> {{ $loop->iteration }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $report->status }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $report->created_at->format('d-m-Y') }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $report->updated_at->format('d-m-Y') }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $report->addedBy->name }} </div>
                    <div class="cell" data-width="110px" style="width: 110px;">
                        <a href="{{ route('admin.merchant-reports.show', $report->id) }}"
                            class="btn btn-link font-14">View</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="text-center">
        <h5>No Reports Found</h5>
    </div>
    @endif
</div>




@endsection
@push('scripts')
<script>
    $(document).on('click', '.ActiveBtn', function() {
        Swal.fire({
            title: "Are you sure?",
            text: 'You want to Active this Merchant',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Active it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $('#activeForm').submit();
            }
        });
    });
</script>
@endpush