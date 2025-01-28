<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="100px" style="width: 100px"> InvID </div>
                <div class="cell" data-width="150px" style="width: 150px"> Customer </div>
                <div class="cell" data-width="120px" style="width: 120px"> Shipping Type </div>
                <div class="cell" data-width="120px" style="width: 120px"> Delivery Type </div>
                <div class="cell" data-width="120px" style="width: 120px"> Total Amount </div>
                <div class="cell" data-width="120px" style="width: 120px"> Discount </div>
                <div class="cell" data-width="120px" style="width: 120px"> Shipping Charge </div>
                <div class="cell" data-width="120px" style="width: 120px"> Charge Amount</div>
                <div class="cell" data-width="94px" style="width: 94px"> Product Price </div>
                <div class="cell" data-width="100px" style="width: 100px"> Total Items </div>
                <div class="cell" data-width="100px" style="width: 100px"> Date </div>
                @permission('order-show')
                    <div class="cell" data-width="90px" style="width: 90px;">Action</div>
                @endpermission
            </div>
        </div>
        <div class="tbody">
            @foreach ($entity as $order)
                <div class="row">
                    <div class="cell" data-width="100px" style="width: 100px"><i class="fa-solid fa-hashtag text-primary"></i>
                        {{ $order->invoice_id  }} </div>
                    <div class="cell" data-width="150px" style="width: 150px">
                        <div class="d-block text-left">
                            <h6> {{ $order->customer_name  }}</h6>
                            <p> {{ $order->customer_number  }}</p>
                        </div>
                    </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->shipping_type  }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->delivery_type_label  }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->total_amount  }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->total_discount  }} </div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->total_shipping_fee }}</div>
                    <div class="cell" data-width="120px" style="width: 120px"> {{ $order->charge }} </div>
                    <div class="cell" data-width="94px" style="width: 94px"> {{ $order->total_price   }} </div>
                    <div class="cell" data-width="100px" style="width: 100px"> {{ $order->order_items_count }} </div>
                    <div class="cell" data-width="100px" style="width: 100px"> {{ $order->created_at }} </div>
                    @permission('order-show')
                        <div class="cell" data-width="90px" style="width: 90px;">
                            <a href="{{ route('admin.orders.show', $order->invoice_id) }}" class="btn btn-link font-14">View</a>
                        </div>
                    @endpermission
                </div>
            @endforeach

        </div>
    </div>
</div>
<x-pagination :paginator="$entity" />