@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'User Create - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
<link rel="stylesheet"  href="{{asset(mix('assets/vendor/libs/toastr/toastr.css'))}}">
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages-auth.js')}}"></script>
<script src="{{asset(mix('assets/vendor/libs/toastr/toastr.js'))}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {
  $("#user-form").submit(function(event) {
    event.preventDefault();
    edit_profile();
  });

});
function create_user() {
var formData = new FormData();
formData.append("_token", "{{ csrf_token() }}");
var profileImage = $("#profile_img")[0].files[0];
if (profileImage)
  {
  formData.append("profile_img", profileImage || '');
}
formData.append("role", $("#role").val());
formData.append("username", $("#username").val());
formData.append("first_name", $("#first_name").val());
formData.append("last_name", $("#last_name").val());
formData.append("phone_no", $("#phone_no").val());
formData.append("email", $("#email").val());
formData.append("password", $("#password").val());

var deleteProfileImage = $("#delete_profile_img").is(":checked");
  if (deleteProfileImage) {
    formData.append("delete_profile_img", "1");
  }

$.ajax({
  url: "{{ route('users.store') }}",
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
        window.location.href = "{{url('/users')}}";
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

@section('content')

<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">
      <div class="card">
        <div class="card-body">

          <h4 class="mb-1 pt-2">Welcome 👋 User-Create-Form</h4>
          <div class="alert alert-info alert-dismissible d-flex align-items-baseline" role="alert">
            <span class="alert-icon alert-icon-lg text-primary] me-2">
              <i class="ti ti-user ti-sm"></i>
            </span>
            <div class="d-flex flex-column ps-1">
              <h5 class="alert-heading mb-2">📝Enter The Following📝</h5>
              <h5 direction="down" scrollamount="2">
                <p class="mb-0 fw-bold text-center text-warning">
                  <span class="d-inline-block">Please Fill User Details</span>
                </p>
              </h5>

              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
          <form id="user-form" method="POST"  enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label class="form-label" for="profile_img">Profile Image</label>
              <input type="file" id="profile_img" name="profile_img" class="form-control" />
              @if (old('profile_img'))
                <div class="profile-img-container">
                  <button type="button" class="btn btn-danger" id="delete_thumbnail_button" onclick="deleteprofile()">X</button>
                  <img src="{{ old('profile_img') }}" alt="Profile Image" width="100px" id="profile_img" name="profile_img" >
                </div>
              @else
                <span class="badge rounded-pill text-success bg-danger text-white">No Profile Image <i class="fa-solid fa-id-card"></i></span>
              @endif
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" class="form-control"  required>
            </div>
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" name="first_name" id="first_name" class="form-control"  required>
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" name="last_name" id="last_name" class="form-control"  required>
            </div>
            <div class="form-group">
              <label for="phone_no">Phone Number</label>
              <input type="number" name="phone_no" id="phone_no" class="form-control"  required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Select-role</label>
                  <select name="role" id="role" class="form-control">
                    <option value="">--Select Role--</option>
                      @foreach($roles as $role)
                          <option value="{{$role ?? " "}}">{{ $role }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>


            <button type="submit" class="btn btn-success" onclick="create_user()">Create User</button>
            <a href="{{ url()->previous() }}" class="btn btn-dark" style="width: 90px;">Back</a>
            <input hidden  type="checkbox" id="delete_profile_img" name="delete_profile_img" value="0">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
