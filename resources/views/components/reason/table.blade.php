
@foreach ($entity as $key=>$item)
<div class="row">
    <div class="cell" data-width="54px"  style="width: 54px">   {{ $loop->iteration }} </div>
    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->type }}</div>
    <div class="cell" data-width="150px" style="width: 150px"> {{ $item->name }}</div>

    <div class="cell" data-width="100px" style="width: 100px">
        <div class="alert {{ $item->status ? 'alert-primary' : 'alert-warning'}}  alert-sm text-capitalize" role="alert">
            {{ $item->status == '1' ? 'Active' : 'inActive' }}
        </div>
    </div>
    <div class="cell" data-width="150px" style="width: 150px;">
        <div class="btn-group">
            @permission('reason-update')
                <a href="{{ route('admin.reasons.edit', $item->id) }}" class="btn btn-primary btn-sm justify-content-center align-items-center d-flex" >Edit</a>
            @endpermission
            @permission('reason-delete')
                <button type="button" class="btn btn-warning btn-sm deleteItem" data-url="{{ route('admin.reasons.destroy', $item->id) }}">Delete</button>
            @endpermission
        </div>
    </div>
</div>
@endforeach

