@extends('master')

@section('css')

@endsection
@section('js')

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
                <h3 class="card-title">Test thu</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'api.submit','method'=>'POST')) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}" >
                    </div>
                    <div class="form-group">
                      <label for="url">URL:</label>
                      <input name="url" type="text" class="form-control" id="url" placeholder="Enter Url" value="{{ old('url') }}">
                    </div>

                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();" >Submit</button>
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


<script type="text/javascript">

  $(".btn-submit").one('submit', function() {
    $(this).find('input[type="submit"]').attr('disabled','disabled');
    var name = $("input[name=name]").val();
    var url = $("input[name=url]").val();

    $.ajax({
      type:'POST',
      url: "{{ url('/').'/'.$backendUrl.'/submit' }}",
      data:{
        _token: $('meta[name="csrf-token"]').attr('content'),
        name:name,
        url:url
     },

      success:function(data){
        alert(data.success);
      }

    });

  });
</script>


@endsection