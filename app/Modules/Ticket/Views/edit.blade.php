@extends('master')

@section('css')

@endsection
@section('js')
  @include('ckfinder::setup')
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
                <h3 class="card-title">Edit Weblink</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              {!! Form::model($weblink, ['method' => 'PATCH','route' => ['weblinks.update', $weblink->id]]) !!}
                <div class="card-body row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ $weblink->name }}" >
                    </div>
                    <div class="form-group">
                      <label for="url">URL:</label>
                      <input name="url" type="text" class="form-control" id="url" placeholder="Enter Url" value="{{ $weblink->url }}">
                    </div>
                    <div class="form-group">
                      <label for="description">Descriptions:</label>
                      <textarea name="description" id="description" class="form-control" placeholder="Description">{{ $weblink->description }}</textarea>
                    </div>


                  </div>

                  <div class="col-md-6">

                    <div class="form-group row">
                      <label for="url">Ảnh banner:</label>
                      <div>
                        <img id="logo-icon" class="imgPreview" src="@if($weblink->image){{ url($weblink->image) }}@endif"/>
                        <input type="hidden" name="image" id="image" class="inputImg"
                               value="{{ old('image') }}"/>
                      </div>
                      <div style="margin-left: 15px">
                        <button type="button" class="btn btn-default"
                                onclick="selectFileWithCKFinder('image', 'logo-icon')">Chọn ảnh
                        </button>

                      </div>


                    </div>

                    <div class="form-group">
                      <label for="status">Status:</label>
                      <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($weblink->status == 1) checked="checked" @endif>
                      <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name">Sort:</label>
                      <input name="sort" type="text" class="form-control" id="sort" placeholder="Sort" value="{{ $weblink->sort }}">
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