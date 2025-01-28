@extends('backend.app')
@section('content')
    <div class="page-title mb-3">
        <div>
            <h5 class="fw-600">User List</h5>
        </div>
    </div>

    <div class="page-wrapper mt-3">

        <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
            <a href="{{ route('users.create') }}"
                class="btn btn-primary btn-sm justify-content-center d-flex align-items-center">Add new</a>

            <div class="serchBar w-25">
                <input type="text" class="form-control" placeholder="Search ..."
                    onChange="location.href='{{ Request::url() }}?search='+this.value">
            </div>
        </div>


        <div class="table-wrapper">
            <div class="table">
                <div class="thead">
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Email</div>
                        <div class="cell" data-width="150px" style="width: 130px"> Phone</div>
                        <div class="cell" data-width="150px" style="width: 130px"> Role</div>
                        <div class="cell" data-width="350px" style="width: 350px"> Permission</div>
                        {{-- <div class="cell" data-width="100px" style="width: 100px">  Status </div> --}}
                        <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                    </div>
                </div>
                <div id="table" class="tbody">
                    @php
                        $sl = ($users->currentPage() - 1) * $users->perPage();
                    @endphp
                    @foreach ($users as $key => $user)
                        <div class="row">
                            <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration }} </div>
                            <div class="cell" data-width="150px" style="width: 150px"> {{ $user->name }} </div>
                            <div class="cell" data-width="150px" style="width: 150px"> {{ $user->email }}</div>
                            <div class="cell" data-width="150px" style="width: 150px"> {{ $user->phone }}</div>
                            <div class="cell" data-width="150px" style="width: 150px">
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-primary text-white">{{ $role->name }}</span>
                                @endforeach
                            </div>
                            <div class="cell" data-width="350px" style="width: 350px">
                                @php
                                    $permissions = $user->permissions->merge($user->roles->flatMap->permissions)->unique('id');
                                @endphp
                            
                            <div style="display: flex; flex-wrap: wrap; gap: 10px; max-height: 200px; overflow-y: auto; width: 100%; box-sizing: border-box;">
                                @foreach ($permissions as $permission)
                                    <span class="d-flex align-items-center bg-light rounded-pill px-2 py-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1 1 auto; min-width: 150px; box-sizing: border-box;">
                                        <span class="me-2" style="width: 8px; height: 8px; min-width: 8px; 
                                                    background: {{ $user->permissions->contains('id', $permission->id) ? 'red' : 'blue' }};
                                                    display: inline-block; border-radius: 50%;"></span>
                                        <span style="font-size: 0.9em;">{{ $permission->name }}</span>
                                    </span>
                                @endforeach
                            </div>
                            
                            </div>
                            
                            {{-- <div class="cell" data-width="100px" style="width: 100px">  {{ $item->status }}
                </div> --}}
                            <div class="cell" data-width="150px" style="width: 150px;">
                                <div class="btn-group">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="btn btn-primary btn-sm justify-content-center align-items-center d-flex">Edit</a>
                                    <button type="button" class="btn btn-warning btn-sm deleteItem"
                                        data-url="{{ route('users.destroy', $user->id) }}">Delete</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $users->links() }}
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
                setTimeout(() => {
                    location.reload();
                }, 700);
            }
        });
    </script>
@endpush
