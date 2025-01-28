@foreach ($entity as $item)
    <div class="row">
        <div class="cell" data-width="54px" style="width:54px;">{{ $loop->iteration }} </div>

        <div class="cell" data-width="250px" style="width: 250px"> {{ $item->name }} </div>
        <div class="cell" data-width="100px" style="width: 100px;">
            <a href="{{ route('admin.pages.section.show', $item->slug) }}" class="btn btn-link font-14">View</a>
        </div>
    </div>
@endforeach
