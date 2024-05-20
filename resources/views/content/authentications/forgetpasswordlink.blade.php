<html lang="en" class="light-style  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Forgot Password</title>

    <!-- Canonical SEO -->
    {{-- <link rel="canonical" href="https://1.envato.market/vuexy_admin"> --}}


    <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    {{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-5J3LMKC');</script> --}}
    <!-- End Google Tag Manager -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css"/>
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />


    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />

    <!-- Vendor -->
<link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
<link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css">
<link rel="stylesheet"  href="{{asset(mix('assets/vendor/libs/toastr/toastr.css'))}}">

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>


    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <script src="../../assets/js/config.js"></script>
</head>

<body>


<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <div class="card">
        <div class="card-body">
          <div class="app-brand justify-content-center mb-4 mt-2">
            <a href="" class="app-brand-link gap-2">

                <span class="app-brand-text demo text-body fw-bold">🤗If You Reset  Password🤗</span>



            </a>




          </div>
          {{-- <div class="marquee-container text-center">
            <marquee scrollamount="2" direction="up">
              <span class="mb-4 fw-bold text-center warning">✌️Enter email,password,Confirmpassword!!✌️</span>
            </marquee>
          </div> --}}
          <div class="alert alert-primary alert-dismissible d-flex align-items-baseline" role="alert">
            <span class="alert-icon alert-icon-lg text-primary me-2">
              <i class="ti ti-user ti-sm"></i>
            </span>
            <div class="d-flex flex-column ps-1">
              <h5 class="alert-heading mb-2">📝Enter The Following📝</h5>
              <p class="mb-0 fw-bold text-center text-warning">
                <span class="d-inline-block">Email,</span>
                <span class="d-inline-block">password,</span>
                <span class="d-inline-block">Confirm-password.</span>
              </p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1 pt-2">Reset Password? 🔒</h4>

          <form action="{{ route('reset.password.post') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group row">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">Email</label>
                <div class="col-md-6">
                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                    <input type="password" id="password" class="form-control" name="password" required autofocus>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm
                    Password</label>
                <div class="col-md-6">
                    <input type="password" id="password-confirm" class="form-control" name="password_confirmation"
                        required autofocus>
                    @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary" onclick="validateAndForgot()">
                    Reset Password
                </button>
            </div>
        </form>


        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>

<!-- / Content -->



  <!-- Core JS -->



  <!-- Page JS -->
  <script src="../../assets/js/pages-auth.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="{{asset(mix('assets/vendor/libs/toastr/toastr.js'))}}"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
  function validateAndForgot() {
  var email = $("#email_address").val().trim();
  var password = $("#password").val().trim();
  var confirmPassword = $("#password-confirm").val().trim();
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Reset borders
  $("#email_address, #password, #password-confirm").removeClass("is-invalid").css("border", "").css("font-weight", "");

  if (email === '' || password === '' || confirmPassword === '') {
    toastr.error('Validation Error', 'Please fill  all fields');

    if (email === '') {
      $("#email_address").addClass("is-invalid").css("border", "1px solid red").css("font-weight", "bold");
    }
    if (password === '') {
      $("#password").addClass("is-invalid").css("border", "1px solid red").css("font-weight", "bold");
    }
    if (confirmPassword === '') {
      $("#password-confirm").addClass("is-invalid").css("border", "1px solid red").css("font-weight", "bold");
    }
  } else if (!emailRegex.test(email)) {
    toastr.error('Validation Error', 'Please enter a valid email address');
    $("#email_address").addClass("is-invalid").css("border", "1px solid red").css("font-weight", "bold");
  } else {
    toastr.success('Success', 'Your Password is updated');
  }
}

</script>

</body>

</html>
