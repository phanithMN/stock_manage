<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
        <a href="{{route('dashboad')}}" class="logo">
            <img
            src="/assets/img/kaiadmin/logo_light.png"
            alt="navbar brand"
            class="navbar-brand"
            width="180"
            />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item">
                <a
                    href="{{ route('dashboad') }}"
                >
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Stock Management</h4>
            </li>
            <li class="nav-item">
                <a href="{{route('category')}}">
                    <i class="fas fa-box"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a
                  data-bs-toggle="collapse"
                  href="#stock"
                  class="collapsed"
                  aria-expanded="false"
                >
                    <i class="fas fa-box-open"></i>
                  <p>Stock</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="stock">
                  <ul class="nav nav-collapse">
                    <li>
                        <a href="{{route('stock')}}">
                            <p class="sub-item">Stock IN</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('stock-out')}}">
                            <p class="sub-item">Stock OUT</p>
                        </a>
                    </li>
                  </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{route('unit-of-measure')}}">
                    <i class="fas fa-boxes"></i>
                    <p>Unit</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Manage Product</h4>
            </li>
            <li class="nav-item">
                <a href="{{route('product')}}">
                    <i class="fas fa-database"></i>
                    <p>Product</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fas fa-clipboard-list"></i>
                </span>
                <h4 class="text-section">Manage Report</h4>
            </li>
            <li class="nav-item">
                <a
                  data-bs-toggle="collapse"
                  href="#report"
                  class="collapsed"
                  aria-expanded="false"
                >
                    <i class="fas fa-clipboard-list"></i>
                    <p>Report</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="report">
                  <ul class="nav nav-collapse">
                    <li>
                        <a href="{{route('report-stock')}}">
                            <p class="sub-item">Reprot Stock</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('report-product')}}">
                            <p class="sub-item">Reprot Product</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('report-revenue')}}">
                            <p class="sub-item">Report Revenue</p>
                        </a>
                    </li>
                  </ul>
                </div>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Setting</h4>
            </li>
            <li class="nav-item">
                <a href="{{route('user')}}">
                    <i class="fas fa-user"></i>
                    <p>User</p>
                </a>
            </li>
            
            <li class="nav-item">
                <a
                  data-bs-toggle="collapse"
                  href="#setting"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-cog"></i>
                  <p>Setting</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="setting">
                  <ul class="nav nav-collapse">
                    <li>
                        <a href="{{route('role')}}">
                            <p class="sub-item">Role</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('permission')}}">
                            <p class="sub-item">Permission</p>
                        </a>
                    </li>
                    <li>
                      <a href="{{route('account-setting')}}">
                        <span class="sub-item">Account Setting</span>
                      </a>
                    </li>
                  </ul>
                </div>
            </li>
        </ul>
        </div>
    </div>
</div>
    <!-- End Sidebar -->