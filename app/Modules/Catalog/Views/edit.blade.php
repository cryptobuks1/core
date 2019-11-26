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
                <h3 class="card-title">Create Catalog</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($catalog, ['method' => 'PATCH','route' => ['catalogs.update', $catalog->id]]) !!}
                <div class="card-body row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ $catalog->name or old('name') }}" >
                    </div>
                    <div class="form-group">
                      <label for="url">URL:</label>
                      <input name="url" type="text" class="form-control" id="url" placeholder="Enter Url" value="{{ $catalog->url or  old('url') }}">
                    </div>
                    <div class="form-group">
                      <label for="description">Descriptions:</label>
                      <textarea name="description" id="description" class="form-control" placeholder="Description">{{ $catalog->description or  old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="public">Is Public ?</label>
                        <input name="public" type="checkbox" value="public" data-toggle="toggle" style="display: none;" @if( $catalog->public == 1 ) checked="checked" @endif>
                        <div class="Switch Round @if($catalog->public == 1) Off @else On @endif" style="vertical-align:top;margin-left:10px;">
                            <div class="Toggle"></div>
                        </div>
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
