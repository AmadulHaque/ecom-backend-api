{{-- Coupon listing view with all fields --}}
@php
    $sl = ($coupons->currentPage() - 1) * $coupons->perPage();
@endphp
<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px">SL</div>
                <div class="cell" data-width="150px" style="width: 150px">Name</div>
                <div class="cell" data-width="130px" style="width: 130px">Code</div>
                <div class="cell" data-width="130px" style="width: 130px">Type</div>
                <div class="cell" data-width="100px" style="width: 100px">Discount Value</div>
                <div class="cell" data-width="100px" style="width: 100px">Discount Type</div>
                <div class="cell" data-width="120px" style="width: 120px">Purchase Limits</div>
                <div class="cell" data-width="120px" style="width: 120px">Usage Limits</div>
                <div class="cell" data-width="170px" style="width: 170px">Valid Period</div>
                <div class="cell" data-width="220px" style="width: 220px">Notice</div>
                <div class="cell" data-width="100px" style="width: 100px">Status</div>
                <div class="cell" data-width="100px" style="width: 100px">Added By</div>
                <div class="cell" data-width="150px" style="width: 150px">Action</div>
            </div>
        </div>
        <div class="tbody">
            @foreach ($coupons as $item)
                <div class="row">
                    <div class="cell" data-width="54px" style="width: 54px">
                        {{ $loop->iteration + $sl }}
                    </div>
                    <div class="cell" data-width="150px" style="width: 150px">
                        {{ $item->name }}
                    </div>
                    <div class="cell" data-width="130px" style="width: 130px">
                        <span class="badge text-white bg-info text-wrap text-break">
                            {{ $item->code }}
                        </span>
                    </div>
                    <div class="cell" data-width="130px" style="width: 130px">
                        <span class="badge text-white bg-primary">{{ $item->type->name ?? '' }}</span>
                    </div>
                    <div class="cell" data-width="100px" style="width: 100px">
                        @if ($item->discount_type === 'percentage')
                            {{ $item->discount_value }}%
                        @else
                            {{ number_format($item->discount_value, 2) }}
                        @endif
                    </div>
                    <div class="cell" data-width="100px" style="width: 100px">
                        <span class="badge text-white bg-primary">{{ ucfirst($item->discount_type) }}</span>
                    </div>
                    <div class="cell" data-width="120px" style="width: 120px">
                        <small>
                            Min: {{ number_format($item->min_purchase) }}<br>
                            Max: {{ number_format($item->max_purchase) }}
                        </small>
                    </div>
                    <div class="cell" data-width="120px" style="width: 120px">
                        <small>
                            Per User: {{ $item->usage_limit_per_user }}<br>
                            Total: {{ $item->usage_limit_total }}
                            @if ($item->used_count > 0)
                                <br>Used: {{ $item->used_count }}
                            @endif
                        </small>
                    </div>
                    <div class="cell" data-width="170px" style="width: 170px">
                        <small>
                            Start: {{ Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}<br>
                            End: {{ Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}
                            <br>
                            @php
                                $now = Carbon\Carbon::now();
                                $startDate = Carbon\Carbon::parse($item->start_date);
                                $endDate = Carbon\Carbon::parse($item->end_date);
                            @endphp

                            @if ($now->lt($startDate))
                                <span class="badge bg-warning text-white small p-1">Upcoming</span>
                            @elseif($now->gt($endDate))
                                <span class="badge bg-danger text-white small p-1">Expired</span>
                            @else
                                <span class="badge bg-success text-white small p-1">Running</span>
                            @endif
                        </small>
                    </div>
                    <div class="cell" data-width="220px" style="width: 220px">
                        <small>
                            @if ($item->merchant_type)
                                <span class="badge text-white bg-info mb-1"> {{ $item->getTypeLabel('merchant_type') }}
                                    Merchants ({{ $item->merchants->count() }})</span><br>
                            @endif
                            @if ($item->category_type)
                                <span class="badge text-white bg-info mb-1">{{ $item->getTypeLabel('category_type') }}
                                    Categories ({{ $item->categories->count() }})</span><br>
                            @endif
                            @if ($item->brand_type)
                                <span class="badge text-white bg-info mb-1">{{ $item->getTypeLabel('brand_type') }}
                                    Brands ({{ $item->brands->count() }})</span><br>
                            @endif
                            @if ($item->product_type)
                                <span class="badge text-white bg-info mb-1">{{ $item->getTypeLabel('product_type') }}
                                    Products ({{ $item->products->count() }})</span>
                            @endif
                            @if (!$item->merchant_type && !$item->category_type && !$item->brand_type && !$item->product_type)
                                <span class="badge text-white bg-success">No Notice</span>
                            @endif
                        </small>
                    </div>
                    <div class="cell" data-width="100px" style="width: 100px">
                        @if ($item->status === 'active')
                            <span class="badge text-white bg-success">Active</span>
                        @else
                            <span class="badge text-white bg-warning">Inactive</span>
                        @endif
                    </div>
                    <div class="cell" data-width="100px" style="width: 100px">
                        {{ $item->user->name }}
                    </div>
                    <div class="cell" data-width="150px" style="width: 150px;">
                        <div class="btn-group">
                            <button onClick="location.href='{{ route('admin.coupons.edit', $item->id) }}'"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm deleteItem"
                                data-url="{{ route('admin.coupons.destroy', $item->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<x-pagination :paginator="$coupons" />
