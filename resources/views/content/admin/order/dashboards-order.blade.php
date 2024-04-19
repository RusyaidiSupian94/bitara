@extends('layouts/contentNavbarLayout')

@section('title', 'Orders')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card w-100 h-100">
                <h4 class="p-3 mb-4"><span class="text-muted fw-light">Orders /</span> Dashboard
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
                        <h6>New Order</h6>
                        <div class="table-responsive text-nowrap">
                            <table id="productTbl" class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>Order Date</th>
                                        <th>Fulfillment</th>
                                        <th>Order Details</th>
                                        <th>Payment Details</th>
                                        <th>Total</th>
                                        <th>Process</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->customer->user_details->fname }}</td>
                                            <td>{{ date('d-m-Y h:i a', strtotime($order->date)) }}</td>

                                            @if ($order->fullfillment_status == 'U')
                                                <td><span
                                                        class="badge rounded-pill bg-label-danger me-1">Unfulfillment</span>
                                                </td>
                                            @else
                                                <td><span
                                                        class="badge rounded-pill bg-label-success me-1">Fulfillment</span>
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                <a onclick="displayOrderDetails({{ $order->id }});"
                                                    class="btn
                                                        btn-sm btn-text-danger">
                                                    <i
                                                        class="mdi mdi-information-slab-circle-outline mdi-24px text-info"></i></a>
                                                <!-- Button trigger modal -->
                                                {{-- <button type="button" class="btn " data-bs-toggle="modal"
                                                    data-bs-target="#orderDetailModal">
                                                    <i
                                                        class="mdi mdi-information-slab-circle-outline mdi-24px text-info"></i>
                                                </button> --}}
                                            </td>
                                            <td class="text-center"> <button type="button" class="btn "
                                                    data-bs-toggle="modal" data-bs-target="#paymentDetailModal">
                                                    <i
                                                        class="mdi mdi-information-slab-circle-outline mdi-24px text-info"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">{{ $order->total_amount }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="{{ route('prepare-order', ['id' => $order->id]) }}"
                                                        class="btn btn-sm btn-success">Prepare Order</a>
                                                    <a href="{{ route('cancel-order', ['id' => $order->id]) }}"
                                                        class="btn btn-sm btn-danger">Cancel</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="p-2 pt-5">
                        <h6>Process Order</h6>
                        <div class="table-responsive text-nowrap">
                            <table id="productTbl" class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>Customer Address</th>
                                        <th>Order Date</th>
                                        <th>Order Details</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
                                                <a onclick="displayOrderDetails({{ $order->id }});"
                                                    class="btnbtn-sm btn-text-danger">
                                                    <i class="mdi mdi-information-slab-circle-outline mdi-24px text-info"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $order->total_amount }}</td>
                                            <td><span class="badge rounded-pill bg-label-warning me-1">Preparing</span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="{{ route('edit-product', ['id' => $order->id]) }}"
                                                        class="btn btn-sm btn-info">Delivery</a>
                                                    <a href="{{ route('edit-product', ['id' => $order->id]) }}"
                                                        class="btn btn-sm btn-secondary">Reschedule</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Order Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Order Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table id="orderDetailsTbl" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--Payment Modal -->
    <div class="modal fade" id="paymentDetailModal" tabindex="-1" aria-labelledby="paymentDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentDetailModalLabel">Payment Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

@endsection
<!-- Include SweetAlert CSS -->

<!-- Include SweetAlert JavaScript -->

@section('page-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#productTbl').DataTable();
        });


        function displayOrderDetails(order_id) {
            var orderTbl = $('#orderDetailsTbl').DataTable({
                'processing': true,
                'ajax': {
                    'url': "{{ route('datatable-order') }}",
                    'dataType': 'json',
                    'type': 'GET',
                    'data': {
                        id: order_id,

                    }
                },

                'columns': [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'product_name'
                    },
                    {
                        data: 'quantity'
                    },
                    {
                        data: 'sub_total'
                    }
                ],
            });

            $("#orderDetailModal").modal("show");
        }
    </script>
@endsection
