@php
$isMenu = false;
$navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<div class="card w-100 h-100">
  <div class="row gy-4 p-4">
    <div class="col-12">
      <div class="row gy-4">
        <!-- Product List from database -->
        @foreach($products as $product)
        <div class="col-sm-3">
          <div class="card h-100">

            <div class="card-body">
              <img src="{{ asset('assets/img/' . $product->product_img) }}" class="card-img-top image-fluid" alt="...">
              <h6 class="text-center mb-0 pt-2">{{$product->product_name}}</h6>
              <div class="d-flex flex-wrap align-items-center mb-2 pb-1">
                <h4 class="mb-0 me-2">RM{{$product->unit_price}}</h4>
                <small class="text-success mt-1">1 piece</small>
              </div>
              <small>Product description</small>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>

</div>
@endsection