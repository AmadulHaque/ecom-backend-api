<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="100px" style="width: 100px"> TrkID </div>
                <div class="cell" data-width="150px" style="width: 150px"> Merchant </div>
                <div class="cell" data-width="120px" style="width: 120px"> Total Amount </div>
                <div class="cell" data-width="120px" style="width: 120px"> Discount Amount</div>
                <div class="cell" data-width="120px" style="width: 120px"> Shipping Charge</div>
                <div class="cell" data-width="120px" style="width: 120px"> Charge Amount</div>
                <div class="cell" data-width="100px" style="width: 100px"> Product Price </div>
                <div class="cell" data-width="100px" style="width: 100px"> Total Items </div>
                <div class="cell" data-width="100px" style="width: 100px"> Date </div>
                <div class="cell" data-width="100px" style="width: 100px"> Status </div>
                <div class="cell" data-width="110px" style="width: 110px;">Action</div>
            </div>
        </div>
        <div class="tbody">
            @foreach ($entity as $order)
            <div class="row">
                <div class="cell" data-width="100px" style="width: 100px"><i class="fa-solid fa-hashtag text-primary"></i>
                    {{ $order->tracking_id  }} </div>
                <div class="cell" data-width="150px" style="width: 150px">
                    <div class="d-block text-left">
                        <h6><i class="fa-regular fa-user text-primary "></i> {{ $order->merchant->name  }}</h6>
                        <p><i class="fa-solid fa-store text-warning"></i> {{ $order->merchant->shop_name  }}</p>
                    </div>
                </div>
                <div class="cell" data-width="120px" style="width: 120px"> {{ $order->total_amount  }} </div>
                <div class="cell" data-width="120px" style="width: 120px"> {{ $order->discount_amount  }} </div>
                <div class="cell" data-width="120px" style="width: 120px"> {{ $order->shipping_amount }}</div>
                <div class="cell" data-width="120px" style="width: 120px"> {{ $order->charge }} </div>
                <div class="cell" data-width="100px" style="width: 100px"> {{ $order->sub_total   }} </div>
                <div class="cell" data-width="100px" style="width: 100px"> {{ $order->order_items_count }} </div>
                <div class="cell" data-width="100px" style="width: 100px"> {{ $order->created_at }} </div>
                <div class="cell" data-width="100px" style="width: 100px">
                    <span class="text-white alert {{ $order->status_bg_color }} alert-sm">{{ $order->status_label }} </span>
                </div>
                <div class="cell" data-width="110px" style="width: 110px;">
                    <a href="{{ route('admin.orders.show', $order->order->invoice_id) }}" class="btn btn-link font-14">View</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<x-pagination :paginator="$entity" />