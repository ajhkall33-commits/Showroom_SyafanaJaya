<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ASCEND</title>
  <!-- base:css -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('asset/vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/vendors/css/vendor.bundle.base.css') }}">
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('asset/css/vertical-layout-light/style.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}">
  <link rel="shortcut icon" href="{{ asset('asset/images/favicon.png') }}?v=2" />
  <link rel="icon" type="image/png" href="{{ asset('asset/images/favicon.png') }}?v=2" />
  
  <!-- jQuery loaded in head so all modules and inline scripts have immediate access to $ and jQuery -->
  <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
  
  <style>
    :root {
      --primary-color: #0284c7;
      --primary-light: #38bdf8;
      --primary-lighter: #bae6fd;
      --primary-soft: #f0f9ff;
      --primary-soft-bg: #e0f2fe;
      --primary-dark: #0369a1;
      --slate-dark: #0f172a;
      --slate-text: #334155;
      --slate-muted: #64748b;
      --border-soft: #e2e8f0;
      --border-sky: #bae6fd;
      --card-shadow: 0 4px 20px rgba(14, 165, 233, 0.06);
    }

    html, body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
      background: radial-gradient(circle at 50% 28%, #102a4e 0%, #0a1931 55%, #050d1a 100%) fixed !important;
      color: #334155 !important;
      -webkit-font-smoothing: antialiased;
      min-height: 100vh;
    }

    .container-scroller,
    .page-body-wrapper,
    .main-panel,
    .content-wrapper {
      background: transparent !important;
    }

    /* Headings on Dark Blue Dashboard */
    h3.text-dark,
    h4.text-dark,
    .content-wrapper h3.text-dark,
    .main-panel h3.text-dark,
    .content-wrapper h4.text-dark,
    .main-panel h4.text-dark,
    .content-wrapper > .row h3,
    .main-panel > .row h3 {
      color: #ffffff !important;
    }

    .content-wrapper p.text-muted:not(.card *),
    .main-panel p.text-muted:not(.card *) {
      color: #94a3b8 !important;
    }

    /* Top Navbar Matching Login */
    .navbar {
      background: radial-gradient(circle at 20% 50%, #102a4e 0%, #0a1931 60%, #070d1e 100%) !important;
      border-bottom: 1px solid rgba(56, 189, 248, 0.2) !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
    }
    .navbar .navbar-brand-wrapper {
      background: transparent !important;
      border-bottom: 1px solid rgba(56, 189, 248, 0.2) !important;
      border-right: 1px solid rgba(56, 189, 248, 0.15) !important;
      box-shadow: none !important;
    }
    .navbar .navbar-menu-wrapper {
      background: transparent !important;
      border-bottom: 1px solid rgba(56, 189, 248, 0.2) !important;
      box-shadow: none !important;
    }

    /* Cards Menimbul (Elevated 3D floating effect) */
    .card, .stat-card, .chart-card {
      background: linear-gradient(145deg, #e8eaed 0%, #d4d7dc 50%, #c8cbd2 100%) !important;
      border-radius: 16px !important;
      border: 1px solid rgba(180, 185, 195, 0.5) !important;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35), 0 0 25px rgba(2, 132, 199, 0.12), inset 0 1px 0 rgba(255,255,255,0.6) !important;
    }

    /* Completely hide settings floating gear & template panels */
    .theme-setting-wrapper,
    #settings-trigger,
    #theme-settings,
    #right-sidebar {
      display: none !important;
    }

    /* Sidebar Styling - Modern Dark Theme matching Login */
    .sidebar {
      background: radial-gradient(circle at 50% 20%, #0c203c 0%, #081528 70%, #050e1c 100%) !important;
      border-right: 1px solid rgba(56, 189, 248, 0.18) !important;
      box-shadow: 4px 0 25px rgba(0, 0, 0, 0.4) !important;
    }
    .sidebar .nav .nav-item .nav-link {
      color: #94a3b8 !important;
      border-radius: 10px;
      margin: 3px 12px;
      padding: 0.72rem 0.95rem !important;
      transition: all 0.2s ease;
      font-weight: 500;
      font-size: 0.88rem;
    }
    .sidebar .nav .nav-item .nav-link i.menu-icon {
      color: #38bdf8 !important;
      font-size: 1.15rem;
      transition: color 0.2s ease;
    }
    .sidebar .nav .nav-item .nav-link .menu-title {
      color: #cbd5e1 !important;
    }
    .sidebar .nav .nav-item .nav-link:hover {
      background: rgba(2, 132, 199, 0.18) !important;
      color: #38bdf8 !important;
    }
    .sidebar .nav .nav-item .nav-link:hover .menu-title,
    .sidebar .nav .nav-item .nav-link:hover i.menu-icon {
      color: #38bdf8 !important;
    }
    .sidebar .nav .nav-item.active > .nav-link {
      background: linear-gradient(135deg, rgba(2, 132, 199, 0.4) 0%, rgba(56, 189, 248, 0.22) 100%) !important;
      color: #ffffff !important;
      font-weight: 700 !important;
      box-shadow: 0 4px 15px rgba(2, 132, 199, 0.25) !important;
      border: 1px solid rgba(56, 189, 248, 0.4) !important;
    }
    .sidebar .nav .nav-item.active > .nav-link i.menu-icon,
    .sidebar .nav .nav-item.active > .nav-link .menu-title {
      color: #ffffff !important;
      font-weight: 700 !important;
    }
    .sidebar .nav .sub-menu {
      background: rgba(5, 13, 26, 0.8) !important;
      border-radius: 12px;
      margin: 4px 12px;
      padding: 0.5rem 0.75rem !important;
      border: 1px solid rgba(56, 189, 248, 0.12) !important;
    }
    .sidebar .nav .sub-menu .nav-item .nav-link {
      color: #94a3b8 !important;
      font-size: 0.84rem;
    }
    .sidebar .nav .sub-menu .nav-item .nav-link:hover,
    .sidebar .nav .sub-menu .nav-item.active .nav-link {
      color: #38bdf8 !important;
      background: rgba(2, 132, 199, 0.15) !important;
    }

    /* Modern Rotating Dropdown Chevron (replaces clumsy + / -) */
    .sidebar .nav .nav-item .nav-link i.menu-arrow {
      margin-left: auto;
      transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sidebar .nav .nav-item .nav-link i.menu-arrow:before {
      content: "\e047" !important; /* Typicons chevron right */
      font-family: "typicons" !important;
      font-size: 0.8rem !important;
      color: #94a3b8 !important;
      display: inline-block;
    }
    .sidebar .nav .nav-item .nav-link[aria-expanded="true"] i.menu-arrow {
      transform: rotate(90deg);
    }
    .sidebar .nav .nav-item .nav-link[aria-expanded="true"] i.menu-arrow:before {
      color: #0284c7 !important;
    }

    /* Submenus - Clean Hierarchical Tree without clumsy bullets */
    .sidebar .nav.sub-menu {
      padding: 0.35rem 0 0.5rem 0.75rem !important;
      margin-left: 1.5rem !important;
      border-left: 2px solid #e0f2fe !important;
      margin-top: 0.2rem;
      margin-bottom: 0.35rem;
    }
    .sidebar .nav.sub-menu .nav-item::before {
      display: none !important;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link {
      color: #64748b !important;
      border-radius: 8px;
      font-size: 0.84rem !important;
      padding: 0.45rem 0.75rem !important;
      margin: 1px 0 !important;
      font-weight: 500;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link:hover {
      color: #0284c7 !important;
      background: #f0f9ff !important;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link.active,
    .sidebar .nav.sub-menu .nav-item.active > .nav-link {
      color: #0284c7 !important;
      font-weight: 700 !important;
      background: #e0f2fe !important;
    }

    /* Nested Submenu (Penilaian Kerja) */
    .sidebar .nav.sub-menu .nav-item .collapse .sub-menu {
      padding-left: 0.75rem !important;
      border-left: 2px solid #bae6fd !important;
      margin-left: 0.75rem !important;
      margin-top: 0.25rem;
      margin-bottom: 0.4rem;
    }
    .sidebar .nav.sub-menu .nav-item .collapse .sub-menu .nav-item::before {
      display: none !important;
    }
    .sidebar .nav.sub-menu .nav-item .collapse .sub-menu .nav-item .nav-link {
      padding: 0.4rem 0.65rem !important;
      font-size: 0.8rem !important;
      color: #64748b !important;
      border-radius: 6px;
      transition: all 0.2s ease;
    }
    .sidebar .nav.sub-menu .nav-item .collapse .sub-menu .nav-item .nav-link:hover,
    .sidebar .nav.sub-menu .nav-item .collapse .sub-menu .nav-item.active > .nav-link {
      color: #0284c7 !important;
      background-color: #e0f2fe !important;
      font-weight: 700 !important;
    }

    /* Cards - Aesthetic Clean & Airy */
    .card {
      border-radius: 16px !important;
      border: 1px solid #e0f2fe !important;
      box-shadow: 0 4px 20px rgba(14, 165, 233, 0.05) !important;
      background: #ffffff !important;
      margin-bottom: 1.5rem;
      transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .card:hover {
      box-shadow: 0 6px 24px rgba(14, 165, 233, 0.08) !important;
    }
    .card-body {
      padding: 1.35rem !important;
    }
    .card-title, h3, h4, h5 {
      color: #0f172a !important;
      font-weight: 700;
    }

    /* Buttons - Aesthetic Light Blue */
    .btn {
      border-radius: 10px !important;
      font-weight: 600 !important;
      font-size: 0.85rem !important;
      padding: 0.55rem 1.15rem !important;
      transition: all 0.2s ease !important;
    }
    .btn-primary {
      background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%) !important;
      border: none !important;
      color: #ffffff !important;
      box-shadow: 0 3px 12px rgba(14, 165, 233, 0.3) !important;
    }
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
      box-shadow: 0 6px 16px rgba(14, 165, 233, 0.42) !important;
      transform: translateY(-1px);
    }
    .btn-outline-primary {
      border: 1.5px solid #38bdf8 !important;
      color: #0284c7 !important;
      background: transparent !important;
    }
    .btn-outline-primary:hover {
      background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%) !important;
      color: #ffffff !important;
      border-color: transparent !important;
    }
    .btn-info {
      background: linear-gradient(135deg, #7dd3fc 0%, #0284c7 100%) !important;
      border: none !important;
      color: #ffffff !important;
      box-shadow: 0 3px 10px rgba(56, 189, 248, 0.25) !important;
    }
    .btn-success {
      background: linear-gradient(135deg, #34d399 0%, #059669 100%) !important;
      border: none !important;
      color: #ffffff !important;
      box-shadow: 0 3px 10px rgba(16, 185, 129, 0.25) !important;
    }
    .btn-warning {
      background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%) !important;
      border: none !important;
      color: #ffffff !important;
      box-shadow: 0 3px 10px rgba(245, 158, 11, 0.25) !important;
    }
    .btn-danger {
      background: linear-gradient(135deg, #f87171 0%, #dc2626 100%) !important;
      border: none !important;
      color: #ffffff !important;
      box-shadow: 0 3px 10px rgba(239, 68, 68, 0.25) !important;
    }

    /* Forms, Inputs, Selects */
    .form-control, .custom-select, select {
      border-radius: 10px !important;
      font-size: 0.88rem !important;
      border: 1.5px solid #bae6fd !important;
      padding: 0.55rem 0.85rem !important;
      height: auto !important;
      background-color: #ffffff !important;
      transition: all 0.2s ease !important;
    }
    .form-control:focus, select:focus, .custom-select:focus {
      border-color: #38bdf8 !important;
      box-shadow: 0 0 0 3.5px rgba(56, 189, 248, 0.25) !important;
      outline: none !important;
    }

    /* Tables - Clean, Fresh Sky Theme */
    .table-responsive {
      border-radius: 12px;
      overflow-x: auto !important;
      -webkit-overflow-scrolling: touch !important;
      width: 100% !important;
      margin-bottom: 1rem;
      border: 1px solid #e0f2fe;
    }
    .table-responsive::-webkit-scrollbar {
      height: 6px;
    }
    .table-responsive::-webkit-scrollbar-track {
      background: #f0f9ff;
    }
    .table-responsive::-webkit-scrollbar-thumb {
      background: #bae6fd;
      border-radius: 4px;
    }
    .table {
      width: 100% !important;
      margin-bottom: 0 !important;
    }
    .table thead th {
      background-color: #f0f9ff !important;
      color: #0369a1 !important;
      font-weight: 700 !important;
      font-size: 0.8rem !important;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #bae6fd !important;
      border-top: none !important;
      padding: 0.85rem 1rem !important;
      white-space: nowrap;
    }
    .table tbody td {
      vertical-align: middle !important;
      font-size: 0.88rem !important;
      padding: 0.85rem 1rem !important;
      border-top: 1px solid #f1f5f9 !important;
      color: #334155;
    }
    .table-hover tbody tr:hover {
      background-color: rgba(56, 189, 248, 0.05) !important;
    }

    /* Badges */
    .badge {
      border-radius: 8px;
      font-weight: 600;
      padding: 0.4rem 0.75rem;
    }
    .badge-primary {
      background: #e0f2fe !important;
      color: #0369a1 !important;
      border: 1px solid #bae6fd !important;
    }
    .badge-success {
      background: #dcfce7 !important;
      color: #15803d !important;
      border: 1px solid #bbf7d0 !important;
    }
    .badge-warning {
      background: #fef9c3 !important;
      color: #a16207 !important;
      border: 1px solid #fef08a !important;
    }
    .badge-danger {
      background: #fee2e2 !important;
      color: #b91c1c !important;
      border: 1px solid #fecaca !important;
    }

    /* Modals - Aesthetic Light Blue */
    .modal-content {
      border-radius: 18px !important;
      border: 1px solid #bae6fd !important;
      box-shadow: 0 20px 40px rgba(14, 165, 233, 0.15) !important;
      overflow: hidden;
    }
    .modal-header {
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important;
      border-bottom: 1px solid #bae6fd !important;
      padding: 1.15rem 1.5rem !important;
    }
    .modal-header .modal-title {
      color: #0369a1 !important;
      font-weight: 700 !important;
    }
    .modal-footer {
      border-top: 1px solid #f0f9ff !important;
      padding: 1rem 1.5rem !important;
    }

    /* Primary Accent Utilities */
    .text-primary {
      color: #0284c7 !important;
    }
    .bg-primary {
      background-color: #0ea5e9 !important;
    }

    /* Mobile responsive optimizations */
    @media (max-width: 991.98px) {
      .navbar {
        left: 0;
      }
      .content-wrapper {
        padding: 1rem !important;
      }
      .main-panel {
        width: 100% !important;
      }
      .card-body {
        padding: 1rem !important;
      }
      .page-title, h4, h3 {
        font-size: 1.25rem !important;
      }
      .table th, .table td {
        padding: 0.6rem !important;
        font-size: 0.82rem !important;
        white-space: nowrap;
      }
    }
  </style>

  @yield('style')
 
</head>
<body>
 
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    
    @include('layouts.header')

    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      @include('layouts.navbar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

         
          @yield('content')
          {{-- <div class="row">
            <div class="col-xl-6 grid-margin stretch-card flex-column">
                <h5 class="mb-2 text-titlecase mb-4">Status statistics</h5>
              <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <p class="mb-0 text-muted">Transactions</p>
                        <p class="mb-0 text-muted">+1.37%</p>
                      </div>
                      <h4>1352</h4>
                      <canvas id="transactions-chart" class="mt-auto" height="65"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                          <p class="mb-2 text-muted">Sales</p>
                          <h6 class="mb-0">563</h6>
                        </div>
                        <div>
                          <p class="mb-2 text-muted">Orders</p>
                          <h6 class="mb-0">720</h6>
                        </div>
                        <div>
                          <p class="mb-2 text-muted">Revenue</p>
                          <h6 class="mb-0">5900</h6>
                        </div>
                      </div>
                      <canvas id="sales-chart-a" class="mt-auto" height="65"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row h-100">
                <div class="col-md-6 stretch-card grid-margin grid-margin-md-0">
                  <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <p class="text-muted">Sales Analytics</p>
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="mb-">27632</h3>
                        <h3 class="mb-">78%</h3>
                      </div>
                      <canvas id="sales-chart-b" class="mt-auto" height="38"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="row h-100">
                        <div class="col-6 d-flex flex-column justify-content-between">
                          <p class="text-muted">CPU</p>
                          <h4>55%</h4>
                          <canvas id="cpu-chart" class="mt-auto"></canvas>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-between">
                          <p class="text-muted">Memory</p>
                          <h4>123,65</h4>
                          <canvas id="memory-chart" class="mt-auto"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 grid-margin stretch-card flex-column">
              <h5 class="mb-2 text-titlecase mb-4">Income statistics</h5>
              <div class="row h-100">
                <div class="col-md-12 stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                          <p class="mb-3">Monthly Increase</p>
                          <h3>67842</h3>
                        </div>
                        <div id="income-chart-legend" class="d-flex flex-wrap mt-1 mt-md-0"></div>
                      </div>
                      <canvas id="income-chart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body border-bottom">
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-2 mb-md-0 text-uppercase font-weight-medium">Overall sales</h6>
                    <div class="dropdown">
                      <button class="btn bg-white p-0 pb-1 text-muted btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Last 30 days
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                        <h6 class="dropdown-header">Settings</h6>
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="sales-chart-c" class="mt-2"></canvas>
                  <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 mt-4">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">Gross Sales</p>
                      <h5>492</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-success mb-0">0.5%</p>
                        <i class="typcn typcn-arrow-up-thick text-success"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">Purchases</p>
                      <h5>87k</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-success mb-0">0.8%</p>
                        <i class="typcn typcn-arrow-up-thick text-success"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">Tax Return</p>
                      <h5>882</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-danger mb-0">-04%</p>
                        <i class="typcn typcn-arrow-down-thick text-danger"></i>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="dropdown">
                      <button class="btn bg-white p-0 pb-1 pt-1 text-muted btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Last 7 days
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                        <h6 class="dropdown-header">Settings</h6>
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                      </div>
                    </div>
                    <p class="mb-0">overview</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-4 grid-margin stretch-card">
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card newsletter-card bg-gradient-warning">
                    <div class="card-body">
                      <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <h5 class="mb-3 text-white">Newsletter</h5>
                        <form class="form d-flex flex-column align-items-center justify-content-between w-100">
                          <div class="form-group mb-2 w-100">
                            <input type="text" class="form-control" placeholder="email address">
                          </div>
                          <button class="btn btn-danger btn-rounded mt-1" type="submit">Subscribe</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 stretch-card">
                  <div class="card profile-card bg-gradient-primary">
                    <div class="card-body">
                      <div class="row align-items-center h-100">
                        <div class="col-md-4">
                          <figure class="avatar mx-auto mb-4 mb-md-0">
                            <img src="images/faces/face20.jpg" alt="avatar">
                          </figure>
                        </div>
                        <div class="col-md-8">
                          <h5 class="text-white text-center text-md-left">Phoebe Kennedy</h5>
                          <p class="text-white text-center text-md-left">kennedy@gmail.com</p>
                          <div class="d-flex align-items-center justify-content-between info pt-2">
                            <div>
                              <p class="text-white font-weight-bold">Birth date</p>
                              <p class="text-white font-weight-bold">Birth city</p>
                            </div>
                            <div>
                              <p class="text-white">16 Sep 2019</p>
                              <p class="text-white">Netherlands</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body border-bottom">
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-2 mb-md-0 text-uppercase font-weight-medium">Sales statistics</h6>
                    <div class="dropdown">
                      <button class="btn bg-white p-0 pb-1 text-muted btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Last 7 days
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton4">
                        <h6 class="dropdown-header">Settings</h6>
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="sales-chart-d" height="320"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                      <p class="mb-2 text-md-center text-lg-left">Total Expenses</p>
                      <h1 class="mb-0">8742</h1>
                    </div>
                    <i class="typcn typcn-briefcase icon-xl text-secondary"></i>
                  </div>
                  <canvas id="expense-chart" height="80"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                      <p class="mb-2 text-md-center text-lg-left">Total Budget</p>
                      <h1 class="mb-0">47,840</h1>
                    </div>
                    <i class="typcn typcn-chart-pie icon-xl text-secondary"></i>
                  </div>
                  <canvas id="budget-chart" height="80"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                      <p class="mb-2 text-md-center text-lg-left">Total Balance</p>
                      <h1 class="mb-0">$7,243</h1>
                    </div>
                    <i class="typcn typcn-clipboard icon-xl text-secondary"></i>
                  </div>
                  <canvas id="balance-chart" height="80"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="table-responsive pt-3">
                  <table class="table table-striped project-orders-table">
                    <thead>
                      <tr>
                        <th class="ml-5">ID</th>
                        <th>Project name</th>
                        <th>Customer</th>
                        <th>Deadline</th>
                        <th>Payouts	</th>
                        <th>Traffic</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>#D1</td>
                        <td>Consectetur adipisicing elit </td>
                        <td>Beulah Cummings</td>
                        <td>03 Jan 2019</td>
                        <td>$ 5235</td>
                        <td>1.3K</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                              Edit
                              <i class="typcn typcn-edit btn-icon-append"></i>                          
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                              Delete
                              <i class="typcn typcn-delete-outline btn-icon-append"></i>                          
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#D2</td>
                        <td>Correlation natural resources silo</td>
                        <td>Mitchel Dunford</td>
                        <td>09 Oct 2019</td>
                        <td>$ 3233</td>
                        <td>5.4K</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                              Edit
                              <i class="typcn typcn-edit btn-icon-append"></i>                          
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                              Delete
                              <i class="typcn typcn-delete-outline btn-icon-append"></i>                          
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#D3</td>
                        <td>social capital compassion social</td>
                        <td>Pei Canaday</td>
                        <td>18 Jun 2019</td>
                        <td>$ 4311</td>
                        <td>2.1K</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                              Edit
                              <i class="typcn typcn-edit btn-icon-append"></i>                          
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                              Delete
                              <i class="typcn typcn-delete-outline btn-icon-append"></i>                          
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#D4</td>
                        <td>empower communities thought</td>
                        <td>Gaynell Sharpton</td>
                        <td>23 Mar 2019</td>
                        <td>$ 7743</td>
                        <td>2.7K</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                              Edit
                              <i class="typcn typcn-edit btn-icon-append"></i>                          
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                              Delete
                              <i class="typcn typcn-delete-outline btn-icon-append"></i>                          
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>#D5</td>
                        <td> Targeted effective; mobilize </td>
                        <td>Audrie Midyett</td>
                        <td>22 Aug 2019</td>
                        <td>$ 2455</td>
                        <td>1.2K</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                              Edit
                              <i class="typcn typcn-edit btn-icon-append"></i>                          
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                              Delete
                              <i class="typcn typcn-delete-outline btn-icon-append"></i>                          
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> --}}

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        {{-- <footer class="footer">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="https://www.bootstrapdash.com/" class="text-muted" target="_blank">Bootstrapdash</a>. All rights reserved.<br>
                        
                          Distributed By: <a href="https://www.themewagon.com/" class="text-muted" target="_blank">ThemeWagon</a>
                        
                        </span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center text-muted">Free <a href="https://www.bootstrapdash.com/" class="text-muted" target="_blank">Bootstrap dashboard</a> templates from Bootstrapdash.com</span>
                    </div>
                </div>    
            </div>        
        </footer> --}}
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="{{ asset('asset/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="{{ asset('asset/vendors/chart.js/Chart.min.js') }}"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('asset/js/off-canvas.js') }}"></script>
  <script src="{{ asset('asset/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('asset/js/template.js') }}"></script>
  <script src="{{ asset('asset/js/settings.js') }}"></script>
  <script src="{{ asset('asset/js/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('asset/js/dashboard.js') }}"></script>
  <!-- End custom js for this page-->

  <!-- DataTables & Select2 Plugins -->
  <script src="{{ asset('asset/plugins/select2/js/select2.min.js') }}"></script>
  <script src="{{ asset('asset/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('asset/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>

  <script src="{{ asset('asset/js/popper.min.js') }}"></script>
  <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('asset/plugins/simplebar/js/simplebar.js') }}"></script>
  <script src="{{ asset('asset/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('asset/js/app-script.js') }}"></script>
  <script src="{{ asset('asset/js/index.js') }}"></script>
  <script src="{{ asset('asset/plugins/notifications/js/lobibox.min.js') }}"></script>
  <script src="{{ asset('asset/plugins/notifications/js/notifications.min.js') }}"></script>
  <script src="{{ asset('asset/plugins/notifications/js/notification-custom-script.js') }}"></script>
  <script src="{{ asset('asset/plugins/alerts-boxes/js/sweetalert.min.js') }}"></script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    // Nested collapse handler for Penilaian Kerja sidebar
    $('#penilaian-kerja').on('click', '[data-toggle="collapse"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var targetId = $(this).attr('href') || $(this).data('target');
        var $target = $(targetId);
        if ($target.length) {
            $target.collapse('toggle');
            var isExpanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !isExpanded);
        }
    });

    $('#penilaian-kerja').on('show.bs.collapse', '.collapse', function(e) {
        e.stopPropagation();
        var $this = $(this);
        // Pastikan menu induk #penilaian-kerja selalu tetap terbuka
        $('#penilaian-kerja').addClass('show');
        // Tutup sub-menu lain yang setara di dalam #penilaian-kerja jika dibuka
        $('#penilaian-kerja').find('.collapse.show').not($this).collapse('hide');
    });

    $('#penilaian-kerja').on('hide.bs.collapse', '.collapse', function(e) {
        e.stopPropagation();
    });
});
</script>

@yield('script')

</body>

</html>

