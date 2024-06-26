@extends('layouts/contentNavbarLayout')

@section('title', 'Orders')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card w-100 h-100">
                <h4 class="p-3 mb-4"><span class="text-muted fw-light">Manual Ordering /</span> Dashboard
                </h4>

                <div class="card m-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>List of orders</h5>
                            </div>
                            <div class="col-6">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('add-order') }}">
                                        <button type="button" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i>
                                            Add Manual Order Record</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 pt-5">
                        <h6>Manual Order</h6>
                        <div class="table-responsive text-nowrap">
                            <table id="productTbl" class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Staff Name</th>
                                        <th>Order Date</th>
                                        <th>Order Details</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->created_by ?? '' }}</td>
                                            <td>{{ date('d-m-Y h:i a', strtotime($order->date)) }}</td>
                                            <td class="text-center">
                                                <a onclick="displayOrderDetails({{ $order->id }});"
                                                    class="btnbtn-sm btn-text-danger">
                                                    <i
                                                        class="mdi mdi-information-slab-circle-outline mdi-24px text-info"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $order->total_amount }}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('edit-order', ['id' => $order->id]) }}"
                                                        class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i
                                                            class="mdi mdi-pencil-outline"></i></a>
                                                    <a onclick="deleteOrder({{ $order->id }});"
                                                        class="btn
                                                        btn-sm btn-text-danger rounded-pill btn-icon item-delete"><i
                                                            class="mdi mdi-trash-can-outline text-danger"></i></a>
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
    <div class="modal modal-lg fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel"
        aria-hidden="true">
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
                                            <th>Weight</th>
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
                        data: 'weight'
                    },
                    {
                        data: 'sub_total'
                    }
                ],
            });

            $("#orderDetailModal").modal("show");
        }

        function deleteOrder(id) {
            Swal.fire({
                title: 'Confirm to delete the selected orders?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('delete-order') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            order_id: id
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
