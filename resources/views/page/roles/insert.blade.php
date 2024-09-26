@extends('layout.app')
@section('title') {{'Insert New Role'}} @endsection
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
                        <form method="post" class="form-group" action="{{route('insert-data-role')}}" enctype="multipart/form-data">
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
                                        />
                                    </div>
                                </div>
                                @error('name')
                                    <span class="text-danger ml-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="card-action section-role">
                                <div class="card-title mt-3">Asign Permission</div>
                                <div class="d-flex">
                                    @if ($permissions->isNotEmpty())
                                        @foreach ($permissions as $permission )
                                            <div class="form-group d-flex">
                                                <input 
                                                id="permission-{{$permission->id}}" 
                                                type="checkbox" 
                                                class="mr-5 rounded"
                                                name="permission[]"  
                                                value="{{$permission->id}}"
                                                > 
                                                <label class="form-label" for="permission-{{$permission->id}}">{{$permission->name}}</label>
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