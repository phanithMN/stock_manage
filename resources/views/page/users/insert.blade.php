@extends('layout.app')
@section('title') {{'Insert New User'}} @endsection
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
                        <form method="post" class="form-group" action="{{route('insert-data-user')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        placeholder="Enter Name"
                                        required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Image <span class="text-danger">*</span></label>
                                        <input
                                        type="file"
                                        class="form-control"
                                        id="image"
                                        name="image"
                                        placeholder="Enter Name"
                                        required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        placeholder="Enter Email"
                                        required
                                        />
                                    </div> 
                                </div> 
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="username"
                                        name="username"
                                        placeholder="Enter Username"
                                        required
                                        />
                                    </div>
                                    
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="password">{{ __('Password') }} <span class="text-danger">*</span></label>
                                        <input 
                                        id="password" 
                                        type="password" 
                                        class="form-control" 
                                        placeholder="Enter password" 
                                        name="password"   
                                        autocomplete="new-password"
                                        required>
                                    </div>
                                   
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="password">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                        <input 
                                        id="password_confirm" 
                                        type="password" 
                                        class="form-control" 
                                        placeholder="Enter confirm password" 
                                        name="password_confirmation"  
                                        autocomplete="new-password"
                                        required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action section-role">
                                <div class="card-title mt-3">Asign Role</div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="role_id">Role <span class="text-danger">*</span></label>
                                            <select class="form-select" id="role_id" name="role_id" required>
                                                <option value="">Select Roles</option>
                                                @if ($roles->isNotEmpty())
                                                @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
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