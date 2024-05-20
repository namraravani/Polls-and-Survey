@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'UserView')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/toastr/toastr.css')) }}">
@endsection

@section('page-script')
<script src="{{ asset('assets/js/pages-auth.js') }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/toastr/toastr.js')) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">
      <a href="{{ url()->previous() }}" class="btn btn-primary" style="width: 90px;margin-left:300px;">Back</a>
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <div class="user-info text-center">
            <h4 class="mb-1 pt-2">Welcome 👋 View-Page</h4>
          </div>
          <div class="alert alert-primary d-flex align-items-center justify-content: center;" role="alert">
            <span class="alert-icon text-primary me-2">
              <i class="ti ti-user ti-xs"></i>
            </span>
            <h4 direction="down" scrollamount="3">View User</h4>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div style="display: flex; align-items:center;justify-content: center;">
            <i class="ti ti-user" style="font-size: 18px; color: #007bff; margin-right: 5px;"></i>
            <span style="color: #333; font-weight: bold;">Profile_image</span>

          </div>

          <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center;">
              <div class="profile-image">
                @if($user->profile_img)
                <img src="{{ asset($user->profile_img) }}" alt="Image" class="rounded-circle img-fluid">
                @else
                <div style="border-radius: 50%; width: 105px; height: 105px; background-color: #000; display: flex; justify-content: center; align-items: center; font-size: 24px; font-weight: bold; color: #fff;">{{substr($user->first_name,0,1)}}{{substr($user->last_name,0,1)}}</div>
                @endif
              </div>
            </div>
          </td>

          <style>
          .profile-image {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.7);
            transition: transform 0.2s;
            margin-left: auto;
            margin-right: auto;
          }

          .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
          }

          .profile-image:hover {
            transform: scale(1.2);
          }
          </style>

          <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center;">
              <i class="ti ti-user" style="font-size: 18px; color: #007bff; margin-right: 5px;"></i>
              <span style="color: #333; font-weight: bold;">{{ $user->username }}</span>
            </div>
          </td>
          <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center;">
              <i class="ti ti-user" style="font-size: 18px; color: #007bff; margin-right: 5px;"></i>
              <span style="color: #333; font-weight: bold;">{{ $user->first_name }}</span>
            </div>
          </td>
          <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center;">
              <a href="{{ route('auth-login-basic') }}" class="btn rounded-pill btn-label-primary waves-effect">
                <i class="ti ti-login" style="font-size: 18px; color: #007bff"></i> Logout
              </a>
            </div>
          </td>


          <div class="d-flex justify-content-center mt-4 small text-uppercase text-muted">
            <span class="badge badge-dot bg-primary me-1"></span>
            <span>Details</span>
          </div>
          <table class="table table-bordered">
            <tbody>
              <th>Username</th>
              <td style="border: 1px solid #ccc; padding: 10px;">
                <div style="display: flex; align-items: center;">
                    <i class="ti ti-user" style="font-size: 18px; color: #735ae3; margin-right: 5px;"></i>
                    <span class="badge bg-label-primary me-1">{{$user->username}}</span>

                </div>
              </td>
              <tr>
                <th>First_name</th>
                <td style="border: 1px solid #ccc; padding: 10px;">
                  <div style="display: flex; align-items: center;">
                      <i class="ti ti-info-circle" style="font-size: 18px; color: #48d746; margin-right: 5px;"></i>
                      <span class="badge bg-label-success me-1">{{$user->first_name}}</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th>Last_name</th>
                <td style="border: 1px solid #ccc; padding: 10px;">
                  <div style="display: flex; align-items: center;">
                      <i class="ti ti-info-circle" style="font-size: 18px; color: #00ff37; margin-right: 5px;"></i>

                      <span class="badge bg-label-success me-1">{{$user->last_name}}</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th>phone_name</th>
                <td style="border: 1px solid #ccc; padding: 10px;">
                  <div style="display: flex; align-items: center;">
                      <i class="ti ti-phone" style="font-size: 18px; color: #007bff; margin-right: 5px;"></i>

                      <span class="badge bg-label-info me-1">{{$user->phone_no}}</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th>email</th>
                <td style="border: 1px solid #ccc; padding: 10px;">
                  <div style="display: flex; align-items: center;">
                      <i class="fas fa-envelope" style="font-size: 18px; color: #007bff; margin-right: 5px;"></i>

                      <span class="badge bg-label-primary me-1">{{$user->email}}</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th>Role</th>
                <td style="border: 1px solid #ccc; padding: 10px;">
                  <div style="display: flex; align-items: center;">
                      <i class="fas fa-address-book" style="font-size: 18px; color: #007bff; margin-right: 5px;"></i>
                      <span class="badge bg-label-primary me-1">{{$user->role}}</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
