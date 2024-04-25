@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection



@section('content')

<div class="row">
    <div class="col-12">
        <div class="card w-100 h-100">
            <h4 class="p-3 mb-4"><span class="text-muted fw-light">Reporting /</span> Dashboard
            </h4>

            <div class="card m-3">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="p-2">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Main</button>
                        </li> -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active " id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab-pane" aria-selected="true">Ordering</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="product-tab" data-bs-toggle="tab"
                                    data-bs-target="#product-tab-pane" type="button" role="tab"
                                    aria-controls="product-tab-pane" aria-selected="false">Product</button>
                            </li> -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pnl-tab" data-bs-toggle="tab" data-bs-target="#pnl-tab-pane" type="button" role="tab" aria-controls="pnl-tab-pane" aria-selected="false">Sales</button>
                        </li>
                    </ul>


                    <div class="tab-content" id="myTabContent">
                        <!-- Main -->
                        <!-- <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="row gy-4">
                                <div class="col-12">
                                    <div class="card h-100">
                                        <div class="card-header pb-0">
                                            <h4 class="mb-0">RM86.4k</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="totalProfitLineChart" class="mb-3"></div>
                                            <h6 class="text-center mb-0">Total Profit</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- End Main -->
                        <!-- Ordering -->
                        <div class="tab-pane fade show active" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab" tabindex="0">
                            <table id="orderTbl" class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>Customer Address</th>
                                        <th>Order Date</th>
                                        <th>Delivery Method</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->customer->user_details->fname }}</td>
                                        <td>{{ $order->customer->user_details->address_1 . ' ' . $order->customer->user_details->address_2 }}
                                        </td>
                                        <td>{{ date('d-m-Y h:i a', strtotime($order->date)) }}</td>
                                        <td class="text-center">
                                            @if ($order->delivery_method == 1)
                                            Delivery
                                            @elseif($order->delivery_method == 2)
                                            Pickup
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $order->total_amount }}</td>
                                        @if ($order->order_status == 'N')
                                        <td><span class="badge rounded-pill bg-label-info me-1">New Order</span>
                                        </td>
                                        @elseif ($order->order_status == 'P')
                                        <td><span class="badge rounded-pill bg-label-warning me-1">Preparing</span>
                                        </td>
                                        @elseif ($order->order_status == 'D')
                                        <td><span class="badge rounded-pill bg-label-info me-1">Delivering</span>
                                        </td>
                                        @elseif ($order->order_status == 'C')
                                        <td><span class="badge rounded-pill bg-label-success me-1">Completed</span>
                                        </td>
                                        @endif
                                        <td>
                                            <div class="dropdown">
                                                <a target="_blank" href="{{ route('complete-order-detail', ['id' => $order->id,'page' => 'r']) }}">
                                                    <button id="completeModal" type="button" class="btn btn-sm btn-success">
                                                        Details
                                                    </button></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Ordering -->
                        <!-- <div class="tab-pane fade" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
                                tabindex="0">
                                <div class="table-responsive text-nowrap">
                                    <div class="table-responsive text-nowrap">
                                        <table id="productTbl" class="table table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Product Name</th>
                                                    <th>Product Details</th>
                                                    <th>Category</th>
                                                    <th>Cost</th>
                                                    <th>Unit Price</th>
                                                    <th>Stock</th>
                                                    <th>UOM</th>
                                                    <th>Product Img</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->product_details }}</td>
                                                        <td>{{ $product->category_id }}</td>
                                                        <td class="text-end">{{ $product->cost_price }}</td>
                                                        <td class="text-end">{{ $product->unit_price }}</td>
                                                        <td class="text-center">{{ $product->total_stock }}</td>
                                                        <td class="text-center">{{ $product->uom_id }}</td>
                                                        <td class="text-center">
                                                            <ul
                                                                class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                    data-bs-placement="top"
                                                                    class="avatar avatar-md pull-up"
                                                                    title="{{ $product->product_img }}">
                                                                    <img src="{{ url('/storage/product/' . $product->product_img) }}"
                                                                        alt="item" class="rounded-circle">
                                                                </li>

                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> -->

                        <!-- Pnl -->
                        <div class="tab-pane fade" id="pnl-tab-pane" role="tabpanel" aria-labelledby="pnl-tab" tabindex="0">
                            <div class="table-responsive text-nowrap">
                                <div class="table-responsive text-nowrap">
                                    <table id="productTbl" class="table table-sm w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Product Name</th>
                                                <th>Sell Price</th>
                                                <th>Stock Quantity</th>
                                                <th>Sell Quantity</th>
                                                <th>Total Sell</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($array as $pnlData)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pnlData['product_name'] }}</td>
                                                <td class="text-center">RM{{ $pnlData['sell_price'] }}</td>
                                                <td class="text-center">{{ $pnlData['stock_qty'] }}</td>
                                                <td class="text-center">{{ $pnlData['sell_product_qty'] }}</td>
                                                <td class="text-center">RM{{ $pnlData['total_sell'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End PNL -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Include SweetAlert CSS -->

<!-- Include SweetAlert JavaScript -->

@section('page-style')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css" />


@endsection
@section('page-script')
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>







<script>
    $(document).ready(function() {
        $('#productTbl').DataTable({
            dom: '<"top"B>rt<"bottom"lp><"clear">',
            buttons: ['excel']
        });


        $('#orderTbl').DataTable({
            dom: '<"top"B>rt<"bottom"lp><"clear">',
            buttons: ['excel']
        });
    });


    function deleteProduct(id) {
        Swal.fire({
            title: 'Confirm to delete the selected product?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-product') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        product_id: id
                    },
                    success: function(response) {

                        location.reload();

                    },
                    error: function(xhr, status, error) {
                        Swal.fire(error, '', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection