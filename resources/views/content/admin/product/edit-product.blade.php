@extends('layouts/contentNavbarLayout')

@section('title', ' Edit - Forms')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Product/</span> Edit Product</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Product Details</h5> <small class="text-muted float-end">BITARA MART</small>
                </div>
                <div class="card-body">

                    <form id="editProductForm" class="mb-3" action="{{ route('store-edited-product',['id' => $product->id]) }}"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="category" name="category" autofocus required>
                                <option selected disabled>Choose..</option>
                                @foreach ($category as $ctgy)
                                    <option value="{{ $ctgy->id }}"
                                        {{ $product->category_id == $ctgy->id ? 'selected' : '' }}>
                                        {{ $ctgy->category_description }}
                                @endforeach
                            </select>
                            <label for="category">Product Category</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="product_name" name="product_name" autofocus
                                value="{{ $product->product_name }}" required />
                            <label for="product_name">Product Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea id="product_details" name="product_details" class="form-control" placeholder="" style="height: 60px;"
                                autofocus required>{{ $product->product_details }}</textarea>
                            <label for="product_details">Product Details</label>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-2">

                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" id="cost" name="cost" class="form-control"
                                        value="{{ $product->cost_price }}"autofocus required />
                                    <label for="cost">Cost Price</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" id="unit_price" name="unit_price" 
                                        class="form-control" value="{{ $product->unit_price }}" autofocus required />
                                    <label for="unit_price">Unit Price</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select" id="uom" name="uom" autofocus required>
                                        <option selected disabled>Choose..</option>
                                        @foreach ($uoms as $uom)
                                            <option
                                                value="{{ $uom->id }}" {{ $product->uom_id == $uom->id ? 'selected' : '' }}>
                                                {{ number_format($uom->qty, 2) . '/' . $uom->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="uom">Product uom</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" id="total_stock" name="total_stock"
                                        class="form-control" value="{{ $product->total_stock }}" autofocus required />
                                    <label for="total_stock">Total Stock</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="file" class="form-control" id="product_img" name="product_img"
                                value="{{ $product->product_img }}" autofocus  />
                            <label for="product_img">Product Image</label>
                            <div class="container pt-2">
                                <img src="{{ url('/storage/product/' . $product->product_img) }}" alt="item"
                                    class="image-fluid" height="200" width="200">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
