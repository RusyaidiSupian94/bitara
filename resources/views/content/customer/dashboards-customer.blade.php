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
    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
    <div>
        <img src="{{ asset('assets/img/backgrounds/banner.jpg') }}" width="100%" height="15%" style="object-fit: cover"
            alt="Banner Image">
    </div>

    <!-- Add banner image here -->

    <div class="card w-100 h-100">
        <div class="row gy-4 p-4">
            <div class="col-12">
                <div class="row gy-4 ">
                    <div id="All" class="col-md-3 card shadow-none mb-3">
                        <button id="buttonall" type="button" class="btn btn-success filter-button" data-value="all">
                            All
                        </button>
                    </div>
                    @foreach ($category as $ctgy)
                        <div class="col-md-3 card shadow-none mb-3">
                            <button id="button{{ $ctgy->category_description }}" type="button"
                                class="btn btn-success filter-button" data-value="{{ $ctgy->category_description }}">
                                {{ $ctgy->category_description }}
                            </button>
                        </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn p-0 px-3" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRightPayment" aria-controls="offcanvasRightPayment">
                            <i class="mdi mdi-package-check mdi-24px"></i>
                        </button>
                        <button class="btn p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                            aria-controls="offcanvasRight">
                            <i class="mdi mdi-cart mdi-24px"></i>
                        </button>
                    </div>

                </div>

                <br>
                <div class="row gy-4">
                    <!-- Product List from database -->
                    <div class="container">
                        <div class="row">
                            @php $currentCategory = null; @endphp
                            @foreach ($products as $product)
                                @if ($currentCategory != $product->category->category_description)
                                    @if ($currentCategory !== null)
                        </div><!-- Close the previous row -->
                        @endif
                        <div class="row"><!-- Start a new row -->
                            <div class="col-12">
                                <div
                                    class="pt-2 category-heading card-container {{ $product->category->category_description }}">
                                    <h3>{{ $product->category->category_description }}</h3> <!-- Display category name -->
                                    <hr> <!-- Add horizontal rule -->
                                </div>
                            </div>
                            @endif
                            @php $currentCategory = $product->category->category_description; @endphp

                            <div class="col-sm-4 col-md-3 py-2">
                                <div class="card  h-100 card-container {{ $product->category->category_description }}">
                                    <div class="card-body h-75">
                                        <img height="250" src="{{ url('/storage/product/' . $product->product_img) }}"
                                            class="card-img-top image-fluid" alt="...">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <h6 class="text-start mb-0 pt-2">{{ $product->product_name }}</h6>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h6 class="text-end mb-0 pt-2">RM{{ $product->unit_price }} / <small
                                                        class="text-success mt-1">{{ $product->weight->description }}</small>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="py-2">
                                            <small>{{ $product->product_details }}</small>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row pt-3">
                                            <div class="col-12 col-md-8 d-flex justify-end">
                                                <div class="input-radio"><input type="radio" id="250g{{ $product->id }}" name="size" value="250g" checked> <label for="250g{{ $product->id }}">250g</label></div>
                                                <div class="input-radio"><input type="radio" id="500g{{ $product->id }}" name="size" value="500g"> <label for="500g{{ $product->id }}">500g</label></div>
                                                <div class="input-radio"><input type="radio" id="1kg{{ $product->id }}" name="size"  value="1kg"> <label for="1kg{{ $product->id }}">1kg</label></div>
                                            </div>
                                        </div>
                                        <div class="row pt-3">
                                            <div class="col-12 col-md-8">
                                                <div class="input-group input-group-sm mb-3">
                                                    <button class="btn btn-outline-secondary button-minus" type="button"
                                                        data-id="{{ $product->id }}"><i
                                                            class="mdi mdi-minus mdi-24px"></i></button>
                                                    <input id="qty{{ $product->id }}" type="number" class="form-control"
                                                        value="0">
                                                    <button class="btn btn-outline-secondary button-plus" type="button"
                                                        data-id="{{ $product->id }}"><i
                                                            class="mdi mdi-plus mdi-24px"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 text-end">
                                                <a onclick="addToCart({{ $product->id }});"
                                                    class="btnbtn-sm btn-text-danger">
                                                    <i class="mdi mdi-cart mdi-24px"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if ($currentCategory !== null)
                        </div><!-- Close the last row -->
                        @endif
                    </div>
                </div>

            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Cart</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @if ($cart->count() > 0)
                        @foreach ($cart as $cartorder)
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ url('/storage/product/' . $cartorder->product->product_img) }}"
                                            class="card-img-top image-fluid" alt="...">
                                        {{-- <div class="d-flex flex-wrap align-items-end justify-content-end mb-2 pb-1"> --}}
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Product : {{ $cartorder->product->product_name }}
                                            </h5>
                                            <p class="card-text">Quantity : {{ $cartorder->product_qty }} x {{$cartorder->weight->description}}</p>
                                            <p class="card-text">Unit Price : RM {{ $cartorder->product->unit_price }}</p>
                                            <p class="card-text">Sub Total : RM {{ $cartorder->sub_total }}</p>
                                            <button onclick="removeToCart({{ $cartorder->id }});"
                                                class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Amount
                                            :{{ number_format($cart->sum('sub_total') ?? 0, 2) }}</h5>
                                        <a href="{{ route('add-payment') }}" class="btn btn-success">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Cart is empty</p>
                    @endif
                </div>
            </div>


            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightPayment"
                aria-labelledby="offcanvasRightPaymentLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightPaymentLabel">Order List</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @foreach ($order_paid as $op)
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">

                                <div class="col-md-12">
                                    <div class="card-body">
                                        <h6>Order Id: {{ $op->id }}</h6>
                                        @foreach ($op->details as $opd)
                                            {{-- <h5 class="card-title">Product : {{ $opd->product_name }}
                                            </h5>
                                            <p class="card-text">Quantity : {{ $opd->product_qty }}</p>
                                            <p class="card-text">Total : {{ $opd->sub_total }}</p> --}}
                                            <p>{{ $opd->product->product_name }}({{ $opd->weight->description }}) x
                                                {{ $opd->product_qty }} =
                                                {{ $opd->sub_total }}</p>
                                        @endforeach
                                        <hr>
                                        <p class="card-text">Order Status :
                                            @if ($op->order_status == 'N')
                                                <span>Order received by seller.</span>
                                            @elseif ($op->order_status == 'P')
                                                <span>Seller is preparing your order.</span>
                                            @elseif ($op->order_status == 'R' && $op->payment->delivery_method == 1)
                                                <span>Order is ready for pickup.</span>
                                            @elseif ($op->order_status == 'R' && $op->payment->delivery_method == 2)
                                                <span>Order is ready for delivery.</span>
                                            @elseif ($op->order_status == 'D' && $op->payment->delivery_method == 2)
                                                <span>Your order is out for delivery.</span>
                                                <div class="pt-2">

                                                    <a href="{{ route('complete-order', ['id' => $op->id,'page' => 'C']) }}"
                                                              class="btn btn-sm btn-success">Order Received</a>
                                                </div>
                                            @elseif ($op->order_status == 'C')
                                                <span>Your order is completed.</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .input-radio{
        display: inline-block;
        margin-right: 10px;
        margin-top: 30px;
      }
      input[type=radio] {
          display: none;
        }
        input[type=radio] + label {
          padding: 10px;
          border-radius: 10px;
          border: 1px solid #ddd;
       
        }
       input[type=radio] + label:hover {
          border: 1px solid red;
        }
        input[type=radio]:checked + label {
          border: 1px solid red;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            var item = {{ $cart->count() }};
            if (item > 0) {
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



            $('.filter-button').click(function() {
                var value = $(this).data('value'); // Get the value associated with the clicked button

                if (value === 'all') {
                    // Show all card containers
                    $('.card-container').show('1000');
                } else {
                    // Hide all card containers
                    $('.card-container').hide();

                    // Show card containers with the specified class
                    $('.card-container').filter('.' + value).show('1000');
                }
            });
        });

        function addToCart(product_id) {
            var qty = $('#qty' + product_id).val();
            var userid = $('#user_id').val();
            var size = null;
            if ($('#250g' + product_id).prop('checked')) {
                size = $('#250g' + product_id).val();
            } else if ($('#500g' + product_id).prop('checked')) {
                size = $('#500g' + product_id).val();
            } else if ($('#1kg' + product_id).prop('checked')) {
                size = $('#1kg' + product_id).val();
            }else{
                size = null;
            }
            if(size == null){
                Swal.fire({
                title: "Error",
                text: "Please select size cutting!",
                icon: "error"
                });
                return;
            }
            if(qty == 0){
                Swal.fire({
                title: "Error",
                text: "Please add quantity!",
                icon: "error"
                });
                return;
            }
            console.log(size);
            $.ajax({
                type: "POST",
                url: "{{ route('cart-datatable') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: product_id,
                    qty: qty,
                    userid: userid,
                    uomdescription: size, 
                },
                success: function(response) {
                    location.reload();
                }
            });
        }

        function removeToCart(product_id) {
            console.log(product_id);
            var userid = $('#user_id').val();
            $.ajax({
                type: "POST",
                url: "{{ route('cart-remove') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: product_id,
                    userid: userid,
                },
                success: function(response) {
                    location.reload();
                }

            });
        }
    </script>
@endsection
