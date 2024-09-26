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
                  <div class="col-sm-12 col-md-10 d-flex fill-right">
                    <!-- <div class="form-controll-fillter">
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
                    </div> -->
                    <div id="add-row_filter" class="dataTables_filter">
                      <form action="{{ route('report-stock') }}" method="GET" class="d-flex" id="filterForm">
                        <div class="input-filter d-flex">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date"
                            class="form-control form-control-sm"
                            value="{{ request('start_date') }}"
                            onchange="document.getElementById('filterForm').submit();">
                        </div>

                        <div class="input-filter d-flex">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date"
                            class="form-control form-control-sm"
                            value="{{ request('end_date') }}"
                            onchange="document.getElementById('filterForm').submit();">
                        </div>
                        <div class="search-filter">
                          <input 
                          type="search" 
                          name="search" 
                          class="form-control form-control-sm" 
                          placeholder="Search..." 
                          aria-label="Search..." 
                          value="{{ request('search')}}"
                          onchange="document.getElementById('filterForm').submit();" 
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
                          <th>Reference No</th>
                          <th>Name</th>
                          <th>Status</th>
                          <th>Date</th>
                          <th>Price</th>
                          <th>Quntity</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($report_stocks->isEmpty())
                            <td colspan="8" class="none-report">No Stock Response</td>
                        @else
                          @foreach ($report_stocks as $item)
                            <tr role="row" class="odd">
                              <td>{{ $item->reference_no }}</td>
                              <td>{{ $item->product_name }}</td>
                              <td><span class="{{ $item->status == 'Income' ? 'color-income' : 'color-return' }} status">{{ $item->status }}</span></td>
                              <td>{{ $item->created_at->format('Y-m-d') }}</td>
                              <td>{{number_format($item->price)}}៛</td>
                              <td>{{$item->quantity}}</td>
                              <td>{{number_format($item->quantity * $item->price)}} ៛</td>
                            </tr>
                          @endforeach
                        @endif
                        <tr role="row" class="odd bg-color-total">
                          <td colspan="4" class="text-center">Sub Total</td>
                          <td>{{number_format($report_stocks->sum('price'))}}៛</td>
                          <td>{{$report_stocks->sum('quantity')}}</td>
                          <td>{{number_format($report_stocks->sum('quantity') * $report_stocks->sum('price'))}}៛</td>
                        </tr>
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