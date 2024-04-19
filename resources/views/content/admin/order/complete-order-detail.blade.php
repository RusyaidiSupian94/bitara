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
                <div class="row gy-4 ">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button id="downloadTableBtn" class="btn p-0" type="button">
                            <i class="mdi mdi-download mdi-24px"></i></button>
                    </div>
                </div>
                <br>
                <div class="row gy-4">
                    <div class="dt-buttons"></div>
                    <table id="orderTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Order Id: </th>
                                <th scope="col" colspan="3"><span id="order_id">{{ $order->id }}</span></th>
                            </tr>
                            <tr>
                                <th scope="col">#Transaction Id: </th>
                                <th scope="col"><span id="transaction_id">N/A</span></th>
                                <th scope="col">Payment Method: </th>
                                <th scope="col"><span id="payment_method">N/A</span></th>
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
                            <tr>
                                <th scope="col">Order timestamp: </th>
                                <th scope="col"><span id="order_timestamp">{{ $order->updated_at }}</span></th>
                                <th scope="col">Preparing timestamp: </th>
                                <th scope="col"><span id="preparing_timestamp">{{ $order->preparing_at }}</span></th>
                            </tr>
                            <tr>
                                <th scope="col">Delivering timestamp: </th>
                                <th scope="col"><span id="delivering_timestamp">{{ $order->delivering_at }}</span></th>
                                <th scope="col">Completed timestamp: </th>
                                <th scope="col"><span id="completed_timestamp">{{ $order->completed_at }}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4"> </td>
                            </tr>
                            <tr>
                                <td colspan="2"> Item</td>
                                <td> Total Amount</td>
                                <td> <span id="total_amount">{{ $order->total_amount }}</span></td>
                            </tr>
                            @foreach ($order->details as $item)
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->product_qty }} </td>
                                <td>{{ $item->sub_total }}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer pt-2">
                    <a href="{{ route('dashboard-order') }}"><button type="button"
                            class="btn btn-secondary">Back</button></a>
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
