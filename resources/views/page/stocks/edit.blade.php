@extends('layout.app')
@section('title') {{'Update Role'}} @endsection
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
                <a href="{{route('role')}}">Role</a>
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
                        <form method="post" class="form-group" action="{{ route('edit-data-stock', $stock->id)}}" enctype="multipart/form-data">
                            @csrf  
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="product_id">Product <span class="text-danger">*</span></label>
                                        <select class="form-select form-control" id="product_id" name="product_id" required>
                                            <option value="">Chosse Product</option>
                                            @foreach($products as $item)
                                            <option value="{{$item->id}}" {{$item->id == $stock->product_id ? 'selected' : '' }}>{{$item->name}}</option>
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
                                        value="{{$stock->reference_no}}"
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
                                         value="{{$stock->price}}"
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
                                         value="{{$stock->quantity}}"
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
                                        value="{{\Carbon\Carbon::parse($stock->date)->format('Y-m-d') }}"
                                        required
                                        />
                                    </div>
                                </div>
                               
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-select form-control" id="status" name="status" required>
                                            <option value="">Chosse Status</option>
                                            <option value="In" {{$stock->status == 'In' ? 'selected' : '' }}>In</option>
                                            <option value="Out" {{$stock->status == 'Out' ? 'selected' : '' }}>Out</option>
                                            <option value="Spoiled" {{$stock->status == 'Spoiled' ? 'selected' : '' }}>Spoiled</option>
                                            <option value="Return" {{$stock->status == 'Return' ? 'selected' : '' }}>Return</option>
                                        </select>
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