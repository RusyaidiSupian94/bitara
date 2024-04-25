@extends('layouts/contentNavbarLayout')

@section('title', ' Add - Forms')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Orders/</span> Add Manual Order</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manual Ordering</h5> <small class="text-muted float-end">BITARA MART</small>
                </div>
                <div class="card-body">

                    <form id="addOrderForm" class="mb-3" action="{{ route('store-order') }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="date" class="form-control" id="order_date" name="order_date"
                                value="{{ now()->toDateString() }}" autofocus required />
                            <label for="order_date">Order Date</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-4">
                            <select onchange="getProduct(this)" class="form-select" id="category" name="category" autofocus
                                required>
                                <option selected disabled>Choose..</option>
                                @foreach ($category as $ctgy)
                                    <option value="{{ $ctgy->id }}">{{ $ctgy->category_description }}</option>
                                @endforeach
                            </select>
                            <label for="category">Product Category</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="product" name="product" autofocus required>
                                <option selected disabled>Choose..</option>

                            </select>
                            <label for="product_name">Product </label>
                        </div>
                        <div class="text-end">
                            <button id="addManualOrder" type="button" class="btn btn-sm btn-success">Add Product</button>
                        </div>
                        <div class="p-2">

                            <table id="productTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Weight</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Product details will be appended here -->
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" id="saveButton" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


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
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });

            var i = 0;
            $('#addManualOrder').click(function() {
                ++i;
                var productId = $('#product').val();
                var productName = $('#product option:selected').text();
                var weights = [{
                        id: 1,
                        value: '1kg'
                    },
                    {
                        id: 2,
                        value: '250g'
                    },
                    {
                        id: 3,
                        value: '500g'
                    }
                ];
                if (!productId) {
                    // Handle case where no product is selected
                    return;
                }

                var weightDropdown = '<select class="form-select weight-dropdown" name="product_list[' +
                    i + '][weight]" >';
                weights.forEach(function(weight) {
                    weightDropdown += '<option value="' + weight.id + '">' + weight.value +
                        '</option>';
                });
                weightDropdown += '</select>';

                // Append row to the table
                $('#productTable tbody').append('<tr>' +
                    '<td><input name="product_list[' + i + '][id] type="text" value="' + productId +
                    '" class="form-control total-input" hidden />' + productId + '</td>' +
                    '<td>' + productName + '</td>' +
                    '<td>' + weightDropdown + '</td>' +
                    '<td><input name="product_list[' + i +
                    '][qty] type="number" class="form-control total-input" /></td>' +
                    '<td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>' +
                    '</tr>'
                );
            });
        });

        function getProduct(e) {
            var id = $(e).val();
            $.ajax({
                type: "GET",
                url: "{{ route('list-product') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    category_id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#product').empty();


                    // Append options for each product
                    $.each(response, function(index, product) {
                        $('#product').append($('<option>', {
                            value: product.id,
                            text: product.product_name
                        }));
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(error, '', 'error');
                }
            });
        }
    </script>
@endsection
