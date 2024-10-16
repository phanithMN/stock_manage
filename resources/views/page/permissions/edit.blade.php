@extends('layout.app')
@section('title') {{'Update Permission'}} @endsection
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
                <a href="{{route('permission')}}">Permission</a>
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
                        <form method="post" class="form-group" action="{{ route('edit-data-permission', $permission->id)}}" enctype="multipart/form-data">
                            @csrf  
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="Name"
                                        name="name"
                                        placeholder="Enter Name"
                                        value="{{$permission->name}}"
                                        />
                                    </div>
                                    @error('name')
                                        <span class="text-danger ml-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="permission_key">Select Key <span class="text-danger">*</span></label>
                                        <select class="form-select form-control" id="permission_key" name="permission_key" required>
                                            <option value="">Chosse Key</option>
                                            @foreach($permission_keys as $permission_key)
                                            <option value="{{$permission_key}}">{{$permission_key}}</option>
                                            @endforeach
                                        </select>
                                        @error('permission_key')
                                            <span class="text-danger ml-2">{{ $message }}</span>
                                        @enderror
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