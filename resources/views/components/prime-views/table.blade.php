
<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                <div class="cell" data-width="580px" style="width: 580px"> Products</div>
                <div class="cell" data-width="100px" style="width: 100px"> Status </div>
                @permission(['prime-view-update', 'prime-view-delete'])
                    <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                @endpermission
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
                    <div class="cell d-flex flex-wrap gap-1" data-width="580px" style="width: 580px" >
                        @foreach ($item->products as $product)
                          <span class="cursor-pointer alert alert-sm alert-info text-white"> {{ $product->name }}</span>
                        @endforeach
                    </div>
                    <div class="cell" data-width="100px" style="width: 100px">
                        <div class="alert   {{ $item->status =='active' ? 'alert-primary' : 'alert-warning'}}  alert-sm text-capitalize"
                            role="alert">
                            {{ $item->status }}
                        </div>
                    </div>
                    @permission(['prime-view-update', 'prime-view-delete'])
                    <div class="cell" data-width="150px" style="width: 150px;">
                        <div class="btn-group">
                            @permission('prime-view-update')
                                <button type="button" class="btn btn-primary btn-sm editItem"
                                    data-url="{{ route('admin.prime-views.edit', $item->id) }}" data-bs-toggle="modal"
                                    data-bs-target="#editModal">Edit</button>
                            @endpermission
                            @permission('prime-view-delete')
                            <button type="button" class="btn btn-warning btn-sm deleteItem"
                                data-url="{{ route('admin.prime-views.destroy', $item->id) }}">Delete</button>
                            @endpermission
                        </div>
                    </div>
                    @endpermission
                </div>
            @endforeach
        </div>
    </div>
</div>
<x-pagination :paginator="$entity"/>