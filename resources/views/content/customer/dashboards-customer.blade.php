@php
$isMenu = false;
$navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('content')
<div class="card w-100 h-100">
    <div class="row gy-4 p-4">
        <div class="col-12">
            <div class="row gy-4">
                <!-- Product List from database -->
                @foreach ($products as $product)
                <div class="col-sm-3">
                    <div class="card h-100">

                        <div class="card-body">
                            <img src="{{ url('/storage/product/' . $product->product_img) }}" class="card-img-top image-fluid" alt="...">
                            {{-- <div class="d-flex flex-wrap align-items-end justify-content-end mb-2 pb-1"> --}}
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <h6 class="text-start mb-0 pt-2">{{ $product->product_name }}</h6>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h6 class="text-end mb-0 pt-2">RM{{ $product->unit_price }} / <small class="text-success mt-1">piece</small></h6>
                                </div>
                            </div>
                            <div class="py-2">
                                <small>{{ $product->product_details }}</small>
                            </div>
                            <div class="row pt-3">
                                <div class="col-12 col-md-8">
                                    <div class="input-group input-group-sm mb-3">
                                        <button class="btn btn-outline-secondary button-minus" type="button" data-id="{{$product->id}}"><i class="mdi mdi-minus mdi-24px"></i></button>
                                        <input id="qty{{$product->id}}" type="number" class="form-control" value="0">
                                        <button class="btn btn-outline-secondary button-plus" type="button" data-id="{{$product->id}}"><i class="mdi mdi-plus mdi-24px"></i></button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    <!-- <button class="btn p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                        <i class="mdi mdi-cart mdi-24px"></i></button> -->
                                    <a onclick="addToCard({{ $product->id }});" class="btnbtn-sm btn-text-danger">
                                        <i class="mdi mdi-information-slab-circle-outline mdi-24px text-info"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Cart</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table id="cartTbl" class="table table-bordered">
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
        $('.button-minus').click(function() {
            var productId = $(this).data('id');
            var input = $('#qty' + productId);
            console.log(input);
            var qty = parseInt($(input).val());
            if (qty > 0) {
                $(input).val(qty - 1);
            }
        });

        // Event handler for plus button
        $('.button-plus').click(function() {
            var productId = $(this).data('id');
            var input = $('#qty' + productId);
            console.log(input);
            var qty = parseInt($(input).val());
            $(input).val(qty + 1);
        });
    });

    function addToCart(id) {
        var qty = $('#qty' + productId).val();
        var orderTbl = $('#cartTbl').DataTable({
            'processing': true,
            'ajax': {
                'url': "{{ route('datatable-add-cart') }}",
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

            ],
        });

        $("#orderDetailModal").modal("show");
    }
</script>
@endsection