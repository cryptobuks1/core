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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thêm khối</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'blocks.store','method'=>'POST')) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="name">Tên khối:</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Tên khối" value="{{ old('name') }}" >
                    </div>
                    <div class="form-group">
                      <label for="key">Mã:</label>
                      <input name="key" type="text" class="form-control" id="key" placeholder="Mã để phân biệt các khối với nhau" value="{{ old('key') }}" >
                    </div>
                    <div class="form-group">
                      <label for="lang">Ngôn ngữ:</label>
                        <select class="form-control" name="lang">
                            @if(count($langs) > 0)
                                @foreach($langs as $lang)
                                    <option value="{{$lang['code']}}">{{$lang['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                      <div class="form-group">
                          <label for="widget">Widget:</label>
                          <select class="form-control" name="widget">
                              @if(count($widgets) > 0)
                                  @foreach($widgets as $widget)
                                      <option value="{{$widget}}">{{$widget}}</option>
                                  @endforeach
                              @endif
                          </select>
                      </div>
                    <div class="form-group">
                      <label for="position">Vị trí:</label>
                      <input name="position" type="text" class="form-control" id="position" placeholder="Vị trí" value="{{ old('position') }}" >
                    </div>
                    <div class="form-group">
                      <label for="url">Đường dẫn:</label>
                      <input name="url" type="text" class="form-control" id="url" placeholder="https://" value="{{ old('url') }}" >
                    </div>
                    <div class="form-group">
                      <label for="require_login">Yêu cầu đăng nhập:</label>
                      <input name="require_login" id="require_login" type="checkbox" value="require_login" data-toggle="toggle" style="display: none;">
                      <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="status">Trạng thái:</label>
                      <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
                      <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name">Thứ tự:</label>
                      <input name="sort" type="number" class="form-control" id="sort" value="0">
                    </div>

                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thêm khối</button>
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