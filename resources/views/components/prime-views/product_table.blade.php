@php
$sl = ($entity->currentPage() - 1) * $entity->perPage();
@endphp
@foreach ($entity as $key=>$item)
<div class="row">
    <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration + $sl }} </div>
    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->prime_view->name }} </div>
    <div class="cell" data-width="80px" style="width: 80px">
        <img src="{{$item->product->thumbnail}}" width="100%" height="100%" class="img-fluid" alt="">
    </div>
    <div class="cell" data-width="220px" style="width: 220px"> {{ $item->product->name }} </div>
    <div class="cell" data-width="90px" style="width: 90px"> {{ $item->product->sku }} </div>
    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->product->category->name }} </div>
    <div class="cell" data-width="120px" style="width: 120px"> {{ $item->product->productDetail->regular_price }}</div>
    <div class="cell" data-width="120px" style="width: 120px"> {{ $item->product->productDetail->discount_price }}
    </div>
    <div class="cell" data-width="70px" style="width: 70px"> {{ $item->product->total_stock_qty }} </div>
    @permission('prime-view-delete')
        <div class="cell" data-width="100px" style="width: 100px;">
            <button type="button" class="btn btn-warning btn-sm deleteItem"
                data-url="{{ route('admin.prime-view-products.destroy', $item->id) }}">Delete</button>
        </div>
    @endpermission
</div>
@endforeach