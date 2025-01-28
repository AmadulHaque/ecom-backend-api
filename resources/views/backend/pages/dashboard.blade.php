@extends('backend.app')

@section('content')
<style>
.col-3 {
    flex: 0 0 auto;
    width: 24%;
}
</style>

<div class="dashboard-summary mt-3">
    <form id="dateForm" action="{{ route('admin.dashboard') }}" method="GET">
        <div class="row mb-3">
            <div class="col-9"> </div>
            <div class="col-6 col-md-3">
                <div id="daterange" class="d-flex align-items-center p-2 border rounded bg-white"
                    style="cursor: pointer; min-width: 355px;">
                    <i class="fa fa-calendar me-2"></i>
                    <span></span>
                    <i class="fa fa-caret-down ms-2"></i>
                </div>
                <input type="hidden" id="start_date_report" name="start_date" value="">
                <input type="hidden" id="end_date_report" name="end_date" value="">
            </div>
        </div>
    </form>
    @permission('cards')
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon mb-2">
                            <i class="fa-brands fa-product-hunt fa-2xl" style="color: #00B795;"></i>
                        </div>
                        <div class="card-body-text d-flex gap-4">
                            <div class="prettyCash d-flex flex-column gap-1">
                                <h6 class="card-title fw-400">Total Product</h6>
                                <h5 class="card-text fw-600">{{ $statistics['total_products'] }}</h5>
                            </div>| <div class="prettyCash d-flex flex-column gap-1">
                                <h6 class="card-title fw-400">Request Pending</h6>
                                <h5 class="card-text fw-600">{{ $statistics['pending_products']}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon mb-2">
                            <i class="fa-solid fa-shop fa-2xl" style="color: #00B795;"></i>
                        </div>
                        <div class="card-body-text d-flex gap-4">
                            <div class="prettyCash d-flex flex-column gap-1">
                                <h6 class="card-title fw-400">Total Shop</h6>
                                <h5 class="card-text fw-600">{{ $statistics['active_shops'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon mb-2">
                            <i class="fa-solid fa-users fa-2xl" style="color: #00B795;"></i>
                        </div>
                        <div class="card-body-text d-flex gap-4">
                            <div class="prettyCash d-flex flex-column gap-1">
                                <h6 class="card-title fw-400">Total Customer</h6>
                                <h5 class="card-text fw-600">{{ $statistics['total_customers'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon mb-2">
                            <i class="fa-solid fa-cart-arrow-down fa-2xl" style="color: #00B795;"></i>
                        </div>
                        <div class="card-body-text d-flex gap-4">
                            <div class="prettyCash d-flex flex-column gap-1">
                                <h6 class="card-title fw-400">Total Order</h6>
                                <h5 class="card-text fw-600">{{ $statistics['total_orders'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpermission


</div>
<div class="row mt-4">
    @permission('chart')
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div id="customer-order-chart"></div>
                </div>
            </div>
        </div>
    @endpermission
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

        function cb(start, end) {
            $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#start_date_report').val(start.format('YYYY-MM-DD'));
            $('#end_date_report').val(end.format('YYYY-MM-DD'));
            $('#dateForm').submit();
        }

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
            }, cb);
    });
    </script>

<script>
    
var options = {
    series: [{
        name: 'Customers',
        type: 'line',
        data: @json($chartData['customers'])
    }, {
        name: 'Orders',
        type: 'line',
        data: @json($chartData['orders'])
    }],
    chart: {
        height: 350,
        type: 'line',
        stacked: false,
    },
    xaxis: {
        categories: @json($chartData['dates']), // Pass the dates
        type: 'datetime',
    },
    yaxis: {
        title: {
            text: 'Count',
        }
    },
    tooltip: {
        shared: true,
        intersect: false,
    }
};
var chart = new ApexCharts(document.querySelector("#customer-order-chart"), options);
chart.render();
</script>
@endpush