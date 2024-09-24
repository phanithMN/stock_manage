@extends('layout.app')
@section('title') {{'Update User'}} @endsection
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
                <a href="{{route('user')}}">User</a>
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
                        <form method="post" class="form-group" action="{{ route('edit-data-user', $user->id)}}" enctype="multipart/form-data">
                            @csrf  
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="Name"
                                        name="name"
                                        placeholder="Enter Name"
                                        value="{{$user->name}}"
                                        />
                                    </div>
                                    @error('name')
                                        <span class="text-danger ml-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="image">Image <span class="text-danger">*</span></label>
                                        <input
                                        type="file"
                                        class="form-control"
                                        id="image"
                                        name="image"
                                        placeholder="Enter Name"
                                        value="{{$user->image}}"
                                        />
                                    </div>
                                    @error('image')
                                        <span class="text-danger ml-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="Email"
                                        name="email"
                                        placeholder="Enter Email"
                                        value="{{$user->email}}"
                                        />
                                    </div>
                                    @error('email')
                                        <span class="text-danger ml-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Username <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="username"
                                        name="username"
                                        placeholder="Enter Username"
                                        value="{{$user->username}}"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card-action section-role">
                                <div class="card-title mt-3">Asign Role</div>
                                <div class="d-flex">
                                    @if ($roles->isNotEmpty())
                                        @foreach ($roles as $role )
                                            <div class="form-group d-flex">
                                                <input 
                                                id="role-{{$role->id}}" 
                                                type="checkbox" 
                                                class="mr-5 rounded"
                                                name="role[]"  
                                                value="{{$role->name}}"
                                                > 
                                                <label class="form-label" for="role-{{$role->id}}">{{$role->name}}</label>
                                            </div>
                                        @endforeach
                                    @endif
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