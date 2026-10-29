<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ASCEND - Register</title>
  <!-- base:css -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('asset/vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/vendors/css/vendor.bundle.base.css') }}">
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('asset/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('asset/images/favicon.png') }}?v=2" />
  <link rel="icon" type="image/png" href="{{ asset('asset/images/favicon.png') }}?v=2" />

  <style>
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
      background: radial-gradient(circle at 50% 28%, #102a4e 0%, #0a1931 55%, #050d1a 100%) !important;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .container-scroller,
    .page-body-wrapper,
    .content-wrapper {
      background: transparent !important;
      min-height: 100vh;
    }

    /* Kotak Menimbul (Elevated 3D Floating Card) */
    .auth-form-light {
      background: #ffffff !important;
      border-radius: 20px !important;
      padding: 2.5rem 2.2rem !important;
      border: 1px solid rgba(255, 255, 255, 0.25) !important;
      box-shadow: 
        0 24px 60px -10px rgba(0, 0, 0, 0.55),
        0 10px 25px -5px rgba(0, 0, 0, 0.35),
        0 0 45px rgba(2, 132, 199, 0.22) !important;
      position: relative;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .auth-form-light:hover {
      box-shadow: 
        0 30px 70px -10px rgba(0, 0, 0, 0.65),
        0 14px 30px -5px rgba(0, 0, 0, 0.4),
        0 0 55px rgba(2, 132, 199, 0.3) !important;
      transform: translateY(-2px);
    }

    .brand-logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 1.25rem;
    }

    .brand-logo-img {
      height: 48px;
      width: auto;
      max-width: 215px;
      object-fit: contain;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(2, 132, 199, 0.28);
    }

    .form-control-lg {
      border-radius: 10px !important;
      border: 1.5px solid #cbd5e1 !important;
      font-size: 0.95rem !important;
      padding: 0.75rem 1rem !important;
      height: auto !important;
      transition: all 0.2s ease !important;
    }

    .form-control-lg:focus {
      border-color: #0284c7 !important;
      box-shadow: 0 0 0 3.5px rgba(2, 132, 199, 0.22) !important;
    }

    .btn-primary.auth-form-btn {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
      border: none !important;
      border-radius: 10px !important;
      font-size: 0.95rem !important;
      font-weight: 700 !important;
      letter-spacing: 0.5px !important;
      padding: 0.8rem 1.5rem !important;
      box-shadow: 0 6px 18px rgba(2, 132, 199, 0.35) !important;
      transition: all 0.2s ease !important;
    }

    .btn-primary.auth-form-btn:hover {
      background: linear-gradient(135deg, #0369a1 0%, #075985 100%) !important;
      box-shadow: 0 8px 24px rgba(2, 132, 199, 0.5) !important;
      transform: translateY(-1px);
    }

    .auth-link {
      color: #0284c7 !important;
      font-weight: 600;
      font-size: 0.85rem;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 col-md-6 col-sm-8 mx-auto px-3">
            <div class="auth-form-light text-left">
              <div class="brand-logo-container">
                <img src="{{ asset('asset/images/logo-ascend-horizontal.png') }}" alt="ASCEND" class="brand-logo-img">
              </div>
              <div class="text-center mb-4">
                <h4 class="font-weight-bold text-dark mb-1" style="font-size: 1.25rem;">Buat Akun Baru</h4>
                <span class="text-muted" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">PT. IAS SUPPORT INDONESIA</span>
              </div>
              <form class="pt-2" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group mb-3">
                  <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama Lengkap" autofocus>
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
                </div>
                <div class="mt-4">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">DAFTAR SEKARANG</button>
                </div>
                <div class="text-center mt-4 font-weight-light" style="font-size: 0.88rem;">
                  Sudah memiliki akun? <a href="{{ route('login') }}" class="auth-link font-weight-bold">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="{{ asset('asset/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- inject:js -->
  <script src="{{ asset('asset/js/off-canvas.js') }}"></script>
  <script src="{{ asset('asset/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('asset/js/template.js') }}"></script>
  <script src="{{ asset('asset/js/settings.js') }}"></script>
  <script src="{{ asset('asset/js/todolist.js') }}"></script>
</body>
</html>
