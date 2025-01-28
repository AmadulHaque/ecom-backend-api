@foreach ($category_requests as $key => $request)
    <div class="row">
        <div class="cell" data-width="54px" style="width: 54px">
            {{ $loop->iteration + $category_requests->firstItem() - 1 }} </div>
        <div class="cell" data-width="150px" style="width: 150px"> {{ $request->merchant->user->name }}</div>
        <div class="cell" data-width="150px" style="width: 150px"> {{ $request->category_name }}</div>

        <div class="cell" data-width="100px" style="width: 100px">
            <div class="alert {{ $request->status == '1' ? 'alert-info' : ($request->status == '2' ? 'alert-success' : 'alert-danger') }} alert-sm text-capitalize"
                role="alert">
                {{ $request->status == '1' ? 'Pending' : ($request->status == '2' ? 'Approved' : 'Rejected') }}
            </div>
        </div>
        <div class="cell" data-width="150px" style="width: 150px;">
            <div class="btn-group">
                @permission('reason-update')
                    <a href="{{ route('admin.category-create-requests.show', $request->id) }}"
                        class="btn btn-primary btn-sm justify-content-center align-items-center d-flex">View</a>
                @endpermission
                @permission('reason-delete')
                    <button type="button" class="btn btn-warning btn-sm deleteItem"
                        data-url="{{ route('admin.reasons.destroy', $request->id) }}">Delete</button>
                @endpermission
            </div>
        </div>
    </div>
@endforeach
