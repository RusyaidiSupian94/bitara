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
    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
    <div class="card w-75 h-100 mx-auto">
        <div class="row gy-4 p-4">
            <form id="formAuthentication" class="mb-3" action="{{ route('order-payment', ['id' => $user->id]) }}"
                method="POST">
                @csrf

                <div class="col-12">
                    <div class="row align-item-center gy-4">
                        <div class="col-12 col-md-4">
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
                            <div>
                                <p>Payment Method</p>
                                <div class="card border" style="width: 18rem;">
                                    <div class="card-header">

                                        <div class="form-check">
                                            <img src="{{ asset('assets/img/elements/fpx.jpg') }}" alt="item"
                                                class="w-px-40 h-auto rounded-circle">

                                            <input class="form-check-input" type="radio" name="radioPaymentMethod"
                                                id="radioPaymentMethod1" value="1" checked>
                                            <label class="form-check-label" for="radioPaymentMethod1">
                                                Online Banking
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border" style="width: 18rem;">
                                    <div class="card-header">
                                        <div class="form-check">
                                            <img src="{{ asset('assets/img/elements/mastercard.png') }}" alt="item"
                                                class="w-px-40 h-auto rounded-circle">

                                            <input class="form-check-input" type="radio" name="radioPaymentMethod"
                                                id="radioPaymentMethod1" value="2">
                                            <label class="form-check-label" for="radioPaymentMethod1">
                                                Credit Card
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border" style="width: 18rem;">
                                    <div class="card-header">
                                        <div class="form-check">
                                            <img src="{{ asset('assets/img/elements/tng.png') }}" alt="item"
                                                class="w-px-40 h-auto rounded-circle">

                                            <input class="form-check-input" type="radio" name="radioPaymentMethod"
                                                id="radioPaymentMethod1" value="3">
                                            <label class="form-check-label" for="radioPaymentMethod1">
                                                TNG e-wallet
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border" style="width: 18rem;">
                                    <div class="card-header">
                                        <div class="form-check">
                                            <img src="{{ asset('assets/img/elements/boost.png') }}" alt="item"
                                                class="w-px-40 h-auto rounded-circle">
                                            <input class="form-check-input" type="radio" name="radioPaymentMethod"
                                                id="radioPaymentMethod1" value="4">
                                            <label class="form-check-label" for="radioPaymentMethod1">
                                                Boost
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <table id="orderTable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#Order Id: </th>
                                        <th scope="col" colspan="3"><span id="order_id">{{ $order->id }}</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Customer Name: </th>
                                        <th scope="col" colspan="3"><span
                                                id="customer_address">{{ $order->customer->user_details->fname . ' ' . $order->customer->user_details->lname }}</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Customer Address: </th>
                                        <th scope="col" colspan="3"><span
                                                id="customer_address">{{ $order->customer->user_details->address_1 . ' ' . $order->customer->user_details->address_2 }}</span>
                                        </th>
                                    </tr>
                                </thead>

                            </table>
                            <table id="orderTable2" class="table table-bordered pt-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Sub Total</th>
                                    </tr>
                                    @foreach ($order->details as $item)
                                    <tr>
                                            <th>{{ $loop->iteration }} </th>
                                            <th>{{ $item->product->product_name }}</th>
                                            <th>{{ $item->product_qty }} </th>
                                            <th>{{ $item->sub_total }}</th>
                                        </tr>
                                        @endforeach
                                    <tr>
                                        <th colspan="2"></th>
                                        <th> Total Amount</th>
                                        <th> <span id="total_amount">{{ $order->total_amount }}</span></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button id="completeModal" type="submit" class="btn btn-sm btn-primary">
                                Proceed Payment
                            </button>
                            <a target="_blank" href="{{ route('dashboard-customer') }}">
                                <button id="completeModal" type="button" class="btn btn-sm btn-danger">
                                    Cancel
                                </button>
                            </a>
                        </div>
                    </div>

                </div>
            </form>
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
    <script></script>
@endsection
