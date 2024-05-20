@extends('layouts.layoutMaster')

@section('title', 'Create Role')

@section('page-style')
<link rel="stylesheet" href="{{asset(mix('assets/vendor/libs/toastr/toastr.css'))}}">
@endsection

@section('page-script')
<script src="{{asset(mix('assets/vendor/libs/toastr/toastr.js'))}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
  $(document).ready(function() {
      $('#roleForm').submit(function(event) {
          event.preventDefault(); // Prevent form submission

          var form = $(this);
          var url = form.attr('action');
          var method = form.attr('method');
          var formData = form.serialize();

          $.ajax({
              url: url,
              method: method,
              data: formData,
              success: function(data) {
                $(".is-invalid").removeClass("is-invalid");
                if ($.isEmptyObject(data.error)) {
                  toastr.success(data.success);
                  setTimeout(function() {
                    window.location.href = '{{route("role.index")}}';
                  }, 2000);
                } else {
                  $.each(data.error, function(field, errorMessage) {
                    toastr.error(errorMessage[0]);
                    $("#" + field).addClass("is-invalid");
                  });
                }
              },
              error: function(xhr, textStatus, errorThrown) {
                  var errors = xhr.responseJSON.errors;
                  toastr.error(Object.values(errors).flat().join('<br>')); // Display error toastr message
              }
          });
      });
  });
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('role.index') }}"> Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="roleForm" action="{{ route('role.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role Name:</strong>
                <input type="text" name="roleName" id="roleName" class="form-control" placeholder="Role Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong><br>
                @foreach($permissions as $permission)
                    <label class="checkbox-inline">
                        <input type="checkbox" id="permissions" name="permissions[]" value="{{ $permission->name }}"> {{ $permission->name }}
                    </label>
                    <br>
                @endforeach
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection
