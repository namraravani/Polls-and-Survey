@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
<tr>
  <td>
      <div style="display: flex; align-items: center; margin-top: 10px; margin-left: 3px;">
          <h3 style="display: inline-block; padding: 5px 8px; border-radius: 10px; font-weight: bold; margin-bottom: 0;">
              {{-- <marquee behavior="scroll" direction="up" scrollamount="4" loop="infinite"> --}}
                  <style>
                      @keyframes borderAnimation {
                        0% {
                          border-color: #2193b0;
                        }
                        25% {
                          border-color: #6dd5ed;
                        }
                        50% {
                          border-color: #ff9a8b;
                        }
                        75% {
                          border-color: #ff6a88;
                        }
                        100% {
                          border-color: #ff99ac;
                        }
                      }

                      @keyframes gradientEffect {
                        0% {
                          background-position: 0% 50%;
                        }
                        50% {
                          background-position: 100% 50%;
                        }
                        100% {
                          background-position: 0% 50%;
                        }
                      }
                      </style>

                      <div style="display: inline-block;">
                        <div style="position: relative;">
                          <div style=""></div>
                          <div style="position: relative; padding: 10px; border: 5px solid transparent; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); animation: borderAnimation 5s linear infinite;">
                            <span style="background: linear-gradient(45deg, #2193b0, #6dd5ed, #ff9a8b, #ff6a88, #ff99ac, #f6d365, #fda085, black); background-size: 200% 200%; -webkit-text-fill-color: transparent; -webkit-background-clip: text;animation:gradientEffect 5s ease-in-out infinite;">
                              👋 Welcome, {{Auth::user()->username }}, In Dashboard!!👋
                            </span><br/>
          
                          </div>
                        </div>
                      </div>

                  <br/>

              {{-- </marquee> --}}
          </h3>
      </div>
  </td>
</tr>

{{-- <p>For more layout options refer <a href="{{ config('variables.documentation') ? config('variables.documentation') : '#' }}" target="_blank" rel="noopener noreferrer">documentation</a>.</p> --}}
@endsection
