@php
$sl = ($entity->currentPage() - 1) * $entity->perPage();
@endphp

<div class="table-wrapper">
    <div class="table">
        <div class="thead">
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> SL </div>
                <div class="cell" data-width="150px" style="width: 150px"> Name </div>
                <div class="cell" data-width="150px" style="width: 150px"> Phone</div>
                <div class="cell" data-width="130px" style="width: 130px"> Email</div>
                {{-- <div class="cell" data-width="100px" style="width: 100px"> Status </div> --}}
                @permission('customer-show')
                <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
                @endpermission
            </div>
        </div>
        <div class="tbody">
            @foreach ($entity as $item)
            <div class="row">
                <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration + $sl }} </div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->name }} </div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->phone }} </div>
                <div class="cell" data-width="130px" style="width: 130px"> {{ $item->email }} </div>
                {{-- <div class="cell" data-width="100px" style="width: 100px">  </div> --}}
                @permission('customer-show')
                <div class="cell" data-width="150px" style="width: 150px;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#customerModal{{ $item->id }}"
                        class="btn btn-link font-14">View</a>
                </div>
                @endpermission
            </div>

            <div class="modal" id="customerModal{{ $item->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="font-18 mt-2">Customer Addresses</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @forelse ($item->addresses as $user)
                                    <div class="col-sm-12">
                                        <div class="modal-user-address d-flex gap-2 flex-column">
                                            <div class="d-flex justify-content-between">
                                                <h5>Name : {{ $item->name }}</h5>
                                                <span
                                                    class="text-muted  {{ $user->address_type =='home' ? 'text-primary' : 'text-warning' }}">{{ $user->address_type }}</span>
                                            </div>
                                            @if ($user->location && $user->location->parent && $user->location->parent->parent)
                                            <div class="d-flex flex-column gap-1">
                                                <p>Phone : {{ $user->contact_number }}</p>
                                                <p>Division : {{ $user->location->parent->parent->name  ?? "" }}</p>
                                                <p>District : {{ $user->location->parent->name }}</p>
                                                <p>City : {{ $user->location->name }}</p>
                                                <p>Address : {{ $user->address }}</p>
                                                <p>Landmark : {{ $user->landmark }}</p>
                                                <p>Status : {{ $user->status=='1' ? 'Active' : 'Inactive' }}</p>
                                            </div>
                                            @else
                                            <div>
                                                <p class="text-danger">Address are in location not found</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                <div class="col-12 text-center">
                                    <h4>No Data Found</h4>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>
    </div>
</div>

<x-pagination :paginator="$entity" />

