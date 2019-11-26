@extends('master')
@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2()
  });
</script>
@endsection

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
                <h3 class="card-title">Nhập thông tin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label for="name">Name:</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value="{{ $role->name or old('name') }}" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="guard_name">Guard Name:</label>
                    <input name="guard_name" type="text" class="form-control" id="guard_name" placeholder="Guard Name" value="{{ $role->guard_name or old('guard_name', 'web') }}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="description">Mô tả:</label>
                    <input name="description" type="text" class="form-control" id="description" value="{{ $role->description or old('description') }}">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="Permissions">Permissions:</label>
                    <select name="permission[]" class="form-control select2" multiple="multiple" data-placeholder="Select Permissions"
                          style="width: 100%;">
                      @foreach($permission as $value)
                        @if( in_array($value->id, $rolePermissions) )
                            <option value="{{ $value->id }}" selected="selected">{{ $value->name }}</option>
                        @else
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endif
                      
                      @endforeach
                    </select>
                  </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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