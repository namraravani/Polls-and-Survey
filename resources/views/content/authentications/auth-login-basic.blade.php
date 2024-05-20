@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')



@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
<link rel="stylesheet"  href="{{asset(mix('assets/vendor/libs/toastr/toastr.css'))}}">
@endsection



@section('page-script')
<script src="{{asset(mix('assets/vendor/libs/toastr/toastr.js'))}}"></script>
<script src="{{asset('assets/js/pages-auth.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">
      <!-- Login -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          {{-- <div class="app-brand justify-content-center mb-4 mt-2">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
              <span class="app-brand-text demo text-body fw-bold ms-1">Sign In</span>
            </a>
          </div> --}}
          <span class="app-brand-text demo text-body fw-bold ms-1">Sign In</span>
          <!-- /Logo -->
          <h4 class="mb-1 pt-2">Welcome👋 </h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>

          <form id="myform"  method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email or Username</label>
              <input type="text" class="form-control" id="email-username" name="email-username" placeholder="Enter your email or username" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                <a href="{{ route('forget.password.get') }}">
                  <small>Forgot Password?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" onclick="loginuser(event)">Sign in</button>
            </div>
          </form>

          <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{url('auth/register-basic')}}">
              <span>Create an account</span>
            </a>
          </p>

          <div class="divider my-4">
            <div class="divider-text">or</div>
          </div>

          <div class="d-flex justify-content-center">
            <a href="{{ route('facebook.login') }}" class="btn btn-icon btn-label-facebook me-3">
              <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
            </a>

            <a href="{{ route('google.login') }}" class="btn btn-icon btn-label-google-plus me-3">
              <i class="tf-icons fa-brands fa-google fs-5"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {

  const urlParams = new URLSearchParams(window.location.search);
  const resetSuccess = urlParams.get('reset_success');

  if (resetSuccess === 'true') {
    toastr.success('Your password has been reset successfully.', 'Success');
  }
  $('#myform').on('submit', function(event) {
    event.preventDefault();
    loginuser(event);
  });
});

function loginuser(event) {


  event.preventDefault(); // Prevent default form submission

  var _token = $("input[name='_token']").val();
  var emailUsername = $('#email-username').val();
  var password = $('#password').val();
  var errorCount = 0;

  // Reset validation
  $(".is-invalid").removeClass("is-invalid");

  // Validate email or username
  if (emailUsername.trim() === '') {
    toastr.error('Please enter your email or username.');
    $('#email-username').addClass('is-invalid');
    errorCount++;
  }

  // Validate password
  if (password.trim() === '') {
    toastr.error('Please enter your password.');
    $('#password').addClass('is-invalid');
    errorCount++;
  }

  // If there are errors, stop further processing
  if (errorCount > 0) {
    return false;
  }

  // Perform AJAX request for login
  $.ajax({
    url: "{{ route('validateform') }}",
    type: "POST",
    data: {
      _token: _token,
      'email-username': emailUsername,
      password: password
    },
    success: function(data) {
      if (data.success) {
        toastr.success(data.success);
        setTimeout(function() {
          window.location.href = "{{ url('/') }}";
        }, 2000);
      } else if (data.error) {
        toastr.error(data.error);
      }
    },
    error: function(xhr, status, error) {
      toastr.error('An error occurred. Please try again later.');
    }
  });
}



</script>
@endsection
