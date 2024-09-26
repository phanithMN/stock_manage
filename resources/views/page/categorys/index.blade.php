@extends('layout.app')
@section('title') {{'Category'}} @endsection
@section('content')

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3"> @yield('title')</h3>
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
          <a href="{{route('dashboad')}}">Dashboard</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#"> @yield('title')</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">@yield('title') Table</h4>
              <a href="{{route('insert-category')}}" class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i> Add New </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="add-row_length">
                      <label>
                        Show 
                        <select id="add_row_length" name="add_row_length" aria-controls="add-row" class="form-control form-control-sm">
                          <option value="10" {{ request('row_length') == 10 ? 'selected' : '' }}>10</option>
                          <option value="25" {{ request('row_length') == 25 ? 'selected' : '' }}>25</option>
                          <option value="50" {{ request('row_length') == 50 ? 'selected' : '' }}>50</option>
                          <option value="100" {{ request('row_length') == 100 ? 'selected' : '' }}>100</option>
                        </select> entries 
                      </label>
                      <script>
                          document.getElementById('add_row_length').addEventListener('change', function() {
                              let value = this.value;
                              let url = new URL(window.location.href);
                              url.searchParams.set('row_length', value);
                              window.location.href = url.toString();
                          });
                      </script>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div id="add-row_filter" class="dataTables_filter">
                      <label>
                        <form action="{{ route('category') }}" method="GET">
                          @csrf
                          Search: 
                          <input 
                          type="search" 
                          name="search" 
                          class="form-control form-control-sm" 
                          placeholder="Search..." 
                          aria-label="Search..." 
                          value="{{$search_value}}"
                          />
                        </form>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <table id="add-row" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                      <thead>
                        <tr role="row">
                          <th>#</th>
                          <th>Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($categories as $category)
                          <tr role="row" class="odd">
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>
                              <div class="form-button-action">
                                <a  href="{{ route('update-category', $category->id) }} type="button" title="Edit Item" class="btn btn-link btn-primary btn-lg">
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('delete-category', $category->id) }}" onclick="return confirmation(event)" type="button" title="Remove Item" class="btn btn-link btn-danger">
                                  <i class="fas fa-trash-alt"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection