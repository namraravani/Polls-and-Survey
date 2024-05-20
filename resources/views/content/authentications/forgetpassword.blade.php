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
              <span class="app-brand-text demo text-body fw-bold">🙈If You Forgot Password🙈</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1 pt-2">Forgot Password? 🔒</h4>
          <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
          <form action="{{ route('forget.password.post') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">Email:</label>
                <div class="col-md-6">
                    <input type="text" id="email_address" class="form-control" name="email" value={{Auth::user()->email}} autofocus disabled>
                </div>
                <div class="col-md-6 offset-md-4">
                  <button class="btn btn-primary d-grid w-100" onclick="validateAndReset()">Send Reset Link</button>
              </div>
            </div>

          </form>
          <div class="text-center">
            <a href="/auth/login-basic" class="d-flex align-items-center justify-content-center">
              <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
              Back to login
            </a>
          </div>
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
  function validateAndReset() {
  var email = $("#email_address").val().trim();
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (email === '') {
    toastr.error('Validation Error.', 'Please Enter an Email Address');
  } else if (!emailRegex.test(email)) {
    toastr.error('Validation Error.', 'Please enter a valid email address');
  } else {
    var specialCharsRegex = /[!@#$%^&*(),.?":{}|<>]/;
    if (!specialCharsRegex.test(email)) {
      toastr.error('Validation Error', 'Email should contain at least one special character.');
    } else {
      // Check if email exists more than once
      var emails = $('input[name="email"]');
      var emailCount = 0;
      emails.each(function() {
        if ($(this).val().trim() === email) {
          emailCount++;
        }
      });

      if (emailCount > 1) {
        toastr.error('Email should be unique', 'Validation Error.');
      } else {
        resetPassword(email);
      }
    }
  }
}

function resetPassword(email) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: "{{ route('forget.password.post') }}",
    type: "POST",
    data: {
      _token: "{{ csrf_token() }}",
      email: email
    },
    dataType: "json",
    success: function(response) {
      event.preventDefault();
      if (response.success) {
        toastr.success(response.message, "Success");
        window.location.href = '/forget-password';
      } else {
        toastr.error(response.message, "Error");
      }
    },
    error: function(xhr, status, error) {
      event.preventDefault(); // Prevent form submission
      var message = "An error occurred while sending the password reset link.";
      if (xhr.status === 422) {
        var errors = xhr.responseJSON.errors;
        var errorMessage = "";
        for (var key in errors) {
          if (errors.hasOwnProperty(key)) {
            errorMessage += errors[key][0] + "<br>";
          }
        }
        message = errorMessage;
      }
      toastr.error(message, "Error");
    }
  });
}
</script>


</body>

</html>
