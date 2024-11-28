@extends('layout.app')
@section('title') {{'Report Revenue'}} @endsection
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
                <form action="{{ route('report-product') }}" method="GET" class="d-flex" id="filterForm">
                  <div class="row" style="width: 100%;">
                    <div class="col-sm-12 col-md-2">
                      <div class="dataTables_length" id="add-row_length">
                        <label>
                          Show 
                          <select id="add_row_length" name="add_row_length" aria-controls="add-row" class="form-control form-control-sm" onchange="document.getElementById('filterForm').submit();">
                            <option value="10" {{ request('add_row_length') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('add_row_length') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('add_row_length') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('add_row_length') == 100 ? 'selected' : '' }}>100</option>
                          </select> entries 
                        </label>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-10 d-flex fill-right">
                      <div id="add-row_filter" class="dataTables_filter d-flex">
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
                      </div>
                      <div class="button-export">
                        <a href="{{ route('export-product') }}" class="btn btn-primary d-flex"><i class="fas fa-file-export"></i>Export</a>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="row m-0">
                  <div class="col-sm-12 p-0">
                    <table id="add-row" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                      <thead>
                        <tr role="row">
                          <th>#</th>
                          <th>Name</th>
                          <th>Date</th>
                          <th>Stock In</th>
                          <th>Stock Out</th>
                          <th>Total Revenue</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($report_product->isEmpty())
                            <td colspan="8" class="none-report">No Stock Response</td>
                        @else
                          @foreach ($report_product as $key => $item)
                            <tr role="row" class="odd">
                                <td>{{ $key }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                <td>{{$item->status == 'In' ? $item->stock_price * $item->stock_quantity : '0'}}៛</td>
                                <td>{{$item->status == 'Out' ? $item->stock_price * $item->stock_quantity : '0'}}៛</td>
                                <td>{{number_format(($item->status == 'In' ? $item->stock_price * $item->stock_quantity : '0') - ($item->status == 'Out' ? $item->stock_price * $item->stock_quantity : '0'))}}៛</td>
                            </tr>
                          @endforeach
                        @endif
                        <tr role="row" class="odd bg-color-total">
                          <td colspan="3" class="text-center">Sub Total Revenue</td>
                          <td>
                            <?php
                              $sum_price = $report_product->where('status', 'In')->sum('stock_price');
                              $sum_quantity = $report_product->where('status', 'In')->sum('stock_quantity');

                              $total_stock_in = $sum_price * $sum_quantity;
                            ?>
                            {{number_format($total_stock_in)}}៛
                          </td>
                          <td>
                            <?php
                              $sum_price = $report_product->where('status', 'Out')->sum('stock_price');
                              $sum_quantity = $report_product->where('status', 'Out')->sum('stock_quantity');

                              $total_stock_out = $sum_price * $sum_quantity;
                            ?>
                            {{number_format($total_stock_out)}}៛
                          </td>
                          <td>{{number_format($total_stock_in-$total_stock_out)}}៛</td>
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