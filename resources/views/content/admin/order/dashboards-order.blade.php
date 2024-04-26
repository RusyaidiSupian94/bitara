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
                                        <th>Delivery Method</th>
                                        <th>Total</th>
                                        <th>Process</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($new_orders as $n_order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $n_order->customer_name }}</td>
                                            <td>{{ date('d-m-Y h:i a', strtotime($n_order->order->date)) }}</td>
                                            <td>
                                                @if ($n_order->delivery_method == 1)
                                                    Pickup
                                                @else
                                                    Delivery
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $n_order->payment_amount }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="{{ route('process-order', ['id' => $n_order->order_id]) }}"
                                                        class="btn btn-sm btn-success">Process Order</a>
                                                    {{-- @if ($n_order->fullfillment_status == 'F')
                                                        <a href="{{ route('prepare-order', ['id' => $n_order->id]) }}"
                                                            class="btn btn-sm btn-success">Prepare Order</a>
                                                    @endif
                                                    <a href="{{ route('cancel-order', ['id' => $n_order->id]) }}"
                                                        class="btn btn-sm btn-danger">Cancel</a> --}}
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
                                        <th>Customer Contact</th>
                                        <th>Customer Address</th>
                                        <th>Order Date</th>
                                        <th>Order Details</th>
                                        <th>Delivery Method</th>
                                        <th>Total</th>
                                        <th>Current Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->customer_contact }}</td>
                                            <td>{{ $order->customer_address }}
                                            </td>
                                            <td>{{ date('d-m-Y h:i a', strtotime($order->order->date)) }}</td>
                                            <td class="text-center">
                                                <a onclick="displayOrderDetails({{ $order->order_id }});"
                                                    class="btnbtn-sm btn-text-danger">
                                                    <i
                                                        class="mdi mdi-information-slab-circle-outline mdi-24px text-info"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if ($order->delivery_method == 1)
                                                    Pickup
                                                @elseif($order->delivery_method == 2)
                                                    Delivery
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $order->payment_amount }}</td>
                                            @if ($order->order->order_status == 'P')
                                                <td><span class="badge rounded-pill bg-label-warning me-1">Preparing
                                                        Order</span>
                                                </td>

                                                <td>
                                                    <div class="dropdown">
                                                        <a href="{{ route('ready-order', ['id' => $order->order_id]) }}"
                                                            class="btn btn-sm btn-info">Order Ready</a>
                                                    </div>
                                                </td>
                                            @elseif ($order->order->order_status == 'R')
                                                @if ($order->delivery_method == 1)
                                                    <td><span class="badge rounded-pill bg-label-warning me-1">Order is
                                                            ready to pickup</span>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="{{ route('complete-order', ['id' => $order->order_id,'page' => 'A']) }}"
                                                                class="btn btn-sm btn-success">Complete</a>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td><span class="badge rounded-pill bg-label-warning me-1">Order is
                                                            ready to deliver</span>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="{{ route('deliver-order', ['id' => $order->order_id]) }}"
                                                                class="btn btn-sm btn-primary">Delivery</a>
                                                        </div>
                                                    </td>
                                                @endif
                                            @elseif ($order->order->order_status == 'D')
                                                <td><span class="badge rounded-pill bg-label-info me-1">Out for delivery</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="{{ route('complete-order', ['id' => $order->order_id,'page' => 'A']) }}"
                                                            class="btn btn-sm btn-success">Complete</a>
                                                    </div>
                                                </td>
                                            @elseif ($order->order->order_status == 'C')
                                                <td><span class="badge rounded-pill bg-label-success me-1">Completed</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a target="_blank"
                                                            href="{{ route('complete-order-detail', ['id' => $order->order_id, 'page' => 'o']) }}">
                                                            <button id="completeModal" type="button"
                                                                class="btn btn-sm btn-secondary">
                                                                Details
                                                            </button></a>
                                                    </div>
                                                </td>
                                            @endif
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

    <!--Completed Modal -->
    <div class="modal modal-lg fade" id="completedOrderDetailsModal" tabindex="-1"
        aria-labelledby="completedOrderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completedOrderDetailsModalLabel">Order Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Order Id: </th>
                                <th scope="col" colspan="3"><span id="order_id"></span></th>
                            </tr>
                            <tr>
                                <th scope="col">#Transaction Id: </th>
                                <th scope="col"><span id="transaction_id"></span></th>
                                <th scope="col">Payment Method: </th>
                                <th scope="col"><span id="payment_method"></span></th>
                            </tr>
                            <tr>
                                <th scope="col">Customer Name: </th>
                                <th scope="col" colspan="3"><span id="customer_name"></span></th>
                            </tr>
                            <tr>
                                <th scope="col">Customer Address: </th>
                                <th scope="col" colspan="3"><span id="customer_address"></span></th>
                            </tr>
                            <tr>
                                <th scope="col">Order timestamp: </th>
                                <th scope="col"><span id="order_timestamp"></span></th>
                                <th scope="col">Preparing timestamp: </th>
                                <th scope="col"><span id="preparing_timestamp"></span></th>
                            </tr>
                            <tr>
                                <th scope="col">Delivering timestamp: </th>
                                <th scope="col"><span id="delivering_timestamp"></span></th>
                                <th scope="col">Completed timestamp: </th>
                                <th scope="col"><span id="completed_timestamp"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4"> </td>
                            </tr>
                            <tr>
                                <td colspan="2"> Item</td>
                                <td> Total Amount</td>
                                <td> <span id="total_amount"></span></td>
                            </tr>
                            <tr id="item"></tr>
                        </tbody>
                    </table>
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
            $('#completeModal').click(function() {
                var orderId = $(this).data('id');
                $.ajax({
                    url: "{{ route('complete-order-detail') }}", // Replace with your route to fetch data
                    type: 'GET',
                    data: {
                        id: orderId,
                    },
                    success: function(response) {
                        // Populate modal with data
                        $('#order_id').text(response.id);
                        $('#transaction_id').text('unapplicable');
                        $('#payment_method').text('unapplicable');
                        $('#customer_name').text(response.customer.user_details.fname + ' ' +
                            response
                            .customer.user_details.lname);
                        $('#customer_address').text(response.customer.user_details.address_1 +
                            ' ' +
                            response.customer.user_details.address_2);
                        $('#order_timestamp').text(response.updated_at);
                        $('#preparing_timestamp').text(response.preparing_at);
                        $('#delivering_timestamp').text(response.delivering_at);
                        $('#completed_timestamp').text(response.completed_at);
                        $('#total_amount').text(response.total_amount);

                        var $tr = $('#item');
                        $tr.empty();
                        $.each(response.details, function(index, data) {
                            $tr.append('<td>' + ++index + '</td><td>' + data.product
                                .product_name +
                                '</td><td>' + data.product_qty + '</td> <td>' + data
                                .sub_total + '</td>');
                        });

                    },
                    error: function(xhr) {
                        // Handle error
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });


        function displayOrderDetails(order_id) {
            $('#orderDetailsTbl').DataTable().destroy();
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
