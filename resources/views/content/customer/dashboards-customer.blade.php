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
<input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
<div class="card w-100 h-100">
    <div class="row gy-4 p-4">
        <div class="col-12">
            <div class="row gy-4 ">
                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="mdi mdi-cart mdi-24px"></i></button>
                </div>
            </div>
            <br>
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
                                    <a onclick="addToCart({{ $product->id }});" class="btnbtn-sm btn-text-danger">
                                        <i class="mdi mdi-cart mdi-24px"></i>
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
                    @if($totalCart>0)
                    @foreach ($order as $cartorder)
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ url('/storage/product/' . $cartorder->product->product_img) }}" class="card-img-top image-fluid" alt="...">
                                {{-- <div class="d-flex flex-wrap align-items-end justify-content-end mb-2 pb-1"> --}}
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Product : {{ $cartorder->product->product_name }}</h5>
                                    <p class="card-text">Quantity : {{ $cartorder->product_qty }}</p>
                                    <p class="card-text">Total : {{ $cartorder->sub_total }}</p>
                                    <button onclick="removeToCart({{ $cartorder->id }});" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Amount : {{$cartorder->order->total_amount ?? 0}}</h5>
                                    <a href="{{ route('checkout',['id' => $cartorder->order->id]) }}" class="btn btn-success">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <p>Cart is empty</p>
                @endif
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
        var item = {{$totalCart}};
        if(item > 0){
            $('#offcanvasRight').offcanvas('show');
        }
        
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

    function addToCart(product_id) {
        var qty = $('#qty' + product_id).val();
        var userid = $('#user_id').val();

        $.ajax({
            type: "POST",
            url: "{{ route('cart-datatable') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: product_id,
                qty: qty,
                userid: userid,
            },
            success: function(response) {
                location.reload();
            }
        });
    }

    function removeToCart(product_id) {
        var userid = $('#user_id').val();
        $.ajax({
            type: "POST",
            url: "{{ route('cart-remove') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: product_id,
                userid: userid,
            }

        });
    }
</script>
@endsection