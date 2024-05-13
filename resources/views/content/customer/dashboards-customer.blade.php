@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <style>
        .carousel-item img {
            height: 300px;
            /* Set the height of the images */
            width: 100%;
            /* Ensure images fill the width of their container */
            object-fit: cover;
            /* Maintain aspect ratio and cover the container */
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('content')
    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
    <div>
        <div id="carouselHomepage" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselHomepage" data-bs-interval="10000" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselHomepage" data-bs-interval="10000" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselHomepage" data-bs-interval="10000" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('assets/img/backgrounds/a.jpg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/backgrounds/b.jpg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/backgrounds/c.jpg') }}" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHomepage"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselHomepage"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
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
                                                <div class="input-radio"><input type="radio"
                                                        id="250g{{ $product->id }}" name="size" value="250g"
                                                        checked> <label for="250g{{ $product->id }}">250g</label></div>
                                                <div class="input-radio"><input type="radio"
                                                        id="500g{{ $product->id }}" name="size" value="500g">
                                                    <label for="500g{{ $product->id }}">500g</label>
                                                </div>
                                                <div class="input-radio"><input type="radio"
                                                        id="1kg{{ $product->id }}" name="size" value="1kg">
                                                    <label for="1kg{{ $product->id }}">1kg</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-3">
                                            <div class="col-12 col-md-8">
                                                <div class="input-group input-group-sm mb-3">
                                                    <button class="btn btn-outline-secondary button-minus" type="button"
                                                        data-id="{{ $product->id }}"><i
                                                            class="mdi mdi-minus mdi-24px"></i></button>
                                                    <input id="qty{{ $product->id }}" type="number"
                                                        class="form-control" value="0">
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

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel">
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
                                            <p class="card-text">
                                            <div class="col-12">
                                                <div class="input-group input-group-sm mb-3">
                                                    <button class="btn btn-outline-secondary button-minuscart"
                                                        type="button" data-id="{{ $cartorder->id }}"><i
                                                            class="mdi mdi-minus mdi-2px"></i></button>
                                                    <input id="cartqty{{ $cartorder->id }}" type="number"
                                                        class="form-control" value="{{ $cartorder->product_qty }}">
                                                    <button class="btn btn-outline-secondary button-pluscart"
                                                        type="button" data-id="{{ $cartorder->id }}"><i
                                                            class="mdi mdi-plus mdi-2px"></i></button>
                                                </div>
                                            </div>
                                            </p>

                                            <p class="card-text">Quantity : <span
                                                    id="finalqty{{ $cartorder->id }}">{{ $cartorder->product_qty }}</span>
                                                x {{ $cartorder->weight->description }}</p>
                                            <p class="card-text">Unit Price : RM
                                                {{ $cartorder->product->unit_price / $cartorder->weight->qty }}</p>
                                            <p class="card-text">Sub Total : RM <span
                                                    id="subtotal{{ $cartorder->id }}">{{ $cartorder->sub_total }}</span>
                                            </p>
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
                                        <h5 class="card-title">
                                            Total Amount : RM <span
                                                id="finalSubtotal">{{ number_format($cart->sum('sub_total') ?? 0, 2) }}</span>
                                        </h5>
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
                                                RM {{ $opd->sub_total }}</p>
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

                                                    <a href="{{ route('complete-order', ['id' => $op->id, 'page' => 'C']) }}"
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
        .input-radio {
            display: inline-block;
            margin-right: 10px;
            margin-top: 30px;
        }

        input[type=radio] {
            display: none;
        }

        input[type=radio]+label {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;

        }

        input[type=radio]+label:hover {
            border: 1px solid red;
        }

        input[type=radio]:checked+label {
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
                var qty = parseInt($(input).val());
                if (qty > 0) {
                    $(input).val(qty - 1);
                }
            });

            // Event handler for plus button
            $('.button-plus').click(function() {
                var productId = $(this).data('id');
                var input = $('#qty' + productId);
                var qty = parseInt($(input).val());
                $(input).val(qty + 1);
            });


            $('.button-minuscart').click(function() {
                var cartId = $(this).data('id');
                var qty = $('#cartqty' + cartId).val();
                var final_qty = parseInt(qty) - 1;
                $.ajax({
                    type: "POST",
                    url: "{{ route('cart-qty') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cartId,
                        qty: final_qty
                    },
                    success: function(response) {
                        var update = $('#cartqty' + cartId).val(final_qty);
                        var update = $('#finalqty' + cartId).text(response.data.product_qty);
                        var update = $('#subtotal' + cartId).text(response.data.sub_total);
                        var update = $('#finalSubtotal').text(response.total_amount);
                        // location.reload();
                    }

                });

            });

            // Event handler for plus button
            $('.button-pluscart').click(function() {
                var cartId = $(this).data('id');
                var qty = $('#cartqty' + cartId).val();
                var final_qty = parseInt(qty) + 1;
                $.ajax({
                    type: "POST",
                    url: "{{ route('cart-qty') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cartId,
                        qty: final_qty
                    },
                    success: function(response) {
                        var update = $('#cartqty' + cartId).val(final_qty);
                        var update = $('#finalqty' + cartId).text(response.data.product_qty);
                        var update = $('#subtotal' + cartId).text(response.data.sub_total);
                        var update = $('#finalSubtotal').text(response.total_amount);
                        // location.reload();
                    }

                });
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
            } else {
                size = null;
            }
            if (size == null) {
                Swal.fire({
                    title: "Error",
                    text: "Please select size cutting!",
                    icon: "error"
                });
                return;
            }
            if (qty == 0) {
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
        //         function updateCartQuantity(cartId, quantity) {
        //     // AJAX call to send data to server-side script
        //     $.ajax({
        //         url: 'update_cart_quantity.php', // Replace with your server-side script URL
        //         method: 'POST',
        //         data: {
        //             cart_id: cartId,
        //             quantity: quantity
        //         },
        //         success: function(response) {
        //             // Handle successful response from server
        //             console.log('Cart quantity updated successfully');
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle error
        //             console.error('Error updating cart quantity:', error);
        //         }
        //     });
        // }
    </script>
@endsection
