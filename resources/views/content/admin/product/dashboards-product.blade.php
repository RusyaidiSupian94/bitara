@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card w-100 h-100">
                <h4 class="p-3 mb-4"><span class="text-muted fw-light">Products /</span> Dashboard
                </h4>

                <div class="card m-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>List of products</h5>
                            </div>
                            <div class="col-6">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('add-product') }}">
                                        <button type="button" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i>
                                            Add Product</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

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

                        <div class="table-responsive">
                            <table id="productTbl" class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>Product Name</th>
                                        <th>Product Details</th>
                                        <th>Cost</th>
                                        <th>Unit Price</th>
                                        <th>Stock</th>
                                        <th>Weight</th>
                                        <th>Product Img</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->category->category_description }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->product_details }}</td>
                                            <td class="text-center">{{ $product->cost_price }}</td>
                                            <td class="text-center">{{ $product->unit_price }}</td>
                                            <td class="text-center">{{ $product->total_stock }}</td>
                                            <td class="text-center">
                                                {{ $product->weight->description }}</td>
                                            <td class="text-center">
                                                <ul
                                                    class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-md pull-up"
                                                        title="{{ $product->product_img }}">
                                                        <img src="{{ url('/storage/product/' . $product->product_img) }}"
                                                            alt="item" class="rounded-circle">
                                                    </li>

                                                </ul>
                                            </td>
                                            <td>
                                                <div class="dropdown">


                                                    <a href="{{ route('edit-product', ['id' => $product->id]) }}"
                                                        class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i
                                                            class="mdi mdi-pencil-outline"></i></a>
                                                    <a onclick="deleteProduct({{ $product->id }});"
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
            $('#productTbl').DataTable();
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
