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
                <h3 class="card-title">Edit User: {{ $user->name }}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                <div class="card-body row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="username">UserName:</label>
                      <input name="username" type="text" class="form-control" id="username" value="{{ $user->username }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="name">Full Name:</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Enter Full Name" value="{{ $user->name or old('name') }}">
                    </div>
                    <div class="form-group ">
                      <label for="email">Email:</label>
                      <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{{ $user->email}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                      <label for="phone">Number Phone:</label>
                      <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter Number Phone" value="{{ $user->phone or old('phone') }}">
                    </div>
                    <div class="form-group">
                      <label for="gender">Gender:</label>
                      {!! Form::select('gender', array('male'=>'Male','female'=>'Female','unknown'=>'Unknown'),$user->gender, array('class' => 'form-control')) !!}

                      
                    </div>
                    
                  </div>
                  <div class="col-md-6">
                    @hasrole('SUPER_ADMIN|ADMIN')
                        <div class="form-group ">
                          <label for="roles">Roles: </label>
                          {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control select2','multiple')) !!}
                        </div>
                    @else
                        
                    @endhasrole
                    

                    <div class="form-group ">
                      <label for="password">Password: </label>
                      <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="">
                    </div>
                    <div class="form-group ">
                      <label for="repassword">RePassword:</label>
                      <input name="password_confirmation" type="password" class="form-control" id="repassword" placeholder="Password" value="">
                    </div>


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