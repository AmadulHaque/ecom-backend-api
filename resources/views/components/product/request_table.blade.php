

<div class="table-wrapper">
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
                <div class="cell" data-width="200px" style="width: 200px;">
                    Merchant
                </div>
                @permission('product-request-update')
                <div class="cell" data-width="110px" style="width: 110px;">
                    Status
                </div>
                @endpermission
                <div class="cell" data-width="110px" style="width: 110px;">
                    Date
                </div>
                @permission('product-request-show')
                <div class="cell" data-width="100px" style="width: 100px;">
                    Action
                </div>
                @endpermission
            </div>
        </div>
        <div  class="tbody">
            @php
                $total = ($products->currentPage() - 1) * $products->perPage();
            @endphp
            @foreach ($products as $key=>$item)
                <div class="row">
                    <div class="cell" data-width="44px" style="width: 44px;">
                        {{ $loop->iteration + $total }}
                    </div>
                    <div class="cell" data-width="64px" style="width: 64px">
                        <img src="{{  asset($item->product->thumbnail)}}" width="50px" height="50px" class="img-fluid" alt="">
                    </div>
                    <div class="cell" data-width="210px" style="width: 210px;">
                        {{ $item->product->name }}
                    </div>
                    <div class="cell" data-width="200px" style="width: 200px;">
                        <a 
                        href="{{ route('admin.merchant.show', $item->merchant->id) }}" 
                        @if (isset($item->merchant->shop_status) && $item->merchant->shop_status->value != 1)
                            title="Make this merchant active"
                            data-bs-toggle="tooltip"
                        @endif
                        class="btn btn-link font-14">
                            @if (isset($item->merchant->shop_status) &&$item->merchant->shop_status->value == 1)
                                <i class="fa-solid fa-circle-check" style="color: #00a486;"></i>
                            @else
                                <i class="fa-solid fa-circle-xmark" style="color: #eab308;"></i>
                            @endif
                            {{ $item->merchant->name }}
                        </a>
                    </div>
                    @permission('product-request-update')
                        <div class="cell" data-width="110px" style="width: 110px;">

                            <div @if (isset($item->merchant->shop_status) &&$item->merchant->shop_status->value == 1)
                                    data-bs-toggle="modal"
                                    data-bs-target="#requestModal"
                                    data-page="{{ $products->currentPage() }}"
                                    data-status="{{ $item->status }}"
                                    data-id="{{ $item->id }}"
                                @else
                                    title="Make the merchant active first"
                                    data-bs-toggle="tooltip"
                                @endif
                                class="cursor-pointer alert alert-sm {{ $item->status_color }}
                                {{ isset($item->merchant->shop_status) && $item->merchant->shop_status->value == '1' ? 'request_status' : '' }}"
                                role="alert">
                                {{ $item->status_label }}
                            </div>

                        </div>
                    @endpermission
                    <div class="cell" data-width="110px" style="width: 110px;">
                        {{ $item->created_at }}
                    </div>
                    @permission('product-request-show')
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