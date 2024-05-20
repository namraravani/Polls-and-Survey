@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">
            @include('_partials.macros',["height"=>20])
          </span>
          <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
        </a>
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="ti ti-menu-2 ti-sm"></i>
        </a>
      </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <!-- Style Switcher -->
        <div class="navbar-nav align-items-center">
          <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
            <i class='ti ti-sm'></i>
          </a>
        </div>
        <!--/ Style Switcher -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <span>
                  @if (Auth::user()->profile_img)
                      <div class="profile-image">
                          <span><img src="/{{ Auth::user()->profile_img }}" width="50px"></span>
                      </div>
                  @else
                  <div style="border-radius: 50%; width: 40px; height: 40px; background-color: #000; display: flex; justify-content: center; align-items: center; font-size: 24px; font-weight: bold; color: #fff;">{{substr(Auth::user()->first_name,0,1)}}{{substr(Auth::user()->last_name,0,1)}}</div>
                  @endif
              </span>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="/profile">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <span>
                          @if (Auth::user()->profile_img)
                              <div class="profile-image">
                                  <span><img src="/{{ Auth::user()->profile_img }}" width="50px"></span>
                              </div>
                          @else
                          <div style="border-radius: 50%; width: 40px; height: 40px; background-color: #000; display: flex; justify-content: center; align-items: center; font-size: 24px; font-weight: bold; color: #fff;">{{substr(Auth::user()->first_name,0,1)}}{{substr(Auth::user()->last_name,0,1)}}</div>
                          @endif
                      </span>
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block">
                        @if (Auth::check())
                        {{ Auth::user()->first_name }}
                        @endif
                      </span>
                      <small class="text-muted">{{ Auth::user()->role==NULL ? 'No Role assigned' : Auth::user()->role  }}</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="/profile">
                  <i class="ti ti-user-check me-2 ti-sm"></i>
                  <span class="align-middle">My Profile</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/auth/logout">
                  <i class="fa-solid fa-right-from-bracket me-2 ti-sm"></i>
                  <span class="align-middle">Log out</span>
                </a>
              </li>

            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
