@extends('layouts.layoutMaster')
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Account Settings</title>

    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
    {{-- <script src="{{asset(mix('assets/vendor/libs/sweetalert2/sweetalert2.js'))}}"></script> --}}


    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css"/>
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />


    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"  href="{{asset(mix('assets/vendor/libs/toastr/toastr.css'))}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css" />
    {{-- <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/sweetalert2/sweetalert2.css'))}}"> --}}
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />

<style>
  .profile-img-container {
      position: relative;
      display: inline-block;

  }

  .profile-img-container img {
      width: 100px;
  }

  .profile-img-container button {
      position: absolute;
      top: 10px;
      right: 10px;
      height: 5px;
      width: 2px;
  }

</style>



  <script>
  function deleteprofile() {
  Swal.fire({
    title: "Are you sure?",
    text: "This action cannot be undone!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      const deleteThumbnailCheckbox = document.getElementById('delete_profile_img');
      deleteThumbnailCheckbox.checked = true;

      const thumbnailContainer = document.querySelector('.profile-img-container');
      if (thumbnailContainer) {
          thumbnailContainer.remove();
      }
      Swal.fire("Profile image deleted!", "", "success");
    } else {
      Swal.fire("Deletion canceled.", "", "info");
    }
  });
}
  </script>


    <!-- Helpers -->

    <script src="{{asset(mix('assets/vendor/libs/toastr/toastr.js'))}}"></script>
    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <script src="../../assets/js/config.js"></script>



</head>

<body>
        <li class="menu-item active">
          <a href="form-wizard-icons.html" class="menu-link">
          </a>
        </li>
    <div class="layout-page">
      <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
</p>
<!-- Default -->
<div class="row">
  <!-- Vertical Icons Wizard -->
  <div class="col-12 mb-4">
    <small class="text-light fw-medium">Account Settings</small>
    <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
      <div class="bs-stepper-header">
        <div class="step" data-target="#account-details-vertical">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">
              <i class="ti ti-file-description"></i>
            </span>
            <span class="bs-stepper-label">
              <span class="bs-stepper-title">Account Details</span>
              <span class="bs-stepper-subtitle">Setup Account Details</span>
            </span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#personal-info-vertical">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">
              <i class="ti ti-user"></i>
            </span>
            <span class="bs-stepper-label">
              <span class="bs-stepper-title">Change Password</span>
              <span class="bs-stepper-subtitle">Setup Your Password</span>
            </span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#social-links-vertical">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
            </span>
            <span class="bs-stepper-label">
              <span class="bs-stepper-title">Social Links</span>
              <span class="bs-stepper-subtitle">Add social links</span>
            </span>
          </button>
        </div>
      </div>
      <div class="bs-stepper-content">
        <form id="profile-form" method="POST" enctype="multipart/form-data">
          @csrf
          <div id="account-details-vertical" class="content">
            <div class="content-header mb-3">
              <h6 class="mb-0">Account Details</h6>
              <small>Enter Your Account Details.</small>
            </div>
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label" for="profile_img">Profile Image</label>
                <input type="file" id="profile_img" name ="profile_img" class="form-control" />
                @if (Auth::user()->profile_img)
                        <div class="profile-img-container">
                            <button type="button" class="btn btn-danger" id="delete_thumbnail_button" onclick="deleteprofile()">X</button>
                            <img src="/{{Auth::user()->profile_img}}" alt="Profile Image" width="100px" id="profile_img" name="profile_img" >
                        </div>
                    @else
                        <span  class="badge rounded-pill text-success bg-danger text-white">No Profile Image <i class="fa-solid fa-id-card"></i></span>
                @endif
            </div>
              <div class="col-sm-6">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" value="{{ Auth::user()->username }}" @if($disableRole) disabled @endif>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" value="{{ Auth::user()->first_name }}">
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" value="{{ Auth::user()->last_name }}">
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="phone_no">Phone Number</label>
                <input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Enter Phone Number" value="{{ Auth::user()->phone_no }}">
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ Auth::user()->email }}">
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="role">Role</label>
                <input type="text" id="role" class="form-control" value="{{Auth::user()->role==NULL ? "No Role assigned" : Auth::user()->role}}" @if($disableRole) disabled @endif>
            </div>
              <div class="col-sm-7">
                <button type="submit" class="btn btn-success" onclick="edit_profile()">Save Changes</button>
              </div>
              <input hidden  type="checkbox" id="delete_profile_img" name="delete_profile_img" value="0">
        </form>
              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label-secondary btn-prev" disabled>
                  <i class="ti ti-arrow-left me-sm-1"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button class="btn btn-primary btn-next">
                  <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                  <i class="ti ti-arrow-right"></i>
                </button>
              </div>
            </div>
          </div>

        <form action="{{route('edit_password')}}" id="password-form" method="POST">
          @csrf
          <div id="personal-info-vertical" class="content">
            <div class="content-header mb-3">
              <h6 class="mb-0">Change Password</h6>
              <small>Enter Your Change Password</small>
            </div>
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label" for="first-name1">Old Password:</label>
                <input type="password"  name="old_password" id="old_password" class="form-control">

              </div>
              <div class="col-sm-6">
                <label class="form-label" for="last-name1">New Password:</label>
                <input type="password"  name="new_password" id="new_password" class="form-control">

              </div>
              <div class="col-sm-6">
                <label class="form-label" for="last-name1">Confirm Password:</label>
                <input type="password"  name="confirm_password" id="confirm_password" class="form-control">
              </div>

              <div class="col-sm-7">
                <button type="submit" class="btn btn-success">Change Password</button>
              </div>

        </form>
              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
              </div>
            </div>
          </div>

          <!-- Social Links -->
          <div id="social-links-vertical" class="content">
            <div class="content-header mb-3">
              <h6 class="mb-0">Social Links</h6>
              <small>Enter Your Social Links.</small>
            </div>
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label" for="twitter1">Twitter</label>
                <input type="text" id="twitter1" class="form-control" placeholder="https://twitter.com/abc" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="facebook1">Facebook</label>
                <input type="text" id="facebook1" class="form-control" placeholder="https://facebook.com/abc" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="google1">Google+</label>
                <input type="text" id="google1" class="form-control" placeholder="https://plus.google.com/abc" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="linkedin1">Linkedin</label>
                <input type="text" id="linkedin1" class="form-control" placeholder="https://linkedin.com/abc" />
              </div>
              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button class="btn btn-success btn-submit">Submit</button>
              </div>
            </div>
          </div>

      </div>
    </div>
  </div>

</div>




  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
  <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
  <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
   <script src="../../assets/vendor/js/menu.js"></script>

  <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
<script src="../../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>
<script src="{{asset(mix('assets/vendor/libs/toastr/toastr.js'))}}"></script>

  <!-- Main JS -->
  <script src="../../assets/js/main.js"></script>


  <!-- Page JS -->

<script src="../../assets/js/form-wizard-icons.js"></script>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $("#profile-form").submit(function(event) {
      event.preventDefault();
      edit_profile();
    });

  });
  function edit_profile() {
  var formData = new FormData();
  formData.append("_token", "{{ csrf_token() }}");
  var profileImage = $("#profile_img")[0].files[0];
  if (profileImage) {
  formData.append("profile_img", profileImage);
  }
  formData.append("username", $("#username").val());
  formData.append("first_name", $("#first_name").val());
  formData.append("last_name", $("#last_name").val());
  formData.append("phone_no", $("#phone_no").val());
  formData.append("email", $("#email").val());

  var deleteProfileImage = $("#delete_profile_img").is(":checked");
    if (deleteProfileImage) {
      formData.append("delete_profile_img", "1");
    }

  $.ajax({
    url: "{{ route('edit_profile') }}",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      console.log(data);
      $(".is-invalid").removeClass("is-invalid");
      if ($.isEmptyObject(data.error)) {
        toastr.success(data.success);
        setTimeout(function() {
          window.location.href = "{{url('/profile')}}";
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
{{-- <script>
$(document).ready(function() {
$("#password-form").submit(function(event) {
        event.preventDefault();
        editPassword();
    });
});

function editPassword() {
    var oldPassword = document.getElementById('old_password').value;
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = document.getElementById('confirm_password').value;

    $.ajax({
        url: '/edit_password',
        type: 'POST',
        data: {
            old_password: oldPassword,
            new_password: newPassword,
            confirm_password: confirmPassword
        },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                toastr.error(response.error);
            } else if (response.success) {
                toastr.success(response.success);
            }
        },
        error: function() {
            toastr.error('An error occurred while processing your request.');
        }
    });
}
</script> --}}


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <script>
        toastr.success('{{ session('success') }}');
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error('{{ session('error') }}');
    </script>
@endif



</html>
