@php
    $sl = ($products->currentPage() - 1) * $products->perPage();
@endphp

<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                <div class="cell" data-width="64px" style="width: 64px"> Image </div>
                <div class="cell" data-width="220px" style="width: 220px"> Name </div>
                <div class="cell" data-width="220px" style="width: 220px"> Merchant Name </div>
                <div class="cell" data-width="90px" style="width: 90px"> SKU </div>
                <div class="cell" data-width="140px" style="width: 140px"> Category </div>
                <div class="cell" data-width="86px" style="width: 86px"> Regular price </div>
                <div class="cell" data-width="86px" style="width: 86px"> Discount price </div>
                <div class="cell" data-width="90px" style="width: 90px"> Variant </div>
                <div class="cell" data-width="70px" style="width: 70px"> Stock </div>
                @permission(['shop-product-show', 'product-request-show'])
                    <div class="cell" data-width="100px" style="width: 100px;"> Action</div>
                @endpermission
            </div>
        </div>
        <div id="table" class="tbody">
            @foreach ($products as $item)
                <div class="row">
                    <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration + $sl }} </div>
                    <div class="cell" data-width="64px" style="width: 64px">
                        <img src="{{  asset($item->product->thumbnail)}}" width="50px" height="50px" class="img-fluid" alt="">
                    </div>
                    <div class="cell" data-width="220px" style="width: 220px"> {{ $item->product->name }} </div>
                    <div class="cell" data-width="220px" style="width: 220px">
                        <a href="{{ route('admin.merchant.show', $item->merchant->id) }}" class="btn btn-link font-14">
                            @if (isset($item->merchant->shop_status) && $item->merchant->shop_status->value ==  1)
                            <i class="fa-solid fa-circle-check" style="color: #00a486;"></i>
                            @else
                            <i class="fa-solid fa-circle-xmark" style="color: #eab308;"></i>
                            @endif
                            {{ $item->merchant->name }}  
                        </a>
                    </div>
                    <div class="cell" data-width="90px" style="width: 90px"> {{ $item->product->sku }} </div>
                    <div class="cell" data-width="140px" style="width: 140px"> {{ $item->product->category->name }} </div>
                    <div class="cell" data-width="86px" style="width: 86px"> {{ $item->product->productDetail->regular_price }} </div>
                    <div class="cell" data-width="86px" style="width: 86px">{{ $item->product->productDetail->discount_price }} </div>
                    <div class="cell" data-width="90px" style="width: 90px">
                        <div class="request_status cursor-pointer alert   {{ $item->product->is_variant=='1' ? 'alert-warning' : 'alert-info'}}  alert-sm"
                            role="alert">
                            {{ $item->product->is_variant=='1' ? 'Variant' : 'Single'}}
                        </div>
                    </div>
                    <div class="cell" data-width="70px" style="width: 70px"> {{ $item->product->total_stock_qty }} </div>
                    @permission(['shop-product-show', 'product-request-show'])
                        <div class="cell" data-width="100px" style="width: 100px;">
                            <a href="{{ route('admin.product.show', $item->product->slug) }}" class="btn btn-link font-14">View</a>
                        </div>
                    @endpermission
                </div>
            @endforeach
        </div>
    </div>
</div>
<x-pagination :paginator="$products" />