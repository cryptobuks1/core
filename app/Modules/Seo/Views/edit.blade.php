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
                <h3 class="card-title">Sửa Seo meta</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              {!! Form::model($seo, ['method' => 'PATCH','route' => ['seo.update', $seo->id]]) !!}
                <div class="card-body row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Url:</label>
                      <input name="link" type="text" class="form-control" id="link" placeholder="Copy Url muốn tạo vào đây: http://" value="{{ $seo->link }}" readonly>
                    </div>
                    <div class="form-group">
                      <label style="display:block">Ảnh đại diện của trang</label>
                      <div class="preview">
                        <img id="logo-icon" class="imgPreview" src="{{url($seo->avatar)}}" />
                        <input type="hidden" name="avatar" id="avatar" class="inputImg"  value="" />
                      </div>
                      <button type="button" class="btn btn-primary" onclick="selectFileWithCKFinder('avatar', 'logo-icon')">Chọn ảnh</button>

                    </div>

                    <div class="form-group">
                      <label for="description">Ngôn ngữ:</label>
                      <select class="form-control" name="language">
                        @foreach($langs as $lang)
                          <option value="{{$lang->code}}" @if($lang->code == $seo->language) selected @endif>{{$lang->name}}</option>
                        @endforeach
                      </select>
                    </div>


                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title">Tiêu đề SEO:</label>
                      <input name="title" type="text" class="form-control" id="title" placeholder="Tối đa 70 ký tự" value="{{ $seo->title }}" required="true">
                    </div>
                    <div class="form-group">
                      <label for="description">Mô tả SEO:</label>
                      <textarea name="description" id="description" class="form-control" placeholder="Description" required="true">{{ $seo->description }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="h1">Thẻ H1:</label>
                      <input name="h1" type="text" class="form-control" id="h1" placeholder="Tối đa 70 ký tự" value="{{ $seo->h1 }}" required="true">
                    </div>

                    <div class="form-group">
                      <label for="noindex">Noindex/Noffolow:</label>
                      <select class="form-control" name="noindex">

                        <option value="0" @if($seo->noindex == 0) selected @endif>Không áp dụng</option>
                        <option value="1" @if($seo->noindex == 1) selected @endif>Áp dụng</option>

                      </select>
                    </div>


                  </div>

                </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
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