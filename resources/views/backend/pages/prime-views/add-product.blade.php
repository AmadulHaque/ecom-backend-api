@extends('backend.app')
@section('content')

<x-page-title title="Add Product" />

<div class="page-wrapper mt-3">

    <form id="saveButton" action="{{ route('admin.prime-view-products.store') }}" method="POST"
        class="needs-validation add-primeview-product" novalidate="">
        @csrf
        <div class="row  ">
            <div class="col-sm-12">
                <label for="">Prime View</label>
                <select id="prime_view_id" name="prime_view_id" class="custom-select2">
                    @foreach ($prime_views as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-12 mt-3">
                <label for="">Products</label>
                <select id="products" name="products[]" class="manyselect2" multiple="multiple">
                    <option value="">Choose..</option>
                </select>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Save</button>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')

<script>
$(document).on('submit', '#saveButton', async function(e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr('action');
    const res = await AllScript.submitFormAsync(form, actionUrl, 'POST');
    if (res) {
        window.location.href = "/prime-view-products";
    }
})
$('.manyselect2').select2({
    placeholder: "Select products...",
    theme: "bootstrap-5",
    templateResult: formatOption,
    templateSelection: formatOption,
    ajax: {
        url: "{{ route('admin.prime-view-products.create') }}",
        type: 'GET',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                search: params.term
            };
        },
        processResults: function(res) {
            let data = res.products || [];
            return {
                results: data.map(function(item) {
                    // console.log(item.product.thumbnail);
                    return {
                        id: item.product.id,
                        text: item.product.name,
                        image: item.product.thumbnail
                    };
                })
            };
        }
    },
});

// Function to format the option with images
function formatOption(option) {
    if (!option.id) {
        return option.text;
    }
    var imageUrl = option.image;
    var $option = $(
        '<span class="payment-option"><img src="' + imageUrl +
        '" class="img-option" alt="icon" style="width: 32px; height: 32px; margin-right: 8px;">' +
        option.text + '</span>'
    );
    return $option;
}
</script>
@endpush