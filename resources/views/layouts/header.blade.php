<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="background: radial-gradient(circle at 20% 50%, #102a4e 0%, #0a1931 60%, #070d1e 100%) !important; border-bottom: 1px solid rgba(56, 189, 248, 0.2) !important; box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;">
    <div class="navbar-brand-wrapper d-flex justify-content-between align-items-center px-3" style="background: transparent !important; border-bottom: 1px solid rgba(56, 189, 248, 0.2) !important; border-right: 1px solid rgba(56, 189, 248, 0.15) !important;">
        <a class="navbar-brand brand-logo d-none d-lg-flex align-items-center text-decoration-none" href="{{ route('home') }}">
            <img src="{{ asset('asset/images/logo-ascend-square.png') }}" alt="Logo ASCEND" class="mr-2" style="width: 38px; height: 38px; border-radius: 9px; object-fit: cover; box-shadow: 0 2px 10px rgba(2, 132, 199, 0.35); border: 1px solid rgba(56, 189, 248, 0.3);">
            <div class="d-flex flex-column text-left">
                <span class="font-weight-bold" style="color: #ffffff; font-size: 1.08rem; letter-spacing: 0.3px; line-height: 1.15;">ASCEND</span>
                <span style="color: #7dd3fc; font-size: 0.65rem; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">PT. IAS SUPPORT INDONESIA</span>
            </div>
        </a>
        <a class="navbar-brand brand-logo-mini d-lg-none d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
            <img src="{{ asset('asset/images/logo-ascend-square.png') }}" alt="Logo ASCEND" style="width: 34px; height: 34px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 6px rgba(2, 132, 199, 0.3); border: 1px solid rgba(56, 189, 248, 0.3);">
        </a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-block p-1 border-0 bg-transparent" type="button" data-toggle="minimize" style="color: #94a3b8; transition: color 0.2s ease;">
            <span class="typcn typcn-th-menu" style="font-size: 1.25rem;"></span>
        </button>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end px-3" style="background: transparent !important; border-bottom: 1px solid rgba(56, 189, 248, 0.2) !important;">
        <ul class="navbar-nav navbar-nav-right d-flex align-items-center">
            <li class="nav-item d-flex align-items-center mr-2 mr-md-3">
                <div class="badge badge-pill px-3 py-1.5 d-flex align-items-center" style="font-size: 0.84rem; font-weight: 600; background: rgba(2, 132, 199, 0.18); color: #e0f2fe; border: 1px solid rgba(56, 189, 248, 0.35);">
                    <div class="rounded-circle mr-2 d-flex align-items-center justify-content-center text-white" style="width: 22px; height: 22px; background: #0284c7; font-size: 0.72rem;">
                        <i class="typcn typcn-user"></i>
                    </div>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </li>
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="btn btn-sm d-flex align-items-center px-3 py-1.5 font-weight-bold" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-radius: 20px; font-size: 0.8rem; background: rgba(225, 29, 72, 0.15); color: #fda4af; border: 1px solid rgba(244, 63, 94, 0.35); transition: all 0.2s ease;">
                    <i class="typcn typcn-power mr-1" style="font-size: 0.95rem;"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- partial -->
{{-- <nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
    <div class="navbar-links-wrapper d-flex align-items-stretch" style="opacity: 0">
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-calendar-outline"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-mail"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-folder"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-document-text"></i></a>
        </div>
    </div> --}}
    {{-- <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item ml-0">
                <h4 class="mb-0">Dashboard</h4>
            </li>
            <li class="nav-item">
            <div class="d-flex align-items-baseline">
              <p class="mb-0">Home</p>
              <i class="typcn typcn-chevron-right"></i>
              <p class="mb-0">Main Dahboard</p>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-search d-none d-md-block mr-0">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search..." aria-label="search" aria-describedby="search">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="typcn typcn-zoom"></i>
                </span>
              </div>
            </div>
          </li>
        </ul>
    </div> --}}
{{-- </nav> --}}
