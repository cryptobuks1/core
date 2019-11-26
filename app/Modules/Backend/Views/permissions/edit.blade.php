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
                <h3 class="card-title">Sửa: {{ $permission->name }}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($permission, ['method' => 'PATCH','route' => ['permissions.update', $permission->id]]) !!}
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="name">Tên:</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ $permission->name or old('name') }}" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="guard_name">Guard Name:</label>
                    <input name="guard_name" type="text" class="form-control" id="guard_name" placeholder="Guard Name" value="{{ $permission->guard_name or old('guard_name') }}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="description">Mô tả:</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Description">{{ $permission->description or old('description') }}</textarea>
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