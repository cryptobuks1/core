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
                <h3 class="card-title">Edit Tag Item: {{ $item->label }}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($item, ['method' => 'PATCH','route' => ['tagitems.update', $item->id]]) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="title">Tag Id:</label>
                      <input name="tag_id" type="text" class="form-control" id="tag_id" placeholder="Tag Id" value="{{ $item->tag_id or old('tag_id') }}" >
                    </div>
                    <div class="form-group">
                      <label for="title">Item Id:</label>
                      <input name="item_id" type="text" class="form-control" id="item_id" placeholder="Item Id" value="{{ $item->item_id or old('item_id') }}" >
                    </div>
                    <div class="form-group">
                      <label for="url">Item Type:</label>
                      <select class="form-control" name="status" id="status" data-placeholder="Select a Type">
                        @foreach( config('tags.data') as $type )
                          <option value="{{ $type['id'] }}" @if($type['id']==$item->type) selected="selected" @endif>{{ $type['name'] }}</option>
                        @endforeach
                      </select>
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