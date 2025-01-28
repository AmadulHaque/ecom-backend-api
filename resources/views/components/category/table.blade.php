@php
    $type = request()->type ?? '1'; 
@endphp
<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                <div class="cell" data-width="100px" style="width: 100px"> Image</div>
                @if ($type == '2')
                    <div class="cell" data-width="100px" style="width: 100px">Category</div>
                @endif
                @if ($type == '3')
                    <div class="cell" data-width="100px" style="width: 100px">Category</div>
                    <div class="cell" data-width="100px" style="width: 100px">Sub Category</div>
                @endif
                <div class="cell" data-width="100px" style="width: 100px"> Status </div>
                <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
            </div>
        </div>
        <div  class="tbody">
            @php
                $sl = ($entity->currentPage() - 1) * $entity->perPage();
            @endphp
            @foreach ($entity as $key=>$item)
                <div class="row">
                    <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration + $sl }} </div>
                    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->name }} </div>
                    <div class="cell" data-width="100px" style="width: 100px"> 
                        <img src="{{ asset($item->image) }}" style="width: 80px" class="img-fluid" alt="">
                    </div>
                    @if ($type == '2')
                        <div class="cell" data-width="100px" style="width: 100px">{{ $item->category->name }}</div>
                    @endif
                    @if ($type == '3')
                        <div class="cell" data-width="100px" style="width: 100px">{{ $item->subCategory->category->name }}</div>
                        <div class="cell" data-width="100px" style="width: 100px">{{ $item->subCategory->name }}</div>
                    @endif
                    <div class="cell" data-width="100px" style="width: 100px">
                        <div class="alert   {{ $item->status =='1' ? 'alert-primary' : 'alert-warning'}}  alert-sm text-capitalize" role="alert"> {{ $item->status=='1' ? 'Active' : 'inActive' }}</div>
                    </div>
                    <div class="cell" data-width="150px" style="width: 150px;">
                        <div class="btn-group">
                            <a href="{{ route('admin.categories.edit', $item->id) }}?type={{ $type }}" class="btn btn-primary btn-sm justify-content-center align-items-center d-flex" >Edit</a>
                            <button type="button" class="btn btn-warning btn-sm deleteItem" data-url="{{ route('admin.categories.destroy', $item->id) }}?type={{ $type }}">Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<x-pagination :paginator="$entity"/>