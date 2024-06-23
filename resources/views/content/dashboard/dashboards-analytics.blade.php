@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection


@section('content')
    <div class="row gy-4">
        <!-- Transactions -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="min-date">Start Date:</label>
                            <input type="date" id="min-date" class="date-range-filter form-control" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-md-3">
            
                            <label for="max-date">End Date:</label>
                            <input type="date" id="max-date" class="date-range-filter form-control" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-md-3">
                           <br>
                            <button id="reset-filters" type="button" class="btn btn-sm btn-primary">
                                Reset
                            </button>
                        </div>
                    </div><br><hr>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Bitara Mart Transactions</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="filter" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical mdi-24px"></i>
                            </button>
                            {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                <a class="dropdown-item" onclick="getToday(1)" id="todayOption">Today</a>
                                <a class="dropdown-item" onclick="getToday(2)" id="monthOption">Month</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-primary rounded shadow">
                                        <i class="mdi mdi-currency-usd mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Sales</div>
                                    <h5 class="mb-0"><span id="sale_value"></span></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-success rounded shadow">
                                        <i class="mdi mdi-account-outline mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Order</div>
                                    <h5 class="mb-0"><span id="order_value"></span></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-warning rounded shadow">
                                        <i class="mdi mdi-truck-delivery mdi-24px"></i>

                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Delivery</div>
                                    <h5 class="mb-0"><span id="delivery_value"></span></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-info rounded shadow">
                                        <i class="mdi mdi-car-pickup mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Pickup</div>
                                    <h5 class="mb-0"><span id="pickup_value"></span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Transactions -->

        <!-- Total Earnings -->
        {{-- <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="dropdown">
                        <!-- <button class="btn p-0" type="button" id="totalEarnings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                                                      </button> -->
                        <!-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                                                        <a class="dropdown-item" href="#" id="todayOption">Today</a>
                                                                        <a class="dropdown-item" href="#" id="monthOption">Month</a>
                                                                      </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach ($products as $product)
                            <li class="d-flex mb-4 pb-md-2">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="{{ asset('assets/img/icons/misc/zipcar.png') }}" alt="zipcar"
                                        class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $product->product_name }}</h6>
                                        <h8 class="mb-0">{{ $product->category_description }}</h8>
                                    </div>
                                    <div>
                                        <h6 class="mb-2">{{ $product->total_stock }} kg</h6>
                                        <!-- <div class="progress bg-label-primary" style="height: 4px;">
                                                                              <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div> -->
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Order Trends</h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="filter" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical mdi-24px"></i>
                            </button>
                            {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                <a class="dropdown-item" onclick="getChart(1)" id="todayOption">Today</a>
                                <a class="dropdown-item" onclick="getChart(2)" id="monthOption">Month</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                            <p class="highcharts-description">

                            </p>
                        </figure>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        $(document).ready(function() {
            getToday()
            getChart()
        });

        $('#min-date, #max-date').on('change', function() {
            getToday();
            getChart();
    });

    $('#reset-filters').on('click', function() {
            $('#min-date').val('');
            $('#max-date').val(''); getToday();
            getChart();
        });
        function getToday(filterid) // 1-today, 2-month
        {
            var min_date = $('#min-date').val();
            var max_date = $('#max-date').val();

            $.ajax({
                type: "GET",
                url: "{{ route('data-dashboard') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    min: min_date,
                    max: max_date,
                },
                success: function(response) {
                    console.log(response);
                    $('#sale_value').text('RM' + response.sale);
                    $('#order_value').text(response.order);
                    $('#delivery_value').text(response.delivery);
                    $('#pickup_value').text(response.pickup);
                }
            });
        }

        function getChart(filterid) // 1-today, 2-month
        {

            var min_date = $('#min-date').val();
            var max_date = $('#max-date').val();

            $.ajax({
                type: "GET",
                url: "{{ route('data-trend-dashboard') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    min: min_date,
                    max: max_date,
                },
                success: function(response) {
                    var array = [];
                    response.category.forEach(element => {
                        array.push(response[element])
                    });

                    console.log(array);

                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Total orders per category',
                            align: 'left'
                        },
                       
                        xAxis: {
                            categories: response.category,
                            crosshair: true,
                            accessibility: {
                                description: 'Categories'
                            }
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                name: 'Category',
                                data: array
                            },

                        ]
                    });
                }
            });
        }
    </script>
@endsection
