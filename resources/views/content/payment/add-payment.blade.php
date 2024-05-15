@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Payment')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('content')
    <form id="formAuthentication" class="mb-3" action="{{ route('order-payment', ['id' => $customer->id]) }}"
        enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="user_id" id="user_id" value="{{ $customer->id }}">
        {{-- <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}"> --}}
        <div class="row">
            <div class="col-md-12">

                <div class="card w-75 h-100 mx-auto py-2">
                    <h6 class="p-2 mb-4"><span class="text-muted fw-light">Checkout/</span> Customer Details</h6>
                    <div class="row gy-4 p-4">


                        <div class="col-12">
                            <div class="row align-item-center gy-4">
                                <div class="col-12 col-md-6">
                                    <div>
                                        <p>Delivery Method</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="radioDeliveryMethod"
                                                id="radioDeliveryMethod1" value="1">
                                            <label class="form-check-label" for="radioDeliveryMethod1">
                                                Pickup
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="radioDeliveryMethod"
                                                id="radioDeliveryMethod2" value="2" checked>
                                            <label class="form-check-label" for="radioDeliveryMethod2">
                                                Delivery
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="col-12 col-md-12">
                                    <p>Customer Details</p>
                                    <table id="orderTable" class="table table-bordered">
                                        <thead>
                                            {{-- <tr>
                                                    <th scope="col">#Order Id: </th>
                                                    <th scope="col" colspan="3"><span
                                                            id="order_id">{{ $order->id }}</span>
                                                    </th>
                                                </tr> --}}
                                            <tr>
                                                <th scope="col">Customer Name: </th>
                                                <th scope="col" colspan="3">
                                                    <input type="text" id="customer_name" name="customer_name"
                                                        value="{{ $customer->user_details->fname . ' ' . $customer->user_details->lname }}"
                                                        class="form-control" autofocus required />
                                                </th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Customer Address: </th>
                                                <th scope="col" colspan="3">
                                                    {{-- <input type="text" id="customer_address" name="customer_address"
                                                        value="{{ $customer->user_details->address_1 . ' ' . $customer->user_details->address_2 }}"
                                                        class="form-control" required /> --}}

                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <input type="text" class="form-control form-control-sm" id="address_1"
                                                                        name="address_1" placeholder="Enter your address"
                                                                        value="{{ $customer->user_details->address_1 }}" autofocus required>
                                                                    <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <input type="text" class="form-control form-control-sm" id="address_2"
                                                                        name="address_2" placeholder="Enter your address"
                                                                        value="{{ $customer->user_details->address_2 }}"  autofocus>
                                                                    <label for="address_2">Address 2</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-4">
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select onchange="onChangePostcode(this)" id="postcode" name="postcode" class="form-select" required>
                                                                            @foreach ($postcodes as $pcode)
                                                                                <option value="{{ $pcode->id }}" {{ $pcode->id == $customer->user_details->postcode ? 'selected' : '' }}>{{ $pcode->postcode }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="postcode">Postcode<span class="text-danger">*</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select id="district" name="district" class="form-select" autofocus required>
                                                                            @foreach ($districts as $district)
                                                                            <option value="{{ $district->id }}" {{ $district->id == $customer->user_details->district_id ? 'selected' : '' }}>{{ $district->district_name }}
                                                                            </option>
                                                                        @endforeach
                                                                        </select>
                                                                        <label for="district">District<span class="text-danger">*</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select id="state" name="state" class="form-select" autofocus required>
                                                                            @foreach ($states as $state)
                                                                            <option value="{{ $state->id }}" {{ $state->id == $customer->user_details->state_id ? 'selected' : '' }}>{{ $state->state_name }}
                                                                            </option>
                                                                        @endforeach
                                                                        </select>
                                                                        <label for="state">State<span class="text-danger">*</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Delivery Fee: </th>
                                                <th scope="col" colspan="3">
                                                    <span id="delivery_fee" name="delivery_fee">{{$customer->user_details->uPostcode->delivery_fee}}</span>
                                                    <input type="hidden" name="hidden_delivery_fee" id="hidden_delivery_fee" value="{{$customer->user_details->uPostcode->delivery_fee}}">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Customer Contact: </th>
                                                <th scope="col" colspan="3">
                                                    <input type="text" id="customer_contact" name="customer_contact"
                                                         class="form-control" value="{{$customer->user_details->contact_no}}" autofocus required />

                                                    <span style="display: none;" id="validate_contact"
                                                        class="text-danger text-capitalize">Phone number must be at
                                                        least 10 digits.</span>

                                                </th>
                                            </tr>
                                        </thead>

                                    </table>

                                    <hr>
                                    <p>Order Items</p>
                                    <table id="orderTable2" class="table table-bordered pt-2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Sub Total</th>
                                            </tr>
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <th>{{ $loop->iteration }} </th>
                                                    <th>{{ $item->product->product_name }} ({{ $item->weight->description }})</th>
                                                    <th>{{ $item->product_qty }} </th>
                                                    <th>{{ $item->sub_total }}</th>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th colspan="2"></th>
                                                <th> Delivery Fee</th>
                                                <th> <span
                                                    name="delivery_fee_span" id="delivery_fee_span">{{$customer->user_details->uPostcode->delivery_fee}}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th> Total Amount</th>
                                                <th> <span
                                                    name="total_amount_span" id="total_amount_span">{{ number_format($customer->user_details->uPostcode->delivery_fee+$cart->sum('sub_total') ?? 0, 2) }}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <input type="hidden" name="total_amount"
                                        value="{{ number_format($cart->sum('sub_total')  ?? 0, 2) }}">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 pt-2">

                <div class="card w-75 h-100 mx-auto py-2">
                    <h6 class="p-2 mb-4"><span class="text-muted fw-light">Checkout/</span> Payment Details</h6>
                    <div class="row gy-4 p-4">
                        <div class="col-12 pt-3">
                            <div class="row align-item-center gy-4">

                                <div class="col-12 col-md-6">

                                    <p>Payment Method</p>
                                    <div class="card border" style="width: 18rem;">
                                        <div class="card-header">

                                            <div class="form-check">

                                                <input class="form-check-input" type="radio" name="radioPaymentMethod"
                                                    id="radioPaymentMethod1" value="1" checked>
                                                <label class="form-check-label" for="radioPaymentMethod1">
                                                    Online Transfer
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border" style="width: 18rem;">
                                        <div class="card-header">
                                            <div class="form-check">


                                                <input class="form-check-input" type="radio" name="radioPaymentMethod"
                                                    id="radioPaymentMethod1" value="2">
                                                <label class="form-check-label" for="radioPaymentMethod1">
                                                    QR Scan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">

                                    <div id="transfer">
                                        <p class="text-danger"> <small><i>**Kindly transfer to the account below and
                                                    attach
                                                    the receipt.</i> </small></p>
                                        <div class="card border" style="width: 100%;">
                                            <div class="card-header">

                                                <div class="form-check">

                                                    <img src="{{ asset('assets/img/elements/maybank.png') }}"
                                                        alt="item" class="w-px-40 h-auto rounded-circle">


                                                    <label class="form-check-label" for="radioPaymentMethod1">
                                                        <b>163218463729</b> <b>(Bintara M)</b>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card border" style="width: 100%;">
                                            <div class="card-header">
                                                <div class="form-check">
                                                    <img src="{{ asset('assets/img/elements/cimb.png') }}" alt="item"
                                                        class="w-px-40 h-auto rounded-circle">

                                                    <label class="form-check-label" for="radioPaymentMethod1">
                                                        <b>061248563</b> <b>(Bintara M)</b>
                                                    </label><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="qr" class="mx-auto" style="display: none">
                                        <p class="text-danger"> <small><i>**Kindly scan the QR below and
                                                    attach the receipt.</i> </small></p>

                                        <img src="{{ asset('assets/img/elements/qr.jpeg') }}" width="250"
                                            alt="">
                                    </div>
                                </div>


                            </div>
                            <div class="row py-3">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="file" class="form-control" id="payment_receipt"
                                            name="payment_receipt" autofocus required />
                                        <label for="payment_receipt">Payment Receipt</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button id="completeModal" type="submit" class="btn btn-sm btn-primary">
                                        Proceed Payment
                                    </button>
                                    <a href="{{ route('dashboard-customer') }}">
                                        <button id="completeModal" type="button" class="btn btn-sm btn-danger">
                                            Cancel
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>
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
            // Add change event listener to radio buttons with name 'radioPaymentMethod'
            $('input[name="radioPaymentMethod"]').change(function() {
                // Check if the selected radio button has value '1'
                if ($(this).val() === '1') {
                    // Show the div with ID 'transfer'
                    $('#transfer').show();
                    $('#qr').hide();

                } else {
                    // Hide the div with ID 'transfer'
                    $('#qr').show();
                    $('#transfer').hide();

                }
            });
            $('input[name="radioDeliveryMethod"]').change(function() {
                // Check if the selected radio button has value '1'
                var val = $('#hidden_delivery_fee').val();
                if ($(this).val() === '1') {
                    $('#delivery_fee').text(0.00);
                    $('#delivery_fee_span').text(0.00);
                    var totalAmountText = $('#total_amount_span').text();
                    
                    var totalAmountFloat = parseFloat(totalAmountText)-parseFloat(val);
                    
                    $('#total_amount_span').text(totalAmountFloat);
                    $('#total_amount').val(totalAmountFloat);
                    
                    $('input[type="text"], input[type="number"], input[type="checkbox"], select, textarea').prop('disabled', true);
                    
                } else {
                    $('#delivery_fee').text(val);
                    $('#delivery_fee_span').text(val);
                    var totalAmountText = $('#total_amount_span').text();
                    var totalAmountFloat = parseFloat(totalAmountText)+parseFloat(val);
                    
                    $('#total_amount_span').text(totalAmountFloat);
                    $('#total_amount').val(totalAmountFloat);
                    
                    console.log(totalAmountFloat);

                    $('input[type="text"], input[type="number"], input[type="checkbox"], select, textarea').prop('disabled', false);

                }
            });
            $('#customer_contact').on('input', function() {

                var phoneNumber = $(this).val().replace(/\D/g, '');
                if (phoneNumber.length > 0 && phoneNumber.length < 10) {
                    $('#validate_contact').show();
                } else {
                    $('#validate_contact').hide();
                }
            });
        });

        function onChangePostcode(e) {
            var selectedPostcode = e.value;
            var stateDropdown = $('#state');
                var districtDropdown = $('#district');
            $.ajax({
                url: "{{route('get-payment-poscode-details')}}", // Replace with your actual endpoint
                type: 'GET',
                data: { postcode: selectedPostcode },
                success: function(response) {
                    $('#delivery_fee').text(response.data.delivery_fee);
                    $('#delivery_fee_span').text(response.data.delivery_fee);
                    $('#hidden_delivery_fee').val(response.data.delivery_fee);
                    $('#total_amount_span').text(parseFloat(response.total_amount)+parseFloat(response.data.delivery_fee));
                    $('#total_amount').val(parseFloat(response.total_amount)+parseFloat(response.data.delivery_fee));

                        stateDropdown.empty().append('<option selected disabled>Please Choose</option>');
                        districtDropdown.empty().append('<option selected disabled>Please Choose</option>');

                            stateDropdown.append('<option selected value="' + response.data.state.id + '">' + response.data.state.state_name + '</option>');
            
                            districtDropdown.append('<option selected value="' + response.data.district.id + '">' + response.data.district.district_name + '</option>');

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching state and district data:", error);
                }
            });
        }
    </script>
@endsection
