@foreach ($entity as $key => $item)
    <div class="row">
        <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration }} </div>
        <div class="cell" data-width="150px" style="width: 150px"> {{ $item->title }} </div>
        <div class="cell" data-width="150px" style="width: 150px">
            <span class="alert alert-primary  alert-sm text-capitalize text-white"> {{ $item->label }} </span>

        </div>
        <div class="cell" data-width="150px" style="width: 150px"> {{ $item->sub_title }} </div>
        <div class="cell" data-width="130px" style="width: 130px">
            <img src="{{ $item->full_image }}" style="width: 130px" class="img-fluid" alt="">
        </div>
        <div class="cell" data-width="130px" style="width: 130px">
            <img src="{{ $item->small_image }}" style="width: 130px" class="img-fluid" alt="">
        </div>
        <div class="cell" data-width="100px" style="width: 100px">
            <div class="alert {{ $item->status == 'active' ? 'alert-primary' : 'alert-warning' }}  alert-sm text-capitalize"
                role="alert">
                {{ $item->status }}
            </div>
        </div>
        @permission('slider-update', 'slider-delete')
        <div class="cell" data-width="150px" style="width: 150px;">
            <div class="btn-group">
                @permission('slider-update') 
                    <a href="{{ route('admin.sliders.edit', $item->id) }}"
                        class="btn btn-primary btn-sm justify-content-center align-items-center d-flex">Edit</a>
                @endpermission
                @permission('slider-delete') 
                    <button type="button" class="btn btn-warning btn-sm deleteItem"
                        data-url="{{ route('admin.sliders.destroy', $item->id) }}">Delete</button>
                @endpermission
            </div>
        </div>
    @endpermission

    </div>
@endforeach
