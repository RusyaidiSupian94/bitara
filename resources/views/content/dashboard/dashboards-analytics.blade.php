@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

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
<div class="row gy-4">

  <!-- Transactions -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Bitara Mart Transactions ({{$today}})</h5>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-dots-vertical mdi-24px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
              <a class="dropdown-item" href="#" id="todayOption">Today</a>
              <a class="dropdown-item" href="#" id="monthOption">Month</a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-primary rounded shadow">
                  <i class="mdi mdi-currency-usd mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Sales</div>
                <h5 class="mb-0">RM {{$totalSalesToday}}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-success rounded shadow">
                  <i class="mdi mdi-account-outline mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Order</div>
                <h5 class="mb-0">{{$totalOrderToday}}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-warning rounded shadow">
                  <i class="mdi mdi-truck-delivery mdi-24px"></i>

                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Delivery</div>
                <h5 class="mb-0">{{$totalOrderDeliveryToday}}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-info rounded shadow">
                  <i class="mdi mdi-car-pickup mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Pickup</div>
                <h5 class="mb-0">{{$totalPickupDeliveryToday}}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Transactions -->

  <!-- Total Earnings -->
  <div class="col-xl-12 col-md-12">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Current Stock ({{$today}})</h5>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="totalEarnings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-dots-vertical mdi-24px"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
            <a class="dropdown-item" href="#" id="todayOption">Today</a>
            <a class="dropdown-item" href="#" id="monthOption">Month</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          @foreach($products as $product)
          <li class="d-flex mb-4 pb-md-2">
            <div class="avatar flex-shrink-0 me-3">
              <img src="{{asset('assets/img/icons/misc/zipcar.png')}}" alt="zipcar" class="rounded">
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">{{ $product->product_name }}</h6>
                <h8 class="mb-0">{{ $product->category_description }}</h8>
              </div>
              <div>
                <h6 class="mb-2">{{ $product->total_stock }} kg</h6>
                <!-- <div class="progress bg-label-primary" style="height: 4px;">
                  <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  <!--/ Total Earnings -->

  <!-- Chart Sales -->
  <!-- <div class="col-xl-12 col-md-12">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h4 class="mb-0">{{$totalSalesToday}}</h4>
      </div>
      <div class="card-body">
        <div id="totalProfitLineChart" class="mb-3"></div>
        <h6 class="text-center mb-0">Total Sales</h6>
      </div>
    </div>
  </div> -->
  <!-- End Chart Sales -->

</div>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
  $(document).ready(function() {

  });
</script>
@endsection