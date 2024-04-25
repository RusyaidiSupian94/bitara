@extends('layouts/contentNavbarLayout')

@section('title', ' Add - Forms')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Product/</span> Add Product</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">New Product Details</h5> <small class="text-muted float-end">BITARA MART</small>
                </div>
                <div class="card-body">

                    <form id="addProductForm" class="mb-3" action="{{ route('store-product') }}"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="category" name="category" autofocus required>
                                <option selected disabled>Choose..</option>
                                @foreach ($category as $ctgy)
                                    <option value="{{ $ctgy->id }}">{{ $ctgy->category_description }}</option>
                                @endforeach
                            </select>
                            <label for="category">Product Category</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="product_name" name="product_name" autofocus
                                required />
                            <label for="product_name">Product Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea id="product_details" name="product_details" class="form-control" placeholder="" style="height: 60px;"
                                autofocus required></textarea>
                            <label for="product_details">Product Details</label>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-2">

                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="cost" name="cost" value="0"
                                        class="form-control"autofocus required />
                                    <label for="cost">Cost Price</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="unit_price" name="unit_price" value="0"
                                        class="form-control"autofocus required />
                                    <label for="unit_price">Unit Price</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select" id="uom" name="uom" autofocus required>
                                        <option selected disabled>Choose..</option>
                                        @foreach ($uoms as $uom)
                                            <option value="{{ $uom->id }}">
                                                {{ $uom->qty . '/' . $uom->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="uom">Product Weight</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" id="total stock" name="total stock" value="0"
                                        class="form-control"autofocus required />
                                    <label for="total stock">Total Stock</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="file" class="form-control" id="product_img" name="product_img" autofocus
                                required />
                            <label for="product_img">Product Image</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
