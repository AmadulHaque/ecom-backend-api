@php
$total = ($entity->currentPage() - 1) * $entity->perPage();
@endphp
@foreach ($entity as $key=>$item)
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
    <div class="cell" data-width="110px" style="width: 110px;">

        <div class="cursor-pointer alert alert-sm {{ $item->status_color }}" role="alert">
            {{ $item->status_label }}
        </div>

    </div>
    <div class="cell" data-width="110px" style="width: 110px;">
        {{ $item->created_at }}
    </div>
    <div class="cell" data-width="100px" style="width: 100px;">
        <a href="{{ route('admin.product.show', $item->product->slug) }}" class="btn btn-link font-14">View</a>
    </div>
</div>
@endforeach
<!-- <x-pagination :paginator="$entity" /> -->