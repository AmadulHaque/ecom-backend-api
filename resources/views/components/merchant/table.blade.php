


<div class="table">
    <div class="thead">
        <div class="row">
            <div class="cell" data-width="54px" style="width: 54px"> SL </div>
            <div class="cell" data-width="140px" style="width: 140px"> Name </div>
            <div class="cell" data-width="100px" style="width: 100px"> Phone </div>
            <div class="cell" data-width="150px" style="width: 150px"> Shop Address </div>
            <div class="cell" data-width="150px" style="width: 150px"> Shop Name </div>
            <div class="cell" data-width="250px" style="width: 250px"> Shop Url </div>
            <div class="cell" data-width="100px" style="width: 100px"> Date </div>
            <div class="cell" data-width="100px" style="width: 100px"> Shop Status </div>
            @permission('merchant-show')
                <div class="cell" data-width="100px" style="width: 100px;">Action</div>
            @endpermission
        </div>
    </div>
    <div  class="tbody">
        @php
            $sl = ($entity->currentPage() - 1) * $entity->perPage();
        @endphp
        @foreach ($entity as $item)
            <div class="row">
                <div class="cell" data-width="54px" style="width:54px;">{{ $loop->iteration + $sl }} </div>
                <div class="cell" data-width="140px" style="width: 140px">
                    {{ $item->name }}
                    @if (isset($item->shop_status) && $item->shop_status->value == 1)
                        <i class="fa-solid fa-circle-check" style="color: #00a486;"></i>
                    @else
                        <i class="fa-solid fa-circle-xmark" style="color: #eab308;"></i>
                    @endif
                </div>
                <div class="cell" data-width="100px" style="width: 100px"> {{ $item->phone }} </div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->shop_address }} </div>
                <div class="cell" data-width="150px" style="width: 150px"> {{ $item->shop_name }} </div>
                <div class="cell" data-width="250px" style="width: 250px"> {{ $item->shop_url }} </div>
                <div class="cell" data-width="100px" style="width: 100px"> {{ $item->created_at }} </div>
                <div class="cell" data-width="100px" style="width: 100px"> {{ $item->status_label() }} </div>
                @permission('merchant-show')
                    <div class="cell" data-width="100px" style="width: 100px;">
                        <a href="{{ route('admin.merchant.show', $item->id) }}" class="btn btn-link font-14">View</a>
                    </div>
                @endpermission
            </div>
        @endforeach
    </div>
</div>

<x-pagination :paginator="$entity" />
