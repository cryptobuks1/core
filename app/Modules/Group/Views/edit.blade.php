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
                <h3 class="card-title">Tạo nhóm</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($group, ['method' => 'PATCH','route' => ['groups.update', $group->id]]) !!}
                <div class="card-body row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Tên nhóm:</label>
                      <input name="name" type="text" class="form-control" id="name" value="{{ $group->name or old('name') }}" >
                    </div>
                    <div class="form-group">
                      <label for="description">Mô tả:</label>
                      <textarea name="description" class="form-control">{{ $group->description or  old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="hideit">Ẩn trên trang chủ</label>

                      <input name="hideit" type="checkbox" value="hideit" data-toggle="toggle" style="display: none;" @if( $group->hideit == 1 ) checked="checked" @endif>
                      <div class="Switch Round @if($group->hideit == 1) On @else Off @endif" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="status">Trạng thái</label>
                        <input name="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if( $group->status == 1 ) checked="checked" @endif>
                        <div class="Switch Round @if($group->status == 1) On @else Off @endif" style="vertical-align:top;margin-left:10px;">
                            <div class="Toggle"></div>
                        </div>
                    </div>

                    
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thực hiện</button>
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