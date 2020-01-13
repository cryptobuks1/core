@extends('master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('js')
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
<script>
    $(function () {
        CKEDITOR.replace('content', {
            filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
        });
        CKEDITOR.config.extraPlugins = 'justify , colorbutton';
    });
</script>

@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      @include('layouts.errors')
<div class="card">

  <div class="card-header" style="border-bottom: 0">
    <h3 class="card-title">Lịch trình</h3>
  </div>
  <!-- /.card-header -->
    {!! Form::open(array('route' => ['tour.schedules.store', $tour->id],'method'=>'POST','enctype'=>'multipart/form-data')) !!}
    <div class="card-body row">
        <div class="tt-chung col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h3 style="color:#00aced;">Thêm lịch trình</h3>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thứ tự lịch trình:</label>
                        <input type="number" name="sort" class="form-control" placeholder="Nhập thứ tự lịch trình" value="{{old('sort')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lịch trình:</label>
                        <input type="text" name="place" class="form-control" placeholder="Nhập địa điểm của ngày hôm đó" value="{{old('place')}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="note">Mô tả:</label>
                        <textarea name="description" id="content" class="form-control"
                                  rows="30">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="col-md-12">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="{{ url($backendUrl.'/tour/schedules/'.$tour->id) }}" class="btn btn-warning">Đóng</a>
        </div>
    </div>
{!! Form::close() !!}
  <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
  <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection
