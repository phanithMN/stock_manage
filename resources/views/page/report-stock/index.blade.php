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
                <form action="{{ route('report-stock') }}" method="GET" class="d-flex" id="filterForm">
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
                          <div class="button-export">
                            <a href="{{route('export-stock')}}" class="btn btn-primary d-flex"><i class="fas fa-file-export"></i>Export</a>
                          </div>
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
                          @foreach ($report_stocks as $key => $item)
                            <tr role="row" class="odd">
                              <td>{{ $key }}</td>
                              <td>{{ $item->reference_no }}</td>
                              <td>{{ $item->product_name }}</td>
                              <td><span class="{{$item->status  == "In" ? "color-in" : "color-out" }} status">{{$item->status }}</span></td>
                              <td>{{ $item->created_at->format('Y-m-d') }}</td>
                              <td>{{number_format($item->price)}}៛</td>
                              <td>{{number_format($item->quantity)}}</td>
                              <td>{{number_format($item->quantity * $item->price)}} ៛</td>
                            </tr>
                          @endforeach
                        @endif
                        <tr role="row" class="odd bg-color-total">
                          <td colspan="5" class="text-center">Sub Total</td>
                          <td>
                            @php
                             $stockInPrice = $report_stocks->where('status', 'In')->sum('price');
                             $stockOutPrice = $report_stocks->where('status', 'Out')->sum('price');
                             $stockSpoiledPrice = $report_stocks->where('status', 'Spoiled')->sum('price');
                             $stockReturnPrice = $report_stocks->where('status', 'Return')->sum('price');
                             $totalPrice = ($stockReturnPrice - $stockOutPrice) + ($stockInPrice -  $stockSpoiledPrice)
                            @endphp
                            {{abs($totalPrice)}}៛
                          </td>
                          <td>
                            @php
                              $stockInSum = $report_stocks->where('status', 'In')->sum('quantity');
                              $stockOutSum = $report_stocks->where('status', 'Out')->sum('quantity');
                              $stockSpoiledSum = $report_stocks->where('status', 'Spoiled')->sum('quantity');
                              $stockReturnSum = $report_stocks->where('status', 'Return')->sum('quantity');
                              $totalStock = ($stockInSum - $stockOutSum) +  ($stockSpoiledSum - $stockReturnSum);
                            @endphp
                            {{abs($totalStock)}}
                          </td>
                          <td>
                          {{abs($totalStock * $totalPrice)}}៛
                          </td>
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