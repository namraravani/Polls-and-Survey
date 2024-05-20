@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles')
@section('page-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css'))}}">

@endsection
@section('page-script')

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
    <script src="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')) }}"></script>
    <script type="text/javascript">

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $(document).ready(function() {

        dtable = $('#zero_configuration_table').DataTable({
            "language": {
                "lengthMenu": "_MENU_",
            },
            "columnDefs": [ {
              "targets": "_all",
              "orderable": false
            } ],
            responsive: true,
            'serverSide': true, // Feature control DataTables' server-side processing mode.

            "ajax": {
              "url": "{{route('getRoles')}}",
              'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
              "type": "POST",
              "data" :function ( data ) {

                  },
            },
        });

        $('.panel-ctrls').append("<i class='separator'></i>");

        $('.panel-footer').append($(".dataTable+.row"));
        $('.dataTables_paginate>ul.pagination').addClass("pull-right");

        $("#apply_filter_btn").click(function()
        {
          dtable.ajax.reload(null,false);
        });
      });

    </script>

@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div></div>
        <a href="{{ route('role.create') }}" class="btn btn-primary">Add Role</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="zero_configuration_table" class="table table-striped">
                        <thead>
                            <tr>
                              <th>No.</th>
                              <th>Role Name</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
