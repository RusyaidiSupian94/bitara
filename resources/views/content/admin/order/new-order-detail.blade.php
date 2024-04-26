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
                <h6>New Order Details</h6>
                <br>
                <div class="row gy-4">
                    <div class="dt-buttons"></div>
                    <table id="orderTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Order Id: </th>
                                <th scope="col" colspan="3"><span id="order_id">{{ $payment->order_id }}</span></th>
                            </tr>
                            <tr>
                                <th scope="col">#Transaction Id: </th>
                                <th scope="col"><span id="transaction_id">#{{ $payment->id }}</span></th>
                                <th scope="col">Payment Method: </th>
                                <th scope="col"><span id="payment_method">
                                        @if ($payment->payment_method == 1)
                                            Online Transfer
                                        @else
                                            QR Scan
                                        @endif
                                    </span></th>
                            </tr>
                            <tr>
                                <th scope="col">Customer Name: </th>
                                <th scope="col"><span id="customer_name">{{ $payment->customer_name }}</span>
                                </th>
                                <th scope="col">Customer Contact: </th>
                                <th scope="col"><span id="customer_address">{{ $payment->customer_contact }}</span>
                                </th>
                            </tr>

                            <tr>
                                <th scope="col">Customer Address: </th>
                                <th scope="col"><span id="customer_address">{{ $payment->customer_address }}</span>
                                </th>
                                <th scope="col">Delivery Method: </th>
                                <th scope="col"><span id="payment_method">
                                        @if ($payment->delivery_method == 1)
                                            Pickup
                                        @else
                                            Delivery
                                        @endif
                                    </span></th>
                            </tr>
                            <tr>
                                <th scope="col">Order timestamp: </th>
                                <th scope="col" colspan="3"><span
                                        id="order_timestamp">{{ $payment->order->updated_at }}</span></th>

                            </tr>
                            <tr>
                                <th scope="col">Payment Receipt : </th>
                                <th scope="col" colspan="3"><a target="_blank"
                                        href="{{ url('/storage/payment/' . $payment->payment_receipt) }}">{{ $payment->payment_receipt }}</a>
                                </th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td colspan="4"> </td>
                            </tr>
                            <tr>
                                <td colspan="2"> Item</td>
                                <td> Total Amount</td>
                                <td> <span id="total_amount">{{ $payment->payment_amount }}</span></td>
                            </tr>
                            @foreach ($payment->order->details as $item)
                                <tr>

                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->product->product_name }} ({{ $item->weight->description }})</td>
                                    <td>{{ $item->product_qty }} </td>
                                    <td>{{ $item->sub_total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end pt-5">
                    <div class="col-auto">

                        <a href="{{ route('prepare-order', ['id' => $payment->order_id]) }}">
                            <button type="button" class="btn btn-sm btn-success">
                                Process Order
                            </button>
                        </a>
                        <a href="{{ route('cancel-order', ['id' => $payment->id]) }}">
                            <button type="button" class="btn btn-sm btn-warning">
                                Reject Order
                            </button>
                        </a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script></script>
@endsection
