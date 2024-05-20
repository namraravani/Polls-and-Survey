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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{asset('assets/js/pages-auth.js')}}"></script>
<script src="{{asset(mix('assets/vendor/libs/toastr/toastr.js'))}}"></script>
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
          <h4 class="mb-1 pt-2">Welcome 👋 User-Edit-Form</h4>
          <div class="alert alert-info alert-dismissible d-flex align-items-baseline" role="alert">
            <span class="alert-icon alert-icon-lg text-primary] me-2">
              <i class="ti ti-user ti-sm"></i>
            </span>
            <div class="d-flex flex-column ps-1">

              <h5 class="alert-heading mb-2">📝Enter The Following📝</h5>
              <marquee direction="down" scrollamount="2">

                <p class="mb-0 fw-bold text-center text-warning">
                  <span class="d-inline-block">If You Want To edit User Details</span>
                  <span class="d-inline-block">Fill Out All Details</span>
                </p>
              </marquee>

              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>

          <!-- /Logo -->
          <h4 class="mb-1 pt-2">Adventure starts here 🚀</h4>
          {{-- <p class="mb-4">Make your app management easy and fun!</p> --}}

          <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="row">
              <div class="form-group">
                <label>Select-role</label>
                <select name="role" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{$role}}" {{$userRole == $role ? 'selected' : " "}}>{{ $role }}</option>
                    @endforeach
                </select>
             </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <label class="form-label" for="profile_img">Profile Image</label>
                <input type="file" id="profile_img" name ="profile_img" class="form-control" />
                @if ($user->profile_img)
                        <div class="profile-img-container">
                            <button type="button" class="btn btn-danger" id="delete_thumbnail_button" onclick="deleteprofile()">X</button>
                            <img src="/{{$user->profile_img}}" alt="Profile Image" width="100px" id="profile_img" name="profile_img" >
                        </div>
                    @else
                        <p>No Profile Image</p>
                @endif
            </div>
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
                  top: 2px;
                  right: 2px;
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


            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">User Name:</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="User Name" value="{{ $user->username }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">First Name:</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ $user->first_name }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ $user->last_name }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Phone Number:</label>
                    <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Phone Number" value="{{ $user->phone_no }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                </div>
            </div>
            

            <div class="row">
              <div class="col-12 d-flex justify-between">
                  <button class="btn btn-warning" style="width: 90px;">Update</button>
                  <a href="{{ url()->previous() }}" class="btn btn-primary" style="width: 90px;">Back</a>
              </div>
          </div>
          <input hidden  type="checkbox" id="delete_profile_img" name="delete_profile_img" value="0">

        </form>




          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>



</script>


@endsection
