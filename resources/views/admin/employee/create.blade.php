@extends('layouts.admin_dashboard.main')
@section('title')
    Add Employee
@endsection
@section('content')
  <div class="content-wrapper">

       <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employee</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Employee</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{route('employee.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">
                  <div class="form-group col-md-6">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required placeholder="Enter Name">
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required placeholder="Enter email">
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                  </div>
                </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                    <label for="exampleInputDesignation">Designation <span class="text-danger">*</span></label>
                    <select name="designation" class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" required="required">
                    <option value="" selected="">Select Designation</option>
                    @foreach($designation as $key => $value)
                    <option value="{{$value}}" @if(old('designation') == $value) selected @endif>{{$key}}</option>
                    @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('designation') }}</small>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputFile">Upload Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="photo" class="custom-file-input {{ $errors->has('photo') ? ' is-invalid' : '' }}" ccept="image/*">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                    <small class="text-danger">{{ $errors->first('photo') }}</small>
                  </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection