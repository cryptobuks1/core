@extends('master')


@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Permission</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="name">Name:</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="guard_name">Guard Name:</label>
                    <input name="guard_name" type="text" class="form-control" id="guard_name" placeholder="Guard Name" value="{{ old('guard_name', 'web') }}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Description">{{ old('description') }}</textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
              {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
    <!-- /.card -->
    </div>
  <!-- /.col -->
  </div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection