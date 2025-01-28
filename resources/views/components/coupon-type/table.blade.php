
@foreach ($entity as $key=>$item)
<div class="row">
    <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration  }} </div>
    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->name }} </div>
    <div class="cell" data-width="150px" style="width: 150px;">
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm editItem"
                    data-url="{{ route('admin.coupon-types.edit', $item->id) }}" data-bs-toggle="modal"
                    data-bs-target="#editModal">Edit</button>
            <button type="button" class="btn btn-warning btn-sm deleteItem"
                data-url="{{ route('admin.coupon-types.destroy', $item->id) }}">Delete</button>
        </div>
    </div>
</div>

@endforeach