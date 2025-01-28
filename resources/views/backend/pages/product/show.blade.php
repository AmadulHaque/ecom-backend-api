@extends('backend.app')
@section('content')



<div class="page-title d-flex align-items-center justify-content-between">
    <div>
        <h5 class="fw-600">Product Details</h5>
    </div>
</div>
<div class="page-wrapper mt-3">
    <div class="product-details d-flex  ">
        <div class="productMain-image">
            <div class="thubnail-image">
                <img class="thumbnail_img" src="{{ $product->image[0]['url'] }}" alt="">
            </div>
            <div class="gallery-images d-flex gap-3 mt-2">
                @foreach ($product->image as $ke=>$image)
                <div class="images image {{ $ke==0 ? 'isselect' : ''}}">
                    <img src="{{ $image['url'] }}" alt="">
                </div>
                @endforeach
            </div>
        </div>
        <div class="product-informations">
            <h6 class="fw-600 mb-2">{{ $product->name }}</h6>
            <div class="d-flex align-items-center gap-2 mt-2 mb-2">
                <h6>Status :</h6>
                @if ($product->status == '1')
                <div class="alert alert-primary-50 alert-sm d-flex align-items-center gap-1" role="alert">
                    Active
                </div>
                @else
                <div class="alert alert-warning-50 alert-sm d-flex align-items-center gap-1" role="alert">
                    InActive
                </div>
                @endif
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 mb-2">
                <h6>Product Type :</h6>
                @if ($product->is_variant == '1')
                <div class="alert alert-primary-50 alert-sm d-flex align-items-center gap-1" role="alert">
                    Variant
                </div>
                @else
                <div class="alert alert-info-50 alert-sm d-flex align-items-center gap-1" role="alert">
                    Single
                </div>
                @endif
            </div>
            <div class="details-table ">
                <div class="row">
                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">SKU :</span> {{ $product->sku }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">Regular Price:</span>
                            {{ $product->productDetail->regular_price }}</p>
                    </div>

                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">Category :</span> {{ $product->category->name }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">Discount Price:</span>
                            {{ $product->productDetail->discount_price }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">Sub-category :</span> {{ $product->subCategory?->name}} </p>
                    </div>
        

                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">Sub-Sub-Category
                                :</span>{{ $product->subCategoryChild?->name }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">Brand :</span>
                            {{ $product->brand ? $product->brand->name : 'N/A' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><span class="fw-500 text-black">Selling Type:</span>
                            {{ $product->productDetail->selling_type }}</p>
                    </div>

                </div>

            </div>
            <div class="descriptions mt-4">
                <p>
                    <span class="fw-500 text-black">Description :</span>
                    {{ $product->description }}
                </p>
            </div>
        </div>
    </div>
</div>
@if (count($product->variations) > 0)
<div class="page-wrapper mt-3">
    <div class="product-details-lists">
        <div class="table-wrapper">
            <div class="table">
                <div class="thead">
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px;">SL</div>
                        <div class="cell" data-width="64px" style="width: 64px;">Image</div>
                        <div class="cell" data-width="100px" style="width: 100px;">SKU</div>
                        <div class="cell" data-width="70px" style="width: 70px;">Color</div>
                        <div class="cell" data-width="100px" style="width: 100px;">Purchase price</div>
                        <div class="cell" data-width="100px" style="width: 100px;">Regular price</div>
                        <div class="cell" data-width="100px" style="width: 100px;">Discounted price</div>
                        <div class="cell" data-width="100px" style="width: 100px;">Wholesale price</div>
                        <div class="cell" data-width="100px" style="width: 100px;">Wholesale Minimum Quantity</div>
                        <div class="cell" data-width="80px" style="width: 80px;">Stock</div>
                    </div>
                </div>
                <div class="tbody">
                    @foreach ($product->variations as $variant)
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px;">{{ $loop->iteration }}</div>
                        <div class="cell" data-width="64px" style="width: 64px;">
                            <img src="{{ asset($variant->image) }}" alt="" class="product-image">
                        </div>
                        <div class="cell" data-width="100px" style="width: 100px;">{{ $variant->sku }}</div>
                        <div class="cell" data-width="70px" style="width: 70px;">color</div>
                        <div class="cell" data-width="100px" style="width: 100px;">{{ $variant->purchase_price }}</div>
                        <div class="cell" data-width="100px" style="width: 100px;">{{ $variant->regular_price }}</div>
                        <div class="cell" data-width="100px" style="width: 100px;">{{ $variant->discount_price }}</div>
                        <div class="cell" data-width="100px" style="width: 100px;">{{ $variant->wholesale_price }}</div>
                        <div class="cell" data-width="100px" style="width: 100px;">{{ $variant->minimum_qty}}</div>
                        <div class="cell" data-width="80px" style="width: 80px;">{{ $variant->total_stock_qty }}</div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.images').click(function() {
        $('.images').removeClass('isselect');
        $(this).addClass('isselect');
        $('.thumbnail_img').attr('src', $(this).find('img').attr('src'));
    })
});
</script>
@endpush