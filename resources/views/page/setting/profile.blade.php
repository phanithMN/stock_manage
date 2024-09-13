@extends('layout.app')
@section('title') {{'User Profile'}} @endsection
@section('content')
<div class="container">
  <div class="page-inner">
    <h3 class="fw-bold mb-3">User Profile</h3>
    <div class="row">
      <div class="col-md-8">
        <div class="card card-with-nav">
          <div class="card-header">
            <div class="row row-nav-line">
              <ul class="nav nav-tabs nav-line nav-color-secondary w-100 ps-4" role="tablist">
                
                <li class="nav-item submenu" role="presentation">
                  <a class="nav-link show active" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false" tabindex="-1">Profile</a>
                </li>
                
              </ul>
            </div>
          </div>
          <div class="card-body">
            @if($user_info == null)
              <form method="post" class="form-group" action="{{route('insert-data')}}" enctype="multipart/form-data">
                @csrf
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="form-group form-group-default">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-default">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" placeholder="Name" required>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-4">
                    <div class="form-group form-group-default">
                      <label>Birth Date</label>
                      <input type="date" class="form-control" id="date_birth" name="date_birth" placeholder="Birth Date" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-default">
                      <label>Gender</label>
                      <select class="form-select" id="gender" name="gender" required>
                        <option>Male</option>
                        <option>Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-default">
                      <label>Phone</label>
                      <input type="text" class="form-control" name="phone_number" placeholder="Phone" required>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="form-group form-group-default">
                      <label>Address</label>
                      <input type="text" class="form-control" name="address" placeholder="Address" required>
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-1">
                  <div class="col-md-12">
                    <div class="form-group form-group-default">
                      <label>About Me</label>
                      <textarea class="form-control" name="about_me" placeholder="About Me" rows="3" required></textarea>
                    </div>
                  </div>
                </div>
                <div class="text-end mt-3 mb-3">
                  <button class="btn btn-success" type="submit">Save</button>
                </div>
              </form>
            @else 
              <form method="post" class="form-group" action="{{route('edit-data-account-setting', $user_info->id)}}" enctype="multipart/form-data">
                @csrf  
                @method('PUT')
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="form-group form-group-default">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name" value="{{$user_info->name}}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-default">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" placeholder="Name" value="{{$user_info->email}}" required>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-4">
                    <div class="form-group form-group-default">
                      <label>Birth Date</label>
                      <input type="date" class="form-control" id="date_birth" name="date_birth" value="{{$user_info->date_birth}}" placeholder="Birth Date" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-default">
                      <label>Gender</label>
                      <select class="form-select" id="gender" name="gender" required>
                        <option {{$user_info->gender == 'male' ? 'selected' : ''}}>Male</option>
                        <option {{$user_info->name == 'femal' ? 'selected' : ''}}>Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group-default">
                      <label>Phone</label>
                      <input type="text" class="form-control" value="{{$user_info->phone_number}}" name="phone_number" placeholder="Phone" required>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="form-group form-group-default">
                      <label>Address</label>
                      <input type="text" class="form-control" value="{{$user_info->address}}" name="address" placeholder="Address" required>
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-1">
                  <div class="col-md-12">
                    <div class="form-group form-group-default">
                      <label>About Me</label>
                      <textarea class="form-control" name="about_me" placeholder="About Me" rows="3">{{$user_info->about_me}}</textarea>
                    </div>
                  </div>
                </div>
                <div class="text-end mt-3 mb-3">
                  <button class="btn btn-success" type="submit">Save</button>
                  <a href="{{ route('clear-user-info', $user_info->id) }}"  onclick="return confirmation(event)" class="btn btn-danger">Reset</a>
                </div>
              </form>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-post card-round">
          <img class="card-img-top" src="assets/img/blogpost.jpg" alt="Card image cap">
          <div class="card-body">
            <div class="d-flex">
              <div class="avatar">
                <img 
                  src="{{!is_null(Auth::user()) && isset(Auth::user()->image) ? asset('uploads/users/' . Auth::user()->image) : '/assets/img/profile.jpg'  }}" 
                  alt="" class="avatar-img rounded-circle" />
              </div>
              <div class="info-post ms-2">
                <p class="username">{{ !is_null(Auth::user()) && isset(Auth::user()->name) ? Auth::user()->name : 'Admin'}}</p>
                <p class="date text-muted">{{ !is_null(Auth::user()) && isset(Auth::user()->email) ? Auth::user()->email : 'admin@gmail.com'}}</p>
              </div>
            </div>
            <div class="separator-solid"></div>
            <p class="card-category text-info mb-1">
              <a href="#">Design</a>
            </p>
            <h3 class="card-title">
              <a href="#"> Best Design Resources This Week </a>
            </h3>
            <p class="card-text"> Some quick example text to build on the card title and make up the bulk of the card's content. </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection