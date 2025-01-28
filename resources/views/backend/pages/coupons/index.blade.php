@extends('backend.app')
@section('content')
    <x-page-title title="Coupon List" />

    <div class="page-wrapper mt-3">
        <div class="page-title mb-3 d-flex justify-content-between SelectSearch">
            <a href="{{ route('admin.coupons.create') }}"
                class="btn btn-primary btn-sm justify-content-center d-flex align-items-center">Add new</a>

            <div class="d-flex gap-2">
                <div class="selectBar">
                    <select name="status" id="Status" onChange="filterWithExisting()" class="custom-select2">
                        <option value="" selected>-- select type --</option>
                        <option value="fixed">Fixed</option>
                        <option value="percentage">Percentage</option>
                    </select>
                </div>
                <div>
                    <div id="daterange" class="d-flex align-items-center p-2 border rounded bg-white"
                        style="cursor: pointer; min-width: 355px;">
                        <i class="fa fa-calendar me-2"></i>
                        <span></span>
                        <i class="fa fa-caret-down ms-2"></i>
                    </div>
                    <input type="hidden" id="start_date_report" name="start_date" value="">
                    <input type="hidden" id="end_date_report" name="end_date" value="">
                </div>

                <div class="serchBar">
                    <input type="text" class="form-control form-control-sm" placeholder="Search ..."
                        onChange="filterWithExisting()">
                </div>
            </div>
        </div>

        <div id="table"> <x-coupon.table :coupons="$coupons" /></div>

    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(function() {
            var start = moment("{{ $startDate }}");
            var end = moment("{{ $endDate }}");

            $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#start_date_report').val(start.format('YYYY-MM-DD'));
            $('#end_date_report').val(end.format('YYYY-MM-DD'));

            $('#daterange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                        .endOf('year')
                    ]
                }
            }, function(start, end) {
                $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
                $('#start_date_report').val(start.format('YYYY-MM-DD'));
                $('#end_date_report').val(end.format('YYYY-MM-DD'));
                filterWithExisting();
            });

        });
        
        function filterWithExisting() {
            const startDate = $('#start_date_report').val();
            const endDate = $('#end_date_report').val();
            const discountType = $('#Status').val();
            const search = $('.serchBar input').val();

            let url = '{{ Request::url() }}?';
            if (startDate) url += `start_date=${startDate}&`;
            if (endDate) url += `end_date=${endDate}&`;
            if (discountType) url += `discount_type=${discountType}&`;
            if (search) url += `search=${search}`;

            AllScript.loadPage(url);
        }
    </script>

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
