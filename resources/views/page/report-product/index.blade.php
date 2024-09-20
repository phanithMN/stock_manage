@extends('layout.app')
@section('title') {{'Report Product'}} @endsection
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
                    <div id="add-row_filter" class="dataTables_filter">
                      <form action="{{ route('report-product') }}" method="GET" class="d-flex" id="filterForm">
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
                      <a href="{{ route('export-product') }}" class="btn btn-primary d-flex"><i class="fas fa-file-export"></i>Export</a>
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
                          <th>Date</th>
                          <th>Cost Price</th>
                          <th>Price</th>
                          <th>Quntity</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($report_product->isEmpty())
                            <td colspan="8" class="none-report">No Stock Response</td>
                        @else
                          @foreach ($report_product as $item)
                            <tr role="row" class="odd">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                <td>{{number_format($item->cost_price, 2)}}៛</td>
                                <td>{{number_format($item->price, 2)}}៛</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->quantity * $item->price, 2)}}៛</td>
                            </tr>
                          @endforeach
                        @endif
                        <tr role="row" class="odd bg-color-total">
                          <td colspan="3" class="text-center">Sub Total</td>
                          <td>{{number_format($report_product->sum('cost_price'), 2)}}៛</td>
                          <td>{{number_format($report_product->sum('price'), 2)}}៛</td>
                          <td>{{$report_product->sum('quantity')}}</td>
                          <td>{{number_format($report_product->sum('quantity') * $report_product->sum('price'), 2)}}៛</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="10" class="pagination-table">
                            {{$report_product->onEachSide(1)->links()}}
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