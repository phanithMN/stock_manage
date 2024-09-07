@extends('layout.app')
@section('title') {{'Report Stock'}} @endsection
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
          <div class="card-body">
            <div class="table-responsive">
              <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 p-0">
                <div class="row">
                  <div class="col-sm-12 col-md-2">
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
                    </div>
                  </div>
                  <d class="col-sm-12 col-md-10 d-flex fill-right">
                    <div class="form-controll-fillter">
                      <select class="form-select form-select-sm" id="category"  name="category">
                        <option value="">Chosse Category</option>
                        @foreach ($categories as $category )
                        <option value="{{$category->name}}" {{ request('category') == $category->name ? 'selected' : '' }}>{{$category->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-controll-fillter">
                      <select class="form-select form-select-sm" id="status_name"  name="status_name">
                        <option value="">Chosse Status</option>
                        @foreach ($status as $status_item )
                        <option value="{{$status_item->name}}" {{ request('status_name') == $status_item->name ? 'selected' : '' }}>{{$status_item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div id="add-row_filter" class="dataTables_filter">
                      <form action="{{ route('report-stock') }}" method="GET" id="reportForm">
                        @csrf
                        <div class="d-flex">
                          <input 
                            type="date" 
                            name="date" 
                            class="form-control form-control-sm" 
                            id="dateForm"
                            value="{{$date}}"
                            onchange="document.getElementById('reportForm').submit();" 
                          />
                          <input 
                          type="search" 
                          name="search" 
                          class="form-control form-control-sm" 
                          placeholder="Search..." 
                          aria-label="Search..." 
                          value="{{$search_value}}"
                          onchange="document.getElementById('reportForm').submit();" 
                          />
                        </div>
                      </form>
                    </div>
                    <div class="button-export">
                      <a href="{{ route('export-stock') }}" class="btn btn-primary d-flex"><i class="fas fa-file-export"></i>Export</a>
                    </div>
                  </div>
                </div>
                <div class="row m-0">
                  <div class="col-sm-12 p-0">
                    <table id="add-row" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                      <thead>
                        <tr role="row">
                          <th>Name</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($report_stocks->isEmpty())
                            <td colspan="4" class="none-report">No Stock Response</td>
                        @else
                          @foreach ($report_stocks as $item)
                              <tr role="row" class="odd">
                                  <td>{{ $item->name }}</td>
                                  <td>{{ $item->category_name }}</td>
                                  <td><span class="{{ $item->status_name == 'Income' ? 'color-income' : 'color-return' }} status">{{ $item->status_name }}</span></td>
                                  <td>{{ $item->created_at->format('Y-m-d') }}</td>
                              </tr>
                          @endforeach
                        @endif
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="10" class="pagination-table">
                            {{$report_stocks->onEachSide(1)->links()}}
                          </td>
                        </tr>
                      </tfoot>
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