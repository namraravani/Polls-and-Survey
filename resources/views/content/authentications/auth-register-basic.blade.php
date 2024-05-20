@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register Basic - Pages')



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

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          {{-- <div class="app-brand justify-content-center mb-4 mt-2">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
              <span class="app-brand-text demo text-body fw-bold ms-1">{{config('variables.templateName')}}</span>
            </a>
          </div> --}}
          <span class="app-brand-text demo text-body fw-bold ms-1">Register Here</span>
          <!-- /Logo -->
          <h4 class="mb-1 pt-2">Adventure starts here 🚀</h4>
          {{-- <p class="mb-4">Make your app management easy and fun!</p> --}}

          <form id="myform"  method="POST">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus>
            </div>
            <div class="mb-3">
              <label for="first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your First Name here" autofocus>
            </div>
            <div class="mb-3">
              <label for="last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your Last Name here" autofocus>
            </div>

            <div class="mb-3">
              <label for="phone_no" class="form-label">Mobile Number</label>
              <input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Enter your mobile number here" autofocus>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="confirm_password">Confirm Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div>
            <button class="btn btn-primary d-grid w-100" onclick="registeruser()">
              Sign up
            </button>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{url('auth/login-basic')}}">
              <span>Sign in instead</span>
            </a>
          </p>

          <div class="divider my-4">
            <div class="divider-text">or</div>
          </div>

          <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
              <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
              <i class="tf-icons fa-brands fa-google fs-5"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
              <i class="tf-icons fa-brands fa-twitter fs-5"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
<script>
  function registeruser() {
  var formData = {
    _token: "{{ csrf_token() }}",
    username: $("#username").val(),
    first_name: $("#first_name").val(),
    last_name: $("#last_name").val(),
    phone_no: $("#phone_no").val(),
    email: $("#email").val(),
    password: $("#password").val(),
    confirm_password: $("#confirm_password").val()
  };

  $.ajax({
    url: "{{ route('validateform_register') }}",
    type: "POST",
    data: formData,
    success: function(data) {
      console.log(data);
      $(".is-invalid").removeClass("is-invalid");
      if ($.isEmptyObject(data.error)) {
        toastr.success(data.success);
        setTimeout(function() {
          window.location.href = "{{url('auth/login-basic')}}";
        }, 2000);
      } else {

        $.each(data.error, function(field, errorMessage) {
          toastr.error(errorMessage[0]);
          $("#" + field).addClass("is-invalid");
        });
      }
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
      toastr.error('An error occurred. Please try again later.');
    }
  });
  event.preventDefault();
  return false;

}






</script>

@endsection
