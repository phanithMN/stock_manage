@extends('layout.app')
@section('title') {{'Insert Product In Stock'}} @endsection
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">@yield('title')</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{route('stock')}}">Stock</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">@yield('title')</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">@yield('title')</div>
                    </div>
                    <div class="card-body">
                        <form method="post" class="form-group" action="{{route('insert-data-stock')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="product_id">Product <span class="text-danger">*</span></label>
                                        <select class="form-select form-control" id="product_id" name="product_id" required>
                                            <option value="">Chosse Product</option>
                                            @foreach($products as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="reference_no">Reference No <span class="text-danger">*</span></label>
                                        <input
                                        type="type"
                                        class="form-control"
                                        id="reference_no"
                                        name="reference_no"
                                        placeholder="Enter Reference No"
                                        required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="price">Price(៛) <span class="text-danger">*</span></label>
                                        <input
                                        type="number"
                                        class="form-control"
                                        id="price"
                                        name="price"
                                        placeholder="Enter Price"
                                        required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                        <input
                                        type="number"
                                        class="form-control"
                                        id="quantity"
                                        name="quantity"
                                        placeholder="Enter Quantity"
                                        required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="date">Date At <span class="text-danger">*</span></label>
                                        <input
                                        type="date"
                                        class="form-control"
                                        id="date"
                                        name="date"
                                        required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Sku</label>
                                        <input
                                            type="text"
                                            name="sku"
                                            class="form-control"
                                            id="sku"
                                            value="SKU Auto Generate"
                                            placeholder="SKU Auto Generate"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Submit</button>
                                <button class="btn btn-danger" onclick="history.back(); return false;">Cancel</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection