@php
    $request = request();
    $parent = \App\Models\Location::find($request->location_id);
@endphp
<div class="thead">
    <div class="row">
        <div class="cell" data-width="54px" style="width: 54px"> SL </div>
        <div class="cell" data-width="150px" style="width: 150px"> Division </div>
        <div class="cell" data-width="150px" style="width: 150px"> District </div>
        {{-- @endif --}}
        @if (isset($parent) && $parent->type == 'division')
        @else
            <div class="cell" data-width="150px" style="width: 150px"> City </div>
        @endif
        @permission('location-update')
            <div class="cell" data-width="150px" style="width: 150px;"> Action</div>
        @endpermission
    </div>
</div>
<div class="tbody">
    @php
        $sl = ($entity->currentPage() - 1) * $entity->perPage();
    @endphp
    @foreach ($entity as $key => $item)
        <div class="row">
            <div class="cell" data-width="54px" style="width: 54px"> {{ $loop->iteration + $sl }}</div>

            @if (isset($parent) && $parent->type == 'division')
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->parent->name }} </div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->name }} </div>
            @else
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->parent->parent->name ?? '' }}
                </div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->parent->name }} </div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->name }} </div>
            @endif


            @permission('location-update')
                <div class="cell" data-width="150px" style="width: 150px;">
                    <div class="btn-group">
                        <a href="{{ route('admin.locations.edit', $item->id) }}"
                            class="btn btn-primary btn-sm justify-content-center align-items-center d-flex">Edit</a>
                    </div>
                </div>
            @endpermission
        </div>
    @endforeach
</div>

<x-pagination :paginator="$entity" />
