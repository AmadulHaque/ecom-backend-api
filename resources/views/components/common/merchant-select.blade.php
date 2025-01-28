<select name="merchant_id" class="form-control manyselect2" id="merchant_id" onChange="event.preventDefault();AllScript.loadPage('{{ Request::url() }}?merchant_id='+this.value)">
    <option value="">-- select merchant --</option>
</select>

@push('scripts')
<script>
$('.manyselect2').select2({
    placeholder: "Select merchant...",
    theme: "bootstrap-5",
    templateResult: formatOption,
    templateSelection: formatOption,
    allowClear: true,
    ajax: {
        url: "{{ route('admin.ajax.merchants') }}",
        type: 'GET',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                search: params.term,
                type: 'merchant',
            };
        },
        processResults: function(res) {
            let data = res.data || [];
            return {
                results: data.map(function(item) {
                    return {
                        id: item.id,
                        text: item.name,
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
    var $option = $(
        '<span class="payment-option">' + option.text + '</span>'
    );
    return $option;
}
</script>
@endpush