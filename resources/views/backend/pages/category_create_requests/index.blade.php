@extends('backend.app')
@section('content')
    <x-page-title title="Category Create Requests" />

    <div class="page-wrapper mt-3">
        <div class="page-title mb-3 d-flex justify-content-between reasons-title">
            <div class="d-flex gap-3 reasons-status">
                <div class="selectBar">
                    <select id="type" name="type" class="custom-select2"
                        onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?status='+this.value)">
                        <option value="1">Pending</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                    </select>
                </div>
            </div>


        </div>

        <div class="table-wrapper">
            <div class="table">
                <div class="thead">
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Merchant </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                        <div class="cell" data-width="100px" style="width: 100px"> Status </div>
                        @permission(['reason-update', 'reason-delete'])
                            <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                        @endpermission
                    </div>
                </div>
                {{-- @dd($category_requests) --}}
                <div id="table" class="tbody">
                    @foreach ($category_requests as $key => $request)
                        <div class="row">
                            <div class="cell" data-width="54px" style="width: 54px">
                                {{ $loop->iteration + $category_requests->firstItem() - 1 }} </div>
                            <div class="cell" data-width="150px" style="width: 150px">
                                {{ $request->merchant->user->name }}</div>
                            <div class="cell" data-width="150px" style="width: 150px"> {{ $request->category_name }}</div>

                            <div class="cell" data-width="100px" style="width: 100px">
                                <div class="alert {{ $request->status == '1' ? 'alert-info' : ($request->status == '2' ? 'alert-success' : 'alert-danger') }} alert-sm text-capitalize"
                                    role="alert">
                                    {{ $request->status == '1' ? 'Pending' : ($request->status == '2' ? 'Approved' : 'Rejected') }}
                                </div>
                            </div>
                            @permission(['reason-update', 'reason-delete'])
                                <div class="cell" data-width="150px" style="width: 150px;">
                                    <div class="btn-group">
                                        @permission('reason-update')
                                            <a href="{{ route('admin.category-create-requests.show', $request->id) }}"
                                                class="btn btn-primary btn-sm justify-content-center align-items-center d-flex">View</a>
                                        @endpermission
                                        @permission('reason-delete')
                                            <button type="button" class="btn btn-warning btn-sm deleteItem"
                                                data-url="{{ route('admin.category-create-requests.destroy', $request->id) }}">Delete</button>
                                        @endpermission
                                    </div>
                                </div>
                            @endpermission
                        </div>
                    @endforeach
                </div>
                <x-pagination :paginator="$category_requests" />
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.deleteItem', async function() {
            const url = $(this).data('url');
            const result = await AllScript.deleteItem(url);
            if (result) {
                AllScript.loadPage('{{ Request::url() }}');
            }
        });
    </script>
@endpush
