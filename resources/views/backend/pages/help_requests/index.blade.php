@extends('backend.app')
@section('content')
    <div class="page-title mb-3">
        <div>
            <h5 class="fw-600">Help Requests</h5>
        </div>
    </div>

    <div class="page-wrapper mt-3">

        <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
            <div class="serchBar w-25">
                <input name="search" type="text" class="form-control" placeholder="Search by phone..."
                    onChange="location.href='{{ Request::url() }}?search='+this.value" value="{{ $_GET['search'] ?? '' }}">
            </div>
        </div>


        <div class="table-wrapper">
            <div class="table">
                <div class="thead">
                    <div class="row">
                        <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                        <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                        <div class="cell" data-width="150px" style="width: 130px"> Phone</div>
                        <div class="cell" data-width="350px" style="width: 350px"> Message</div>
                        <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                    </div>
                </div>
                <div id="table" class="tbody">
                    @php
                        $sl = ($messages->currentPage() - 1) * $messages->perPage();
                    @endphp
                    @forelse ($messages as $key => $item)
                        <div class="row">
                            <div class="cell" data-width="54px" style="width: 54px">
                                {{ $loop->iteration + $messages->firstItem() - 1 }} </div>
                            <div class="cell" data-width="150px" style="width: 150px"> {{ $item->merchant->user->name }}
                            </div>
                            <div class="cell" data-width="150px" style="width: 150px"> {{ $item->phone }}</div>
                            <div class="cell" data-width="350px" style="width: 350px"> {{ $item->message }}</div>


                            <div class="cell" data-width="150px" style="width: 150px;">
                                <div class="btn-group">
                                    <form action="{{ route('admin.help-requests.destroy', $item->id) }}" method="post"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning btn-sm deleteItem">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center mt-4">No Messages Found</div>
                    @endforelse
                </div>
                {{ $messages->links() }}
                {{-- <x-pagination :paginator="$messages" /> --}}

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.deleteItem', function(e) {
            e.preventDefault(); // Prevent immediate form submission
            let form = $(this).closest('form'); // Get the closest form

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
